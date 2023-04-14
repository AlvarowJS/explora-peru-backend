<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Lugare;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LugareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lugares = Lugare::all();
        return response()->json($lugares);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lugar = new Lugare;
        $lugar->nombre = $request->nombre;
        $lugar->save();
        return response()->json($lugar);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lugar = Lugare::find($id);
        if ($lugar) {
            return response()->json($lugar);
        } else {
            return response()->json(['error' => 'Lugar no encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lugar = Lugare::find($id);
        if ($lugar) {
            $lugar->nombre = $request->nombre;
            $lugar->save();
            return response()->json($lugar);
        } else {
            return response()->json(['error' => 'Lugar no encontrado'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lugar = Lugare::find($id);
        if ($lugar) {
            $lugar->delete();
            return response()->json(['message' => 'Lugar eliminado']);
        } else {
            return response()->json(['error' => 'Lugar no encontrado'], 404);
        }
    }
}
