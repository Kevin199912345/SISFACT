<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function list()
    {
        $clients = Cliente::where('status', 1)->get();

        return response()->json($clients);
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }
        return response()->json($cliente);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_id' => 'required|string|max:2',
            'id_number' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'commercial_name' => 'nullable|string|max:255',
            'fecha_nacimiento' => 'nullable|date',
            'phone' => 'required|numeric|min:0',
            'email' => 'required|string|max:255',
            'provincia' => 'nullable|string',
            'canton' => 'nullable|string',
            'distrito' => 'nullable|string',
            'barrio' => 'nullable|string|max:255',
            'otras_senas' => 'nullable|string|max:255',
        ]);


        // Guardar el producto
        $client = new Cliente();
        $client->type_id = $request->tipo_id;
        $client->id_number = $request->id_number;
        $client->name = $request->name;
        $client->commercial_name = $request->commercial_name;
        $client->fecha_nacimiento = $request->fecha_nacimiento;
        $client->phone = $request->phone;
        $client->email = $request->email;
        $client->province = $request->provincia;
        $client->canton = $request->canton;
        $client->district = $request->distrito;
        $client->barrio = $request->barrio; 
        $client->other_signs = $request->otras_senas;
        $client->save();
        

        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        $clientId = $request->input('client_id_edit');
        $client = Cliente::find($clientId);

        if ($client) {
            $client->update([
                'type_id' => $request->input('tipo_id_edit'),
                'id_number' => $request->input('id_number_edit'),
                'name' => $request->input('name_edit'),
                'commercial_name' => $request->input('commercial_name_edit'),
                'fecha_nacimiento' => $request->input('fecha_nacimiento_edit'),
                'phone' => $request->input('phone_edit'),
                'email' => $request->input('email_edit'),
                'province' => $request->input('provincia_edit'),
                'canton' => $request->input('canton_edit'),
                'district' => $request->input('distrito_edit'),
                'barrio' => $request->input('barrio_edit'),
                'other_signs' => $request->input('otras_senas_edit'),
                'status' => $request->input('status_edit')
            ]);

            return response()->json(['message' => 'Cliente actualizado correctamente'], 200);
        }

        return response()->json(['message' => 'Cliente no encontrado'], 404);
    }

    public function changeStatus(Request $request)
    {
        $client = Cliente::find($request->id);
        if ($client) {
            $client->status = $request->status;
            $client->save();
            return response()->json(['message' => 'Estado actualizado correctamente']);
        }
        return response()->json(['message' => 'Cliente no encontrado'], 404);
    }




    public function searchClientList(Request $request) {
        $query = $request->input('query', '');
    
        $clients = Cliente::where('name', 'LIKE', "%{$query}%")
                            ->orWhere('id_number', 'LIKE', "%{$query}%")
                            ->orderBy('status', 'desc')
                            ->orderBy('id', 'desc')
                            ->paginate(30);  // Aquí usamos la paginación de Laravel
    
        return response()->json($clients);
    }

    public function search(Request $request)
    {
        $name = $request->input('name');
        $clients = clients::where('name', 'LIKE', "%{$name}%")->first();

        if ($clients) {
            return response()->json($clients);
        } else {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public function provincias()
    {
        $path = public_path('storage/json/provincias.json');
        return response()->file($path);
    }

    public function cantones()
    {
        $path = public_path('storage/json/cantones.json');
        return response()->file($path);
    }

    public function distritos()
    {
        $path = public_path('storage/json/distritos.json');
        return response()->file($path);
    }
}
