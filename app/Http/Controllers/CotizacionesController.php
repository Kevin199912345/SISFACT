<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Product;
use App\Models\Cotizaciones;
use App\Models\CotizacionesDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CotizacionesController extends Controller
{
    public function searchClientes(Request $request){
        $query = $request->input('query');
    
        $clients = Cliente::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('id_number', 'LIKE', "%{$query}%")
                    ->get(); 

        return response()->json(['data' => $clients]);
    }

    public function searchProductos(Request $request){
        $query = $request->input('query');

        $productos = Product::where('name', 'LIKE', "%{$query}%")
                        ->orWhere('barcode', 'LIKE', "%{$query}%")
                        ->get(); 

        return response()->json(['data' => $productos]);
    }

    public function searchCotizacionList(Request $request) {
        $query = $request->input('query', '');
    
        $cotizaciones = Cotizaciones::with('cliente') // Asegúrate de cargar la relación del cliente
            ->where('numero_cotizacion', 'LIKE', "%{$query}%")
            ->orWhereHas('cliente', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orderBy('id', 'desc') // Ordena por la fecha de creación en orden descendente
            ->paginate(10);
    
        return response()->json($cotizaciones);
    }
    

    public function getNextNumber()
    {
        $nextNumber = str_pad(Cotizaciones::count() + 1, 9, '0', STR_PAD_LEFT);
        return response()->json(['nextNumber' => $nextNumber]);
    }

    public function show($id)
    {
        $cotizacion = Cotizaciones::with(['cliente', 'productos'])->findOrFail($id);
        return response()->json($cotizacion);
    }


    public function store(Request $request)
{
    // Validar los datos
    $validatedData = $request->validate([
        'num_cotizacion' => 'required|unique:cotizaciones,numero_cotizacion',
        'client_id' => 'required|exists:clientes,id',
        'fecha_creacion' => 'required|date',
        'fecha_vencimiento' => 'required|date|after_or_equal:fecha_creacion',
        'observaciones' => 'nullable|string',
        'credito' => 'nullable|boolean',
        'plazo' => 'nullable|integer|min:1',
        'productos' => 'required|array',
        'productos.*.barcode' => 'required|string',
        'productos.*.description' => 'required|string',
        'productos.*.precio_unitario' => 'required|numeric|min:0',
        'productos.*.quantity' => 'required|integer|min:1',
        'productos.*.discount' => 'nullable|numeric|min:0|max:100',
        'productos.*.taxes' => 'required|numeric|min:0|max:100',
        'productos.*.total' => 'required|numeric|min:0'
    ]);

    try {
        DB::beginTransaction();

        // Guardar una nueva cotización
        $cotizacion = Cotizaciones::create([
            'numero_cotizacion' => $validatedData['num_cotizacion'],
            'id_cliente' => $validatedData['client_id'],
            'start_date' => $validatedData['fecha_creacion'],
            'end_date' => $validatedData['fecha_vencimiento'],
            'terms' => $validatedData['observaciones'],
             // Subtotal: precio * cantidad
    'subtotal' => array_sum(array_map(function($producto) {
        return $producto['precio_unitario'] * $producto['quantity'];
    }, $validatedData['productos'])),

    // Total descuentos: calcular el monto del descuento para cada producto y sumarlos
    'total_discounts' => array_sum(array_map(function($producto) {
        $productSubtotal = $producto['precio_unitario'] * $producto['quantity'];
        return $productSubtotal * ($producto['discount'] / 100);
    }, $validatedData['productos'])),

    // Total impuestos: aplicar los impuestos sobre el subtotal después del descuento
    'total_taxes' => array_sum(array_map(function($producto) {
        $productSubtotal = $producto['precio_unitario'] * $producto['quantity'];
        $subtotalAfterDiscount = $productSubtotal - ($productSubtotal * ($producto['discount'] / 100));
        return $subtotalAfterDiscount * ($producto['taxes'] / 100);
    }, $validatedData['productos'])),

    // Total general: el subtotal después de descuentos más los impuestos
    'total' => array_sum(array_map(function($producto) {
        $productSubtotal = $producto['precio_unitario'] * $producto['quantity'];
        $subtotalAfterDiscount = $productSubtotal - ($productSubtotal * ($producto['discount'] / 100));
        $taxAmount = $subtotalAfterDiscount * ($producto['taxes'] / 100);
        return $subtotalAfterDiscount + $taxAmount;
    }, $validatedData['productos'])),
            'credito' => $request->has('credito') ? 1 : 0,
            'plazo' => $request->input('plazo'),
            'status' => 'pendiente'
        ]);

        // Guardar los productos de la nueva cotización
        foreach ($validatedData['productos'] as $producto) {
            CotizacionesDetails::create([
                'cotizacion_id' => $cotizacion->id,
                'barcode' => $producto['barcode'],
                'description' => $producto['description'],
                'quantity' => $producto['quantity'],
                'precio_unitario' => $producto['precio_unitario'],
                'discount' => $producto['discount'],
                'taxes' => $producto['taxes'],
                'total' => $producto['total']
            ]);
        }

        DB::commit();
        return response()->json(['message' => 'Cotización guardada exitosamente'], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Hubo un error al guardar la cotización: ' . $e->getMessage()], 500);
    }
}

public function update(Request $request, $id)
{
    // Validar los datos
    $validatedData = $request->validate([
        'num_cotizacion' => 'required|unique:cotizaciones,numero_cotizacion,' . $id,
        'client_id' => 'required|exists:clientes,id',
        'fecha_creacion' => 'required|date',
        'fecha_vencimiento' => 'required|date|after_or_equal:fecha_creacion',
        'observaciones' => 'nullable|string',
        'credito' => 'nullable|boolean',
        'plazo' => 'nullable|integer|min:1',
        'productos' => 'required|array',
        'productos.*.barcode' => 'required|string',
        'productos.*.description' => 'required|string',
        'productos.*.precio_unitario' => 'required|numeric|min:0',
        'productos.*.quantity' => 'required|integer|min:1',
        'productos.*.discount' => 'nullable|numeric|min:0|max:100',
        'productos.*.taxes' => 'required|numeric|min:0|max:100',
        'productos.*.total' => 'required|numeric|min:0'
    ]);

    try {
        DB::beginTransaction();

        // Obtener la cotización existente
        $cotizacion = Cotizaciones::findOrFail($id);

        // Actualizar la cotización
        $cotizacion->update([
            'numero_cotizacion' => $validatedData['num_cotizacion'],
            'id_cliente' => $validatedData['client_id'],
            'start_date' => $validatedData['fecha_creacion'],
            'end_date' => $validatedData['fecha_vencimiento'],
            'terms' => $validatedData['observaciones'],
             // Subtotal: precio * cantidad
    'subtotal' => array_sum(array_map(function($producto) {
        return $producto['precio_unitario'] * $producto['quantity'];
    }, $validatedData['productos'])),

    // Total descuentos: calcular el monto del descuento para cada producto y sumarlos
    'total_discounts' => array_sum(array_map(function($producto) {
        $productSubtotal = $producto['precio_unitario'] * $producto['quantity'];
        return $productSubtotal * ($producto['discount'] / 100);
    }, $validatedData['productos'])),

    // Total impuestos: aplicar los impuestos sobre el subtotal después del descuento
    'total_taxes' => array_sum(array_map(function($producto) {
        $productSubtotal = $producto['precio_unitario'] * $producto['quantity'];
        $subtotalAfterDiscount = $productSubtotal - ($productSubtotal * ($producto['discount'] / 100));
        return $subtotalAfterDiscount * ($producto['taxes'] / 100);
    }, $validatedData['productos'])),

    // Total general: el subtotal después de descuentos más los impuestos
    'total' => array_sum(array_map(function($producto) {
        $productSubtotal = $producto['precio_unitario'] * $producto['quantity'];
        $subtotalAfterDiscount = $productSubtotal - ($productSubtotal * ($producto['discount'] / 100));
        $taxAmount = $subtotalAfterDiscount * ($producto['taxes'] / 100);
        return $subtotalAfterDiscount + $taxAmount;
    }, $validatedData['productos'])),
            'status' => $cotizacion->status,
            'credito' => $request->has('credito') ? 1 : 0,
            'plazo' => $request->input('plazo')
        ]);

        // Manejar productos de la cotización
        CotizacionesDetails::where('cotizacion_id', $cotizacion->id)->delete();
        foreach ($validatedData['productos'] as $producto) {
            CotizacionesDetails::create([
                'cotizacion_id' => $cotizacion->id,
                'barcode' => $producto['barcode'],
                'description' => $producto['description'],
                'quantity' => $producto['quantity'],
                'precio_unitario' => $producto['precio_unitario'],
                'discount' => $producto['discount'],
                'taxes' => $producto['taxes'],
                'total' => $producto['total']
            ]);
        }

        DB::commit();
        return response()->json(['message' => 'Cotización actualizada exitosamente'], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Hubo un error al actualizar la cotización: ' . $e->getMessage()], 500);
    }
}

public function generatePDF($id)
{
    // Obtener la cotización y sus detalles
    $cotizacion = Cotizaciones::with('cliente', 'productos')->findOrFail($id);

    // Pasar la cotización a una vista
    $pdf = Pdf::loadView('cotizaciones.pdf', compact('cotizacion'));

    // Descargar el PDF
    return $pdf->stream('cotizacion_' . $cotizacion->numero_cotizacion . '.pdf');
}

    

}



