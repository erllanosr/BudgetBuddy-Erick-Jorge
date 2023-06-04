<?php

namespace App\Http\Controllers;

use App\Models\CuentaBancaria;
use App\Models\Transferencia;

use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $transferencias = Transferencia::all();
        // return view('transacciones.index', compact('transferencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required',
            'descripcion' => 'required',
            'numero_cb_destino' => 'required',
            'numero_cb_origen' => 'required',
            'titular_cb_destino' => 'required',
        ]);

        $transferencia = new Transferencia();
        $transferencia->usuario_id = auth()->user()->id;
        $transferencia->numero_cb_origen = $request->input('numero_cb_origen');
        $transferencia->monto = $request->input('monto');
        $transferencia->descripcion = $request->input('descripcion');
        $transferencia->numero_cb_destino = $request->input('numero_cb_destino');
        $transferencia->titular_cb_destino = $request->input('titular_cb_destino');
        $transferencia->save();

        return redirect()->route('transacciones');
    }

    public function transferir(Request $request)
    {
        $request->validate([
            'numero_cb_origen' => 'required',
            'numero_cb_destino' => 'required',
            'descripcion' => 'required',
            'monto' => 'required',
        ]);

        $cuentaOrigenId = $request->input('numero_cb_origen');
        $cuentaDestinoId = $request->input('numero_cb_destino');
        $descripcionTransferencia = $request->input('descripcion');
        $montoTransferencia = $request->input('monto');

        // Obtener las cuentas bancarias de origen y destino
        $cuentaOrigen = CuentaBancaria::where('numero_cuenta', $cuentaOrigenId)->firstOrFail();
        $cuentaDestino = CuentaBancaria::where('numero_cuenta', $cuentaDestinoId)->firstOrFail();

        // Verificar que la cuenta de origen tenga suficiente saldo
        if ($cuentaOrigen->monto < $montoTransferencia) {
            return response()->json(['message' => 'La cuenta de origen no tiene suficiente saldo.'], 422);
        }

        // Actualizar los saldos de las cuentas
        $cuentaOrigen->monto -= $montoTransferencia;
        $cuentaDestino->monto += $montoTransferencia;
        $cuentaOrigen->save();
        $cuentaDestino->save();

        // Crear el registro de transferencia
        $transferencia = new Transferencia();
        $transferencia->numero_cb_origen = $cuentaOrigenId;
        $transferencia->numero_cb_destino = $cuentaDestinoId;
        $transferencia->descripcion = $descripcionTransferencia;
        $transferencia->monto = $montoTransferencia;
        $transferencia->save();

        return redirect()->route('transacciones');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
