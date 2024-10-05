<?php

namespace App\Http\Controllers;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function list()
    {
        $proveedor = Proveedor::where('status', 1)->get();

        return response()->json($proveedor);
    }

    public function show($id)
    {
        $proveedor = Proveedor::find($id);
        if (!$proveedor) {
            return response()->json(['message' => 'Proveedor no encontrado'], 404);
        }
        return response()->json($proveedor);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_id' => 'required|string|max:2',
            'id_number' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'phone' => 'required|numeric|min:0',
            'email' => 'nullable|string|max:255',
            'contacto' => 'nullable|string',
            'phone_contacto' => 'nullable|string',
            'metodo_pago' => 'nullable|string',
            'cuenta_bancaria' => 'nullable|string|max:255',
        ]);


        // Guardar el proveedor
        $proveedor = new Proveedor();
        $proveedor->type_id = $request->type_id;
        $proveedor->id_number = $request->id_number;
        $proveedor->name = $request->name;
        $proveedor->direccion = $request->direccion;
        $proveedor->phone = $request->phone;
        $proveedor->email = $request->email;
        $proveedor->contacto = $request->contacto;
        $proveedor->phone_contacto = $request->phone_contacto;
        $proveedor->metodo_pago = $request->metodo_pago;
        $proveedor->cuenta_bancaria = $request->cuenta_bancaria; 
        $proveedor->save();
        

        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        $proveedorId = $request->input('proveedor_id_edit');
        $proveedor = Proveedor::find($proveedorId);

        if ($proveedor) {
            $proveedor->update([
                'type_id' => $request->input('type_id_edit'),
                'id_number' => $request->input('id_number_edit'),
                'name' => $request->input('name_edit'),
                'direccion' => $request->input('direccion_edit'),
                'phone' => $request->input('phone_edit'),
                'email' => $request->input('email_edit'),
                'contacto' => $request->input('contacto_edit'),
                'phone_contacto' => $request->input('phone_contacto_edit'),
                'metodo_pago' => $request->input('metodo_pago_edit'),
                'cuenta_bancaria' => $request->input('cuenta_bancaria_edit'),
                'status' => $request->input('status_edit')
            ]);

            return response()->json(['message' => 'Proveedor actualizado correctamente'], 200);
        }

        return response()->json(['message' => 'Proveedor no encontrado'], 404);
    }

    public function changeStatus(Request $request)
    {
        $proveedor = Proveedor::find($request->id);
        if ($proveedor) {
            $proveedor->status = $request->status;
            $proveedor->save();
            return response()->json(['message' => 'Estado actualizado correctamente']);
        }
        return response()->json(['message' => 'Proveedor no encontrado'], 404);
    }




    public function searchProveedorList(Request $request) {
        $query = $request->input('query', '');
    
        $proveedor = Proveedor::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('id_number', 'LIKE', "%{$query}%")
                            ->orderBy('status', 'desc')
                            ->orderBy('id', 'desc')
                            ->paginate(10);  // Aquí usamos la paginación de Laravel
    
        return response()->json($proveedor);
    }

    public function search(Request $request)
    {
        $name = $request->input('name');
        $proveedor = Proveedor::where('name', 'LIKE', "%{$name}%")->first();

        if ($proveedor) {
            return response()->json($proveedor);
        } else {
            return response()->json(['error' => 'Proveedor no encontrado'], 404);
        }
    }
}
