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
    public function show($id)
    {
        $promo = Dia::find($id);
        return response()->json($promo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dia = Dia::find($id);

        if (!$dia) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }

        $dia->circuito_id = $request->circuito_id;
        $dia->nombre = $request->nombre;
        $dia->horario = $request->horario;
        $dia->descripcion = $request->descripcion;
        $dia->nombre_english = $request->nombre_english;
        $dia->horario_english = $request->horario_english;
        $dia->descripcion_english = $request->descripcion_english;

        $dia->save();

        return response()->json($dia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dia = Dia::find($id);
        $dia->delete();
        return response()->json('Dia eliminada correctamente.');
    }
}
