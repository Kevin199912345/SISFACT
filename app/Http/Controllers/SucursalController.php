<?php

namespace App\Http\Controllers;
use App\Models\Sucursal;
use App\Models\Caja;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function indexSucursal()
    {
        $sucursales = Sucursal::all(); // Obtener todos los tipos de impuestos
        return view('mantenimiento', compact('sucursales'));
    }

    public function listSucursal()
    {
        $sucursal = Sucursal::all();

        return response()->json($sucursal);
    }

    public function changeStatusSucursal(Request $request)
    {
        $sucursal = Sucursal::find($request->id);
        if ($sucursal) {
            $sucursal->status = $request->status;
            $sucursal->save();
            return response()->json(['message' => 'Estado actualizado correctamente']);
        }
        return response()->json(['message' => 'Sucursal no encontrada'], 404);
    }

    public function showSucursal($id)
    {
        $sucursal = Sucursal::find($id);

        if (!$sucursal) {
            return response()->json(['message' => 'Sucursal no encontrado'], 404);
        }

        return response()->json([
            'sucursal' => $sucursal
        ]);
    }

    public function storeSucursal(Request $request)
    {
        
        $request->validate([
            'codigo_sucursal' => 'required|numeric',
            'name' => 'required|string',
            'direccion' => 'nullable|string|max:400',
            'telefono' => 'required|numeric|min:0',
            'email' => 'nullable|string',
        ]);

        // Guardar el sucursal
        $sucursal = new Sucursal();
        $sucursal->codigo_sucursal = $request->codigo_sucursal;
        $sucursal->name = $request->name;
        $sucursal->direccion = $request->direccion;
        $sucursal->telefono = $request->telefono;
        $sucursal->email = $request->email;
        $sucursal->save();
        

        return response()->json(['success' => true]);
    }

    public function updateSucursal(Request $request)
{
    // Validar los datos de entrada
    $validatedData = $request->validate([
        'codigo_sucursal_edit' => 'required|numeric',
        'name_edit' => 'required|string',
        'direccion_edit' => 'nullable|string|max:400',
        'telefono_edit' => 'required|numeric|min:0',
        'email_edit' => 'nullable|string',
    ]);

    $SucursalId = $request->input('sucursal_id_edit');
    $sucursal = Sucursal::find($SucursalId);

    if ($sucursal) {
        $updateData = [
            'codigo_sucursal' => $validatedData['codigo_sucursal_edit'],
            'name' => $validatedData['name_edit'],
            'direccion' => $validatedData['direccion_edit'],
            'telefono' => $validatedData['telefono_edit'],
            'email' => $validatedData['email_edit'],
            'status' => $request->input('status_edit'),
        ];


        $sucursal->update($updateData);

        return response()->json(['message' => 'Sucursal actualizada correctamente'], 200);
    }

    return response()->json(['message' => 'Sucursal no encontrada'], 404);
}


    public function searchSucursalListSucursal(Request $request) {
        $query = $request->input('query', '');
    
        $sucursal = Sucursal::where('codigo_sucursal', 'LIKE', "%{$query}%")
                            ->orWhere('name', 'LIKE', "%{$query}%")
                            ->orderBy('status', 'desc')
                            ->orderBy('id', 'desc')
                            ->paginate(5);  // Aquí usamos la paginación de Laravel
    
        return response()->json($sucursal);
    }
    
    public function searchSucursal(Request $request)
    {
        $codigo_sucursal = $request->input('codigo_sucursal');
        $sucursal = Sucursal::where('codigo_sucursal', 'LIKE', "%{$codigo_sucursal}%")->first();

        if ($sucursal) {
            return response()->json($sucursal);
        } else {
            return response()->json(['error' => 'Sucursal no encontrada'], 404);
        }
    }



    /************************* Caja *************************************************/

    public function listCaja()
    {
        $caja = Caja::all();

        return response()->json($caja);
    }

    public function changeStatusCaja(Request $request)
    {
        $caja = Caja::find($request->id);
        if ($caja) {
            $caja->status = $request->status;
            $caja->save();
            return response()->json(['message' => 'Estado actualizado correctamente']);
        }
        return response()->json(['message' => 'Caja no encontrada'], 404);
    }

    public function showCaja($id)
    {
        $caja = Caja::find($id);

        if (!$caja) {
            return response()->json(['message' => 'Caja no encontrado'], 404);
        }

        return response()->json([
            'caja' => $caja
        ]);
    }

    public function storeCaja(Request $request)
    {
        
        $request->validate([
            'codigo_caja' => 'required|numeric',
            'name_caja' => 'required|string',
            'sucursal_id' => 'required|numeric',
        ]);

        // Guardar el caja
        $caja = new Caja();
        $caja->codigo_caja  = $request->codigo_caja;
        $caja->name = $request->name_caja;
        $caja->sucursal_id  = $request->sucursal_id;
        $caja->save();
        

        return response()->json(['success' => true]);
    }

    public function updateCaja(Request $request)
{
    // Validar los datos de entrada
    $validatedData = $request->validate([
        'codigo_caja_edit' => 'required|numeric',
        'name_caja_edit' => 'required|string',
        'sucursal_caja_id_edit' => 'required|numeric',
    ]);

    $CajaId = $request->input('caja_id_edit');
    $caja = Caja::find($CajaId);

    if ($caja) {
        $updateData = [
            'codigo_caja' => $validatedData['codigo_caja_edit'],
            'name' => $validatedData['name_caja_edit'],
            'sucursal_id' => $validatedData['sucursal_caja_id_edit'],
            'status' => $request->input('status_edit_caja'),
        ];


        $caja->update($updateData);

        return response()->json(['message' => 'Caja actualizada correctamente'], 200);
    }

    return response()->json(['message' => 'Caja no encontrada'], 404);
}


    public function searchCajaList(Request $request) {
        $query = $request->input('query', '');
    
        $caja = Caja::with('sucursal') // Cargar la relación sucursal
                ->where('codigo_caja', 'LIKE', "%{$query}%")
                ->orWhere('name', 'LIKE', "%{$query}%")
                ->orderBy('status', 'desc')
                ->orderBy('id', 'desc')
                ->paginate(5);  // Aquí usamos la paginación de Laravel
    
        return response()->json($caja);
    }
    
    public function searchCaja(Request $request)
    {
        $codigo_caja = $request->input('codigo_caja');
        $caja = Caja::where('codigo_caja', 'LIKE', "%{$codigo_caja}%")->first();

        if ($caja) {
            return response()->json($caja);
        } else {
            return response()->json(['error' => 'Caja no encontrada'], 404);
        }
    }
}