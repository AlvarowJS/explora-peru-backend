<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Libro;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $libros = Libro::all();
        return response()->json($libros);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $libro = new Libro;
        $libro->nombre_completo = $request->nombre_completo;
        $libro->dni = $request->dni;
        $libro->telefono = $request->telefono;
        $libro->email = $request->email;
        $libro->padre = $request->padre;
        $libro->domicilio = $request->domicilio;
        $libro->pais = $request->pais;
        $libro->relacion = $request->relacion;
        $libro->monto_reclamado = $request->monto_reclamado;
        $libro->moneda_tipo = $request->moneda_tipo;
        $libro->descripcion = $request->descripcion;
        $libro->accion = $request->accion;
        $libro->detalle = $request->detalle;
        $libro->pedido = $request->pedido;
        $libro->save();
        return response()->json($libro);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            return response()->json($libro);
        } else {
            return response()->json(['error' => 'Libro de reclamacion no encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            $libro->nombre_completo = $request->nombre_completo;
            $libro->dni = $request->dni;
            $libro->telefono = $request->telefono;
            $libro->email = $request->email;
            $libro->padre = $request->padre;
            $libro->domicilio = $request->domicilio;
            $libro->pais = $request->pais;
            $libro->relacion = $request->relacion;
            $libro->monto_reclamado = $request->monto_reclamado;
            $libro->moneda_tipo = $request->moneda_tipo;
            $libro->descripcion = $request->descripcion;
            $libro->accion = $request->accion;
            $libro->detalle = $request->detalle;
            $libro->pedido = $request->pedido;
            $libro->save();
            return response()->json($libro);
        } else {
            return response()->json(['error' => 'Reclamo no encontrado'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            $libro->delete();
            return response()->json(['message' => 'Libro eliminado']);
        } else {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }
    }
}