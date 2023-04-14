<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;
use App\Models\Noticia;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noticias = Noticia::all();
        return response()->json($noticias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $noticia = new Noticia();
        $noticia->titulo = $request->input('titulo');
        $noticia->nota = $request->input('nota');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = uniqid() . '.' .$file->getClientOriginalName();
            $path = $file->storeAs('public/noticias', $fileName);
            $noticia->img = $fileName;
        }

        $noticia->save();
        return response()->json($noticia);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $noticia = Noticia::find($id);
        return response()->json($noticia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $noticia = Noticia::find($id);
        $noticia->titulo = $request->input('titulo');
        $noticia->nota = $request->input('nota');

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $fileName = uniqid() . '.' .$file->getClientOriginalName();
            $file->storeAs('public/noticias', $fileName);
            $noticia->img = $fileName;
        }

        $noticia->save();
        return response()->json($noticia);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $noticia = Noticia::find($id);
        $noticia->delete();
        return response()->json('Noticia eliminada correctamente.');
    }
}
