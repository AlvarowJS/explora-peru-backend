<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Contacteno;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactenoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactenos = Contacteno::all();
        return response()->json($contactenos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $contacteno = new Contacteno;
        $contacteno->nombre = $request->nombre;
        $contacteno->email = $request->email;
        $contacteno->celular = $request->celular;
        $contacteno->mensaje = $request->mensaje;
        $contacteno->save();
        return response()->json($contacteno);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Contacteno = Contacteno::find($id);
        if ($Contacteno) {
            return response()->json($Contacteno);
        } else {
            return response()->json(['error' => 'Contacteno de reclamacion no encontrado'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contactenos = Contacteno::find($id);
        if ($contactenos) {
            $contactenos->nombre = $request->nombre;
            $contactenos->email = $request->email;
            $contactenos->telefono = $request->telefono;
            $contactenos->mensaje = $request->mensaje;
            $contactenos->save();
            return response()->json($contactenos);
        } else {
            return response()->json(['error' => 'Reclamo no encontrado'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contactenos = Contacteno::find($id);
        if ($contactenos) {
            $contactenos->delete();
            return response()->json(['message' => 'Contacteno eliminado']);
        } else {
            return response()->json(['error' => 'Contacteno no encontrado'], 404);
        }
    }
}