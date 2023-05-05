<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                // 'lugares' => $request->input('lugares'),
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
    public function updateWithImage(Request $request)
    {
        $carpeta = "promos";
        $ruta = public_path($carpeta);

        $id = $request->id;
        $titulo = $request->titulo;
        $lugares = $request->lugares;
        $descripcion_spanish = $request->descripcion_spanish;
        $descripcion_english = $request->descripcion_english;
        $incluye_spanish = $request->incluye_spanish;
        $incluye_english = $request->incluye_english;
        $no_incluye_spanish = $request->no_incluye_spanish;
        $no_incluye_english = $request->no_incluye_english;
        $duracion = $request->duracion;

        $promos = DB::table('promos')
            ->where('promos.id', '=', $id)
            ->get();
        $tituloActual = $promos[0]->titulo;
        $imgActual = $promos[0]->img;
        $archivo_englishActual = $promos[0]->archivo_english;
        $archivo_spanishActual = $promos[0]->archivo_spanish;
        $files = $request->file('img');
        $filesSpanish = $request->file('archivo_english');
        $filesEnglish = $request->file('archivo_spanish');
        // Cambiara el nombre de la carpetea
        if ($tituloActual != $titulo) {
            \Storage::disk('public')->move($carpeta . '/' . $tituloActual, $carpeta . '/' . $titulo);
        }

        if ($request->hasFile('img')) {
            \Storage::disk('public')->delete($carpeta . '/' . $titulo . '/' . $imgActual);
            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $titulo . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));
            $updateImg = Promo::find($id);
            $updateImg->update([
                'img' => $nombre,
            ]);
        }
        if ($request->hasFile('archivo_english')) {
            \Storage::disk('public')->delete($carpeta . '/' . $titulo . '/' . $archivo_englishActual);
            $nombreEnglish = uniqid() . '.' . $filesEnglish->getClientOriginalName();
            $pathEnglish = $carpeta . '/' . $titulo . '/' . $nombreEnglish;
            \Storage::disk('public')->put($pathEnglish, \File::get($filesEnglish));
            $updateArchivoEnglish = Promo::find($id);
            $updateArchivoEnglish->update([
                'archivo_english' => $nombreEnglish,
            ]);
        }
        if ($request->hasFile('archivo_spanish')) {
            \Storage::disk('public')->delete($carpeta . '/' . $titulo . '/' . $archivo_spanishActual);
            $nombreSpanish = uniqid() . '.' . $filesSpanish->getClientOriginalName();
            $pathSpanish = $carpeta . '/' . $titulo . '/' . $nombreSpanish;
            \Storage::disk('public')->put($pathSpanish, \File::get($filesSpanish));
            $updateArchivoSpanish = Promo::find($id);
            $updateArchivoSpanish->update([
                'archivo_spanish' => $nombreSpanish,
            ]);
        }

        $updateData = Promo::find($id);
        $updateData->update([
            'titulo' => $titulo,
            'lugares' => $lugares,
            'descripcion_spanish' => $descripcion_spanish,
            'descripcion_english' => $descripcion_english,
            'incluye_spanish' => $incluye_spanish,
            'incluye_english' => $incluye_english,
            'no_incluye_spanish' => $no_incluye_spanish,
            'no_incluye_english' => $no_incluye_english,
            'duracion' => $duracion,
        ]);

        return response()->json([$updateData], 201);

    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promo = Promo::find($id);
        $carpeta = "promos";
        $titulo = $promo->titulo;
        \Storage::disk('public')->deleteDirectory($carpeta . '/' . $titulo);
        $promo->delete();
        return response()->json('Promocion eliminada correctamente.');
    }
}
