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
   
        $tour = new Tour();
        $tour->titulo = $request->input('titulo');
        $tour->descripcion_spanish = $request->input('descripcion_spanish');
        $tour->descripcion_english = $request->input('descripcion_english');
        $tour->incluye_spanish = $request->input('incluye_spanish');
        $tour->incluye_english = $request->input('incluye_english');
        $tour->duracion = $request->input('duracion');
        $tour->lugare_id = $request->input('lugare_id');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = uniqid() . '.' .$file->getClientOriginalName();
            $path = $file->storeAs('public/tours', $fileName);
            $tour->img = $fileName;
        }

        $tour->save();
        return response()->json($tour);
        
    }

    public function show($id)
    {
        $tour = Tour::find($id);
        return response()->json($tour);
    }

    public function update(Request $request, $id)
    {
        $tour = Tour::find($id);
        $tour->update($request->all());
        return response()->json($tour, 200);
    }

    public function destroy($id)
    {
        Tour::destroy($id);
        return response()->json(null, 204);
    }
}
