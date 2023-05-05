<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tarifa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class TarifaController extends Controller
{
    public function listarTarifa($id)
    {
        // return "hola";
        $tarifa = Tarifa::with('user')->where('user_id', $id)->get();
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
        $nombre_tarifa = $request->nombre_tarifa;
        $ruta = public_path($carpeta);
        if (!\File::isDirectory($ruta)) {
            $publicPath = 'storage/' . $carpeta .'/'.$nombre_tarifa;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('archivo');

        if ($request->hasFile('archivo')) {
            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta.'/'. $nombre_tarifa. '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));

            $tarifa = new Tarifa([
                'nombre_tarifa' => $request->nombre_tarifa,
                'user_id' => $request->user_id,
                'archivo' => $nombre,
            ]);
            $tarifa->save();
            return response()->json($tarifa);
        } else {
            return "error";
        }
    }
    public function updateWithFile(Request $request)
    {

        $carpeta = "tarifario";
        $ruta = public_path($carpeta);
        $id = $request->id;
        $user_id = $request->user_id;
        $nombre_tarifa = $request->nombre_tarifa;


        $tarifas = DB::table('tarifas')
            ->where('tarifas.id', '=', $id)
            ->get();

        $nombre_tarifaActual = $tarifas[0]->nombre_tarifa;
        $imgActual = $tarifas[0]->archivo;
        if ($nombre_tarifaActual != $nombre_tarifa) {
            \Storage::disk('public')->move($carpeta . '/' . $nombre_tarifaActual, $carpeta . '/' . $nombre_tarifa);
        }
        $files = $request->file('archivo');
        if ($request->hasFile('archivo')) {
            \Storage::disk('public')->delete($carpeta . '/' . $nombre_tarifa . '/' . $imgActual);
            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $nombre_tarifa . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));
            $updateImg = Tarifa::find($id);
            $updateImg->update([
                'archivo' => $nombre,
            ]);
        }
        $updateData = Tarifa::find($id);
        $updateData->update([
            'nombre_tarifa' => $nombre_tarifa,
            'user_id' => $user_id,

        ]);
        return response()->json([$updateData], 201);

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
                'user_id' => $request->user_id,
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
