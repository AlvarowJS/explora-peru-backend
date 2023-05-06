<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Faker\Provider\Lorem;
use Illuminate\Http\Request;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;


class NoticiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
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
        $noticia->save();
        return response()->json($noticia);
    }
    public function updateImg(Request $request)
    {

        $carpeta = "noticias";
        $ruta = public_path($carpeta);
        $id = $request->id;
        $titulo = $request->titulo;
        $nota = $request->nota;
        $titulo_ingles = $request->titulo_ingles;
        $nota_ingles = $request->nota_ingles;

        $noticias = DB::table('noticias')
            ->where('noticias.id', '=', $id)
            ->get();
        $tituloActual = $noticias[0]->titulo;
        $imgActual = $noticias[0]->img;
        if ($tituloActual != $titulo) {
            \Storage::disk('public')->move($carpeta . '/' . $tituloActual, $carpeta . '/' . $titulo);
        }
        $files = $request->file('img');
        if ($request->hasFile('img')) {
            \Storage::disk('public')->delete($carpeta . '/' . $titulo . '/' . $imgActual);
            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $nombre = uniqid() . '.' . $files->getClientOriginalName();
            $path = $carpeta . '/' . $titulo . '/' . $nombre;
            \Storage::disk('public')->put($path, \File::get($files));
            $updateImg = Noticia::find($id);
            $updateImg->update([
                'img' => $nombre,
            ]);
        }
        $updateData = Noticia::find($id);
        $updateData->update([
            'titulo' => $titulo,
            'nota' => $nota,
            'titulo_ingles' => $titulo_ingles,
            'nota_ingles' => $nota_ingles,
        ]);
        return response()->json([$updateData], 201);

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

    public function eliminar($id)
    {
        $noticiaGet = Noticia::find($id);
        // return $noticiaGet;
        $carpeta = "noticias";
        $titulo = $noticiaGet->titulo;
        \DB::table('noticias')
            ->where('id', $id)
            ->delete();
        \Storage::disk('public')->deleteDirectory($carpeta . '/' . $titulo);
        return response()->json('Noticia eliminada correctamente.');

    }
}
