<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retiros;
use App\Models\AperturaCaja;
use Illuminate\Support\Facades\Auth;

class RetiroController extends Controller
{

    public function index()
    {
        $userId = Auth::id();
                    
        $aperturas = AperturaCaja::with(['caja'])
                        ->where('id_user_apertura', $userId)
                        ->where('status', 1)
                        ->get();

        $aperturasEdit = AperturaCaja::with(['caja'])
                        ->get();



        return view('retiros', compact('aperturas', 'aperturasEdit'));
    }

    public function show($id)
    {
        $retiros = Retiros::find($id);
        if (!$retiros) {
            return response()->json(['message' => 'Retiro no encontrado'], 404);
        }
        return response()->json($retiros);
    }

    public function update(Request $request)
    {
        $retiroId = $request->input('retiro_id_edit');
        $retiros = Retiros::find($retiroId);

        if ($retiros) {
            $retiros->update([
                'monto' => $request->input('monto_retiro_edit'),
                'motivo' => $request->input('motivo_edit')
            ]);

            return response()->json(['message' => 'Retiro actualizado correctamente'], 200);
        }

        return response()->json(['message' => 'Retiro no encontrado'], 404);
    }


    public function storeRetiro(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'apertura_id' => 'required|numeric',
            'monto_retiro' => 'required|numeric',
            'motivo' => 'required|string',
        ]);

        // Guardar la apertura de caja
        $retiros = new Retiros();
        $retiros->id_apertura = $request->apertura_id;
        $retiros->monto = $request->monto_retiro;
        $retiros->motivo = $request->motivo;
        $retiros->id_user_retiro = $userId;
        $retiros->save();

        return response()->json(['success' => true, 'message' => 'Retiro de caja realizado con éxito']);
    }

    public function searchRetiroList(Request $request) {
        $query = $request->input('query', '');
    
        $retiros = Retiros::with(['usuario', 'apertura.caja']) // Asegúrate de cargar la relación caja a través de apertura
                     ->whereHas('apertura.caja', function ($q) use ($query) {
                         $q->where('name', 'LIKE', "%{$query}%");
                     })
                     ->orWhereHas('usuario', function ($q) use ($query) {
                         $q->where('name', 'LIKE', "%{$query}%");
                     })
                     ->orderBy('id', 'desc')
                     ->paginate(10);
    
        return response()->json($retiros);
    }
    
    
}
