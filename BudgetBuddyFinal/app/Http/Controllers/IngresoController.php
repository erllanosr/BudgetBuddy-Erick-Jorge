<?php

namespace App\Http\Controllers;
use App\Exports\IngresosExport;

use Illuminate\Support\Facades\Auth;
use App\Models\Ingreso;
use Illuminate\Http\Request;
// use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class IngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function sumaTotal(){
        $userId = Auth::id();
        $sumaTotal = Ingreso::where('usuario_id', $userId)->sum('monto');
        return response()->json(['suma_total' => $sumaTotal]);
    }

    public function index()
    {
        $userId = Auth::id();
        $ingresos = Ingreso::where('usuario_id', $userId)->get();
        // $sumaTotal = Ingreso::where('usuario_id', $userId)->sum('monto');
        return response()->json($ingresos);
        // $ingresos = Ingreso::with('user')->get();
        // return inertia('Ingresos/Index', compact('ingresos'));
    }

    public function exportarPDF() {
        $user = Auth::user();

        $ingresos = Ingreso::where('usuario_id', $user->id)->get();

        $pdf = PDF::loadView('ingresos', compact('ingresos'));

        return $pdf->download('ingresos.pdf');

    }

    public function exportarExcel()
    {
    $user = Auth::user();

    $ingresos = Ingreso::where('usuario_id', $user->id)->get();

    return Excel::download(new IngresosExport($ingresos), 'ingresos.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'monto' => 'required',
            'fecha' => 'required',

        ], [
            'descripcion.required' => 'El nombre del titular es obligatorio.',
            'monto.required' => 'El número de tarjeta es obligatorio.',
            'fecha.required' => 'La fecha de expiración es obligatoria.',

        ]);




        $ingreso = new Ingreso();
        $ingreso->descripcion = $request->input('descripcion');
        $ingreso->monto = $request->input('monto');
        $ingreso->fecha = $request->input('fecha');

        $ingreso->usuario_id = auth()->user()->id;
        $ingreso->save();
        return redirect('/incomes');
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
    public function edit(String $id)
    {

        $ingreso = Ingreso::where('id', $id)->get();
        return response()->json($ingreso);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $ingreso = Ingreso::find($id);
    $ingreso->descripcion = $request->input('descripcion');
    $ingreso->monto = $request->input('monto');
    $ingreso->fecha = $request->input('fecha');
    $ingreso->usuario_id = auth()->user()->id;
    $ingreso->update();

    return redirect('/incomes');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $ingreso = Ingreso::find($id);

        $ingreso->delete();
        return redirect('/incomes');
    }
}
