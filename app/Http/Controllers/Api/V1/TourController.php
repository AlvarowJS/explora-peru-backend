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
        $carpeta = "tours";
        $ruta = public_path($carpeta);

        if (!\File::isDirectory($ruta)) {
            $publicPath = 'storage/' . $carpeta;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('img');
        $filesPDF = $request->file('archivo');
        if ($request->hasFile('img') || $request->hasFile('archivo')) {

            // foreach ($files as $file) {
            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));

            $nombrePDF = uniqid() . '.' . $filesPDF->getClientOriginalName();
            $pathPDF = $carpeta . '/' . $nombrePDF;
            \Storage::disk('public')->put($pathPDF, \File::get($filesPDF));
            // }
            $tour = new Tour([
                'lugare_id' => $request->lugare_id,
                'titulo' => $request->titulo,
                'descripcion_spanish' => $request->descripcion_spanish,
                'descripcion_english' => $request->descripcion_english,
                'incluye_spanish' => $request->incluye_spanish,
                'incluye_english' => $request->incluye_english,
                'no_incluye_spanish' => $request->no_incluye_spanish,
                'no_incluye_english' => $request->no_incluye_english,
                'duracion' => $request->duracion,
                'img' => $nombre,
                'archivo' => $nombrePDF

            ]);
            $tour->save();
            return "archivo guardado";

        } else {
            return "erro";
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
