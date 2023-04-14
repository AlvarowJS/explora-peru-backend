<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::all();
        return response()->json($tours);
    }

    public function store(Request $request)
    {
        $tour = Tour::create($request->all());
        return response()->json($tour, 201);
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
