<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Circuito;
use Illuminate\Http\Request;

class CircuitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $circuitos = Circuito::with('dias')->get();
        return response()->json($circuitos);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $titulo = $request->titulo;
        $incluye_spanish = $request->incluye_spanish;
        $incluye_english = $request->incluye_english;
        $no_incluye_spanish = $request->no_incluye_spanish;
        $no_incluye_english = $request->no_incluye_english;
        $duracion = $request->duracion;

        $carpeta = "circuitos";
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

            $circuito = new Circuito([
                'titulo' => $titulo,
                'incluye_spanish' => $incluye_spanish,
                'incluye_english' => $incluye_english,
                'no_incluye_spanish' => $no_incluye_spanish,
                'no_incluye_english' => $no_incluye_english,
                'duracion' => $duracion,
                'img' => $nombre,
                'archivo_english' => $nombreEnglish,
                'archivo_spanish' => $nombreSpanish,

            ]);
            $circuito->save();
            return response()->json($circuito);
        } else {
            return "error";
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $circuito = Circuito::with('dias')->find($id);
        return response()->json($circuito);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Circuito $circuito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $circuito = Circuito::find($id);
        $carpeta = "circuitos";
        $titulo = $circuito-> titulo;
        \Storage::disk('public')->deleteDirectory($carpeta . '/' . $titulo);
        $circuito->delete();
        return response()->json(['message' => 'Circuito eliminado con éxito.']);
    }
}
