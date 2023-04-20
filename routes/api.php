<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\LugareController as Lugare;
use App\Http\Controllers\Api\V1\NoticiaController as Noticia;
use App\Http\Controllers\Api\V1\TourController as Tour;
use App\Http\Controllers\Api\V1\LibroController as Libro;
use App\Http\Controllers\Api\V1\ContactenoController as Contacteno;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/v1/lugares', Lugare::class);
Route::apiResource('/v1/noticias', Noticia::class);
Route::apiResource('/v1/tours', Tour::class);
Route::apiResource('/v1/libros', Libro::class);
Route::apiResource('/v1/contactenos', Contacteno::class);
