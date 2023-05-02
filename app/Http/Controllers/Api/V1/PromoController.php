<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promo = Promo::all();
        return response()->json($promo);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $titulo = $request->titulo;
        $carpeta = "promos";
        $ruta = public_path($carpeta);
        if (!\File::isDirectory($ruta)) {
            $publicPath = 'storage/' . $carpeta . '/' . $titulo;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $filesSpanish = $request->file('archivo_english');
        $filesEnglish = $request->file('archivo_spanish');
        $files = $request->file('img');

        if ($request->hasFile('archivo_english') || $request->hasFile('archivo_spanish') || $request->hasFile('img')) {

            $nombreSpanish = uniqid() . '.' . $filesSpanish->getClientOriginalName();
            $pathSpanish = $carpeta . '/' . $titulo . '/' . $nombreSpanish;
            \Storage::disk('public')->put($pathSpanish, \File::get($filesSpanish));

            $nombreEnglish = uniqid() . '.' . $filesEnglish->getClientOriginalName();
            $pathEnglish = $carpeta . '/' . $titulo . '/' . $nombreEnglish;
            \Storage::disk('public')->put($pathEnglish, \File::get($filesEnglish));

            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $titulo . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));

            $promo = new Promo([
                'titulo' => $titulo,
                'lugares' => $request->lugares,
                'descripcion_spanish' => $request->descripcion_spanish,
                'descripcion_english' => $request->descripcion_english,
                'incluye_spanish' => $request->incluye_spanish,
                'incluye_english' => $request->incluye_english,
                'no_incluye_spanish' => $request->no_incluye_spanish,
                'no_incluye_english' => $request->no_incluye_english,
                'duracion' => $request->duracion,
                'img' => $nombre,
                'archivo_english' => $nombreEnglish,
                'archivo_spanish' => $nombreSpanish,
            ]);
            $promo->save();
            return response()->json($promo);
        } else {
            return "error";
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $promo = Promo::find($id);
        return response()->json($promo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promo $promo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promo = Promo::find($id);
        $promo->delete();
        return response()->json('Promocion eliminada correctamente.');
    }
}
