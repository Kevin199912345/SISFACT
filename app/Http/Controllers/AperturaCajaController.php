<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\AperturaCaja;
use Illuminate\Support\Facades\Auth;

class AperturaCajaController extends Controller
{

    public function indexAperturaCaja()
    {
        $cajasedit = Caja::where('status', 1)->get();

        $cajas = Caja::where('status', 1)
            ->whereDoesntHave('aperturaCajas', function($query) {
                $query->where('status', 1);
            })
            ->get();

        // Obtener las aperturas de caja con status = 1
        $aperturaCajas = AperturaCaja::where('status', 1)
            ->with(['caja', 'usuario'])
            ->get();

        return view('cajas', ['cajas' => $cajas, 'aperturaCajas' => $aperturaCajas, 'cajasedit' => $cajasedit]);
    }


    public function storeAperturaCaja(Request $request)
    {
        $userId = Auth::id();


        $existingRecord = AperturaCaja::where('id_user_apertura', $userId)
                                ->where('status', 1)
                                ->first();

        if ($existingRecord) {
            return response()->json(['success' => false, 'message' => 'Ya tienes una caja abierta, haz cierre y apertura una nueva.'], 400);
        }

        $request->validate([
            'caja_id' => 'required|numeric',
            'monto_apertura' => 'required|numeric',
        ]);

        // Guardar la apertura de caja
        $apertura = new AperturaCaja();
        $apertura->id_caja = $request->caja_id;
        $apertura->monto_apertura = $request->monto_apertura;
        $apertura->id_user_apertura = $userId;
        $apertura->status = 1; 
        $apertura->save();

        return response()->json(['success' => true, 'message' => 'Apertura de caja creada con éxito']);
    }

    public function cierre(Request $request)
    {
        $AperturaClose = $request->input('apertura_id_cierre');
        $apertura = AperturaCaja::find($AperturaClose);

        if ($apertura) {
            $apertura->update([
                'monto_cierre' => $request->input('monto_cierre'),
                'status' => '0'
            ]);

            return response()->json(['message' => 'Cierre realizado correctamente'], 200);
        }

        return response()->json(['message' => 'Apertura no encontrada'], 404);
    }

    public function show($id)
    {
        $apertura = AperturaCaja::find($id);
        if (!$apertura) {
            return response()->json(['message' => 'Apertura no encontrada'], 404);
        }
        return response()->json($apertura);
    }


    public function update(Request $request)
    {
        $AperturaId = $request->input('apertura_id_edit');
        $apertura = AperturaCaja::find($AperturaId);

        if ($apertura) {
            $apertura->update([
                'id_caja' => $request->input('caja_id_edit'),
                'monto_apertura' => $request->input('monto_apertura_edit'),
            ]);

            return response()->json(['message' => 'Apertura actualizada correctamente'], 200);
        }

        return response()->json(['message' => 'Apertura no encontrada'], 404);
    }

    public function updateCierre(Request $request)
    {
        $AperturaId = $request->input('cierre_id_edit');
        $apertura = AperturaCaja::find($AperturaId);

        if ($apertura) {
            $apertura->update([
                'id_caja' => $request->input('caja_id_edit_cierre'),
                'monto_cierre' => $request->input('monto_cierre_edit'),
            ]);

            return response()->json(['message' => 'Cierre actualizado correctamente'], 200);
        }

        return response()->json(['message' => 'Cierre no encontrado'], 404);
    }

    public function listAperturas()
    {
        $aperturas = AperturaCaja::where('status', 0)
            ->with(['caja', 'usuario'])
            ->orderBy('id', 'desc')
            ->get();

        foreach ($aperturas as $apertura) {
            $apertura->profit = $apertura->monto_cierre - $apertura->monto_apertura;
        }

        return response()->json(['data' => $aperturas]);
    }



    

}
