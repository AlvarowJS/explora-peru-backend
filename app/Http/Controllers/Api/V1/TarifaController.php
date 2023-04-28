<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tarifa;
use Illuminate\Http\Request;

class TarifaController extends Controller
{
    public function listarTarifa($id)
    {
        // return "hola";
        $tarifa = Tarifa::with('user')->where('users_id', $id)->get();
        return response()->json($tarifa); 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $tarifa = Tarifa::with('user')->get();
        return response()->json($tarifa);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $carpeta = "tarifario";
        $ruta = public_path($carpeta);
        if (!\File::isDirectory($ruta)) {
            $publicPath = 'storage/' . $carpeta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('archivo');

        if ($request->hasFile('archivo')) {
            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));

            $tarifa = new Tarifa([
                'nombre_tarifa' => $request->nombre_tarifa,
                'users_id' => $request->users_id,
                'archivo' => $nombre,
            ]);
            $tarifa->save();
        } else {
            return "error";
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tarifa = Tarifa::find($id);
        
        return response()->json($tarifa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $carpeta = "tarifario";
        $ruta = public_path($carpeta);
        if (!\File::isDirectory($ruta)) {
            $publicPath = 'storage/' . $carpeta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        
        $files = $request->file('archivo');

        if ($request->hasFile('archivo')) {
            
            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));

            $tarifa = Tarifa::find($id);
            $tarifa->update([
                'nombre_tarifa' => $request->nombre_tarifa,
                'users_id' => $request->users_id,
                'archivo' => $nombre
            ]);
            return response()->json([$tarifa], 200);
        } else {
            return "error";
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Tarifa::destroy($id);
        return response()->json(null, 204);
    }
}