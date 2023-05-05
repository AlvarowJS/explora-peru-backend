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
        $carpeta = "noticias";
        $ruta = public_path($carpeta);
        $titulo = $request->titulo;

        if (!\File::isDirectory($ruta)) {
            // $publicPath = 'storage/' . $carpeta;
            $publicPath = 'storage/' . $carpeta . '/' . $titulo;
            \File::makeDirectory($publicPath, 0777, true, true);
        }
        $files = $request->file('img');
        if ($request->hasFile('img') || $request->hasFile('archivo')) {

            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $titulo . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));

            $noticia = new Noticia([
                'titulo' => $request->titulo,
                'nota' => $request->nota,
                'titulo_ingles' => $request->titulo_ingles,
                'nota_ingles' => $request->nota_ingles,
                'img' => $nombre,

            ]);
            $noticia->save();
            return "archivo guardado";

        } else {
            return "erro";
        }

        ///////
        // $noticia = new Noticia();
        // $noticia->titulo = $request->input('titulo');
        // $noticia->nota = $request->input('nota');

        // if ($request->hasFile('img')) {
        //     $file = $request->file('img');
        //     $fileName = uniqid() . '.' .$file->getClientOriginalName();
        //     $path = $file->storeAs('public/noticias', $fileName);
        //     $noticia->img = $fileName;
        // }

        // $noticia->save();
        // return response()->json($noticia);
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
        $carpeta = "noticias";
        $tituloActual = $noticia->titulo;
        $tituloNuevo = $request->input('titulo');
        if (\Storage::disk('public')->exists($carpeta . '/' . $tituloActual)) {
            \Storage::disk('public')->move($carpeta . '/' . $tituloActual, $carpeta . '/' . $tituloNuevo);
        }
        $noticia->titulo = $request->input('titulo');
        $noticia->nota = $request->input('nota');
        $noticia->titulo_ingles = $request->input('titulo_ingles');
        $noticia->nota_ingles = $request->input('nota_ingles');

        // if ($request->hasFile('img')) {
        //     $file = $request->file('img');
        //     $fileName = uniqid() . '.' . $file->getClientOriginalName();
        //     $file->storeAs('public/noticias', $fileName);
        //     $noticia->img = $fileName;
        // }

        $noticia->save();
        return response()->json($noticia);
    }
    public function updateImg(Request $request, $id)
    {
        $carpeta = "noticias";
        $noticia = Noticia::find($id);
        // $noticia->titulo = $request->input('titulo');
        // $noticia->nota = $request->input('nota');
        $tituloActual = $noticia->titulo;
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $nombre = uniqid() . '.' . $file->getClientOriginalName();
            $path = $carpeta . '/' . $tituloActual . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($file));
            // $file->storeAs('public/noticias', $fileName);
            $noticia->img = $nombre;
            $noticia->save();
            return response()->json($noticia);
        }


    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $noticia = Noticia::find($id);
        $carpeta = "noticias";
        $titulo = $noticia->titulo;
        \Storage::disk('public')->deleteDirectory($carpeta . '/' . $titulo);
        $noticia->delete();
        return response()->json('Noticia eliminada correctamente.');
    }
}
