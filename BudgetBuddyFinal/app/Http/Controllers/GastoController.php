<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Gasto;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\PDF;
// use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GastosExport;
// use PDF;
use Illuminate\Support\Facades\View;
class GastoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function sumaTotal(){
        $userId = Auth::id();
        $sumaTotal = Gasto::where('usuario_id', $userId)->sum('monto');
        return response()->json(['suma_total' => $sumaTotal]);
    }
    public function index()
    {
        $userId = Auth::id();
        $gastos = Gasto::where('usuario_id', $userId)->get();
        // $sumaTotal = Gasto::where('usuario_id', $userId)->sum('monto');
        return response()->json($gastos);
        // $ingresos = Ingreso::with('user')->get();
        // return inertia('Ingresos/Index', compact('ingresos'));
    }

    public function exportarPDF()
    {
        $user = Auth::user();

        $gastos = Gasto::where('usuario_id', $user->id)->get();
        $imagen = public_path('images/nuevoLogo.svg');

        $data = [
            'gastos' => $gastos,
            'imagen' => $imagen,
        ];
        $pdf = PDF::loadView('gastos', compact('gastos'), $data);

        return $pdf->download('gastos.pdf');
    }

    public function exportarExcel()
    {
        $user = Auth::user();

        $gastos = Gasto::where('usuario_id', $user->id)->get();

        return Excel::download(new GastosExport($gastos), 'gastos.xlsx');
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




        $gasto = new Gasto();
        $gasto->descripcion = $request->input('descripcion');
        $gasto->monto = -abs($request->input('monto'));
        $gasto->fecha = $request->input('fecha');

        $gasto->usuario_id = auth()->user()->id;
        $gasto->save();
        return redirect('/expenses')->with('success', 'Tarjeta agregada exitosamente');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $gasto = Gasto::find($id);
        $gasto->descripcion = $request->input('descripcion');
        $gasto->monto = -abs($request->input('monto'));
        $gasto->fecha = $request->input('fecha');
        $gasto->usuario_id = auth()->user()->id;
        $gasto->update();

        return redirect('/expenses');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $gasto = Gasto::find($id);

        $gasto->delete();
        return redirect('/expenses');
    }
}
