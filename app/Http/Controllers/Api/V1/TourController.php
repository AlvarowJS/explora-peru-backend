<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;

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
        // $tour = Tour::find($id);
        // if ($request->hasFile('img')) {
        //     $file = $request->file('img');
        //     $fileName = uniqid() . '.' . $file->getClientOriginalName();
        //     $path = $file->storeAs('public/tours', $fileName);
        //     $tour->img = $fileName;
        // }
        // $tour->update($request->all());
        // return response()->json($tour, 200);

    }

    public function destroy($id)
    {
        Tour::destroy($id);
        return response()->json(null, 204);
    }
}
