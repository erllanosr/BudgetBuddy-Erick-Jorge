<?php

namespace App\Http\Controllers;

use App\Models\Transaccion;
use App\Models\CuentaBancaria;
use Illuminate\Http\Request;
use App\Models\Gasto;
use App\Models\Ingreso;

class TransaccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $userId = auth()->user()->id;
        $transacciones = Transaccion::where('usuario_id', $userId)->get();
        return response()->json($transacciones);
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
        //
    }

    /**
     * Transferir dinero entre cuentas bancarias.
     */
    public function transferir(Request $request)
    {

        $request->validate([
            'cb_origen_id' => 'required',
            'monto' => 'required',
            'descripcion' => 'required',
            'titular_cb_destino' => 'required',
            'fecha' => 'required',
            'numero_cb_destino' => 'required',
        ]);
        $cb_origen_id = $request->input('cb_origen_id');
        $numero_cuenta_destino = $request->input('numero_cb_destino');
        $montoTransferencia = $request->input('monto');
        $descripcion = $request->input('descripcion');
        $titular_cb_destino = $request->input('titular_cb_destino');
        $fecha = $request->input('fecha');
        $usuario_id = auth()->user()->id;

        //obtener cuenta origen
        $cuenta_origen = CuentaBancaria::where('id', $cb_origen_id)->first();
        //obtener cuenta destino
        $cuenta_destino = CuentaBancaria::where('numero_cuenta', $numero_cuenta_destino)->first();

        if (!$cuenta_origen) {
            return response()->json(['status' => 'error', 'message' => 'La cuenta de origen no existe']);
        }

        // Verificar que la cuenta de origen tenga fondos suficientes
        if ($cuenta_origen->monto < $montoTransferencia) {
            return response()->json(['status' => 'error', 'message' => 'La cuenta de origen no tiene fondos suficientes']);
        }

        // Verificar que la cuenta de destino exista
        if (!$cuenta_destino) {
            return response()->json(['status' => 'error', 'message' => 'La cuenta de destino no existe']);
        }
        // Actualizar los montos de las cuentas
        $cuenta_origen->monto = $cuenta_origen->monto - $montoTransferencia;
        $cuenta_destino->monto = $cuenta_destino->monto + $montoTransferencia;
        $cuenta_origen->save();
        $cuenta_destino->save();

        // Crear el registro de gasto
        $gasto = new Gasto();
        $gasto->monto = $montoTransferencia;
        $gasto->descripcion = $descripcion;
        $gasto->fecha = $fecha;
        $gasto->usuario_id = $usuario_id;
        $gasto->save();
        // Crear el registro de ingreso
        // $ingreso = new Ingreso();
        // $ingreso->monto = $montoTransferencia;
        // $ingreso->descripcion = $descripcion;
        // $ingreso->fecha = $fecha;
        // $ingreso->usuario_id = $usuario_id;
        // $ingreso->save();

        // Crear el registro de transferencia
        $transferencia = new Transaccion();
        $transferencia->cb_origen_id = $cb_origen_id;
        $transferencia->monto = $montoTransferencia;
        $transferencia->descripcion = $descripcion;
        $transferencia->fecha = $fecha;
        $transferencia->titular_cb_destino = $titular_cb_destino;
        $transferencia->numero_cb_destino = $numero_cuenta_destino;
        $transferencia->usuario_id = $usuario_id;
        $transferencia->save();

        return response()->json(['status' => 'success']);
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
