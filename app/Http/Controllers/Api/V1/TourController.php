<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use Illuminate\Support\Facades\DB;

class TourController extends Controller
{
    public function index()
    {
        // $tours = Tour::all();
        // return response()->json($tours);
        $tours = Tour::with('lugare')->get();

        return response()->json($tours);
    }

    public function store(Request $request)
    {
        $titulo = $request->titulo;
        $carpeta = "tours";
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

            $tour = new Tour([
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
            $tour->save();
            return response()->json($tour);
        } else {
            return "error";
        }

    }

    public function show($id)
    {
        $tour = Tour::find($id);
        return response()->json($tour);
    }

    public function updateTour(Request $request, $id)
    {

        $carpeta = "tours";
        $ruta = public_path($carpeta);

        if (!\File::isDirectory($ruta)) {
            $publicPath = 'storage/' . $carpeta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('img');
        if ($request->hasFile('img')) {
            return "hola";
            // foreach ($files as $file) {
            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));
            // }

            $tour = Tour::find($id);
            $tour->update([
                'lugare_id' => $request->lugare_id,
                'titulo' => $request->titulo,
                'descripcion_spanish' => $request->descripcion_spanish,
                'descripcion_english' => $request->descripcion_english,
                'incluye_spanish' => $request->incluye_spanish,
                'incluye_english' => $request->incluye_english,
                'no_incluye_spanish' => $request->no_incluye_spanish,
                'no_incluye_english' => $request->no_incluye_english,
                'duracion' => $request->duracion,
                'img' => $nombre
            ]);
            return response()->json([$tour], 200);

        } else {
            return "erro";
        }

    }
    public function updateWithImage(Request $request)
    {
        $carpeta = "tours";
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

        $tours = DB::table('tours')
            ->where('tours.id', '=', $id)
            ->get();
        $tituloActual = $tours[0]->titulo;
        $imgActual = $tours[0]->img;
        $archivo_englishActual = $tours[0]->archivo_english;
        $archivo_spanishActual = $tours[0]->archivo_spanish;

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
            $updateImg = Tour::find($id);
            $updateImg->update([
                'img' => $nombre,
            ]);
        }
        if ($request->hasFile('archivo_english')) {
            \Storage::disk('public')->delete($carpeta . '/' . $titulo . '/' . $archivo_englishActual);
            $nombreEnglish = uniqid() . '.' . $filesEnglish->getClientOriginalName();
            $pathEnglish = $carpeta . '/' . $titulo . '/' . $nombreEnglish;
            \Storage::disk('public')->put($pathEnglish, \File::get($filesEnglish));
            $updateArchivoEnglish = Tour::find($id);
            $updateArchivoEnglish->update([
                'archivo_english' => $nombreEnglish,
            ]);
        }
        if ($request->hasFile('archivo_spanish')) {
            \Storage::disk('public')->delete($carpeta . '/' . $titulo . '/' . $archivo_spanishActual);
            $nombreSpanish = uniqid() . '.' . $filesSpanish->getClientOriginalName();
            $pathSpanish = $carpeta . '/' . $titulo . '/' . $nombreSpanish;
            \Storage::disk('public')->put($pathSpanish, \File::get($filesSpanish));
            $updateArchivoSpanish = Tour::find($id);
            $updateArchivoSpanish->update([
                'archivo_spanish' => $nombreSpanish,
            ]);
        }

        $updateData = Tour::find($id);
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


    public function destroy($id)
    {
        $tour = Tour::find($id);
        $carpeta = "tours";
        $titulo = $tour->titulo;
        \Storage::disk('public')->deleteDirectory($carpeta . '/' . $titulo);
        $tour->delete();
        return response()->json(['message' => 'Tour eliminado con éxito.']);
    }
}
