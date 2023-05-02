<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Dia;
use Illuminate\Http\Request;

class DiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dia = Dia::all();
        return response()->json($dia);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dia = new Dia([
            'circuito_id' => $request->circuito_id,
            'nombre' => $request->nombre,
            'horario' => $request->horario,
            'descripcion' => $request->descripcion,
            'nombre_english' => $request->nombre_english,
            'horario_english' => $request->horario_english,
            'descripcion_english' => $request->descripcion_english
        ]);
        $dia->save();
        return response()->json($dia);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dia $dia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dia $dia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dia $dia)
    {
        //
    }
}
