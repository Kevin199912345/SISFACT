<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\TaxType;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $taxTypes = TaxType::all(); // Obtener todos los tipos de impuestos
        return view('tables', compact('taxTypes'));
    }

    public function list()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function changeStatus(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            $product->status = $request->status;
            $product->save();
            return response()->json(['message' => 'Estado actualizado correctamente']);
        }
        return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    public function show($id)
    {
        $producto = Product::with(['taxTypeEdit'])  // Asegúrate de tener una relación taxType en tu modelo Product
                      ->find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json([
            'producto' => $producto
        ]);
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'barcode' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'productDescrip' => 'nullable|string|max:400',
            'price' => 'required|numeric|min:0',
            'tax_type_id' => 'required|numeric',
            'iva' => 'numeric|min:0',
            'priceVenta' => 'required|numeric|min:0',
            'stock' => 'numeric|min:0',
            'unidad_medida' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Manejar la subida de la imagen
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images', $imageName, 'public'); // Guarda en 'storage/app/public/images'
            $imageUrl = '/storage/images/' . $imageName; // URL relativa
        } else {
            $imageUrl = null; // O un valor por defecto si la imagen no es obligatoria
        }

        // Guardar el producto
        $product = new Product();
        $product->barcode = $request->barcode;
        $product->name = $request->name;
        $product->descripcion = $request->productDescrip;
        $product->price = $request->price;
        $product->tax_type_id_imp = $request->tax_type_id;
        $product->tax_percentage = $request->iva;
        $product->price_sell = $request->priceVenta;
        $product->stock = $request->stock;
        $product->unidad_medida = $request->unidad_medida;
        $product->image_url = $imageUrl; 
        $product->save();
        

        return response()->json(['success' => true]);
    }

    public function update(Request $request)
{
    // Validar los datos de entrada
    $validatedData = $request->validate([
        'editproductBarcode' => 'required|string|max:255',
        'editproductName' => 'required|string|max:255',
        'editproductDescrip' => 'nullable|string|max:400',
        'editproductPrice' => 'required|numeric|min:0',
        'editproductTaxType' => 'required|numeric',
        'editproductIVA' => 'numeric|min:0',
        'editproductPriceVenta' => 'required|numeric|min:0',
        'editproductStock' => 'numeric|min:0',
        'editunidad_medida' => 'nullable|string',
        'editproductImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $ProductId = $request->input('product_id_edit');
    $product = Product::find($ProductId);

    if ($product) {
        $updateData = [
            'barcode' => $validatedData['editproductBarcode'],
            'name' => $validatedData['editproductName'],
            'descripcion' => $validatedData['editproductDescrip'],
            'price' => $validatedData['editproductPrice'],
            'tax_type_id_imp' => $validatedData['editproductTaxType'],
            'tax_percentage' => $validatedData['editproductIVA'],
            'price_sell' => $validatedData['editproductPriceVenta'],
            'stock' => $validatedData['editproductStock'],
            'unidad_medida' => $validatedData['editunidad_medida'],
            'status' => $request->input('status_edit'),
        ];

        // Solo agregar image_url si el campo no viene vacío
        if ($request->filled('editproductImage')) {
            $updateData['image_url'] = $request->input('editproductImage');
        }

        $product->update($updateData);

        return response()->json(['message' => 'Producto actualizado correctamente'], 200);
    }

    return response()->json(['message' => 'Producto no encontrado'], 404);
}


    public function searchProductList(Request $request) {
        $query = $request->input('query', '');
    
        $products = Product::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('barcode', 'LIKE', "%{$query}%")
                            ->orderBy('id', 'desc')
                            ->paginate(10);  // Aquí usamos la paginación de Laravel
    
        return response()->json($products);
    }
    
    public function search(Request $request)
    {
        $barcode = $request->input('barcode');
        $product = Product::where('barcode', 'LIKE', "%{$barcode}%")->first();

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
    }
}


