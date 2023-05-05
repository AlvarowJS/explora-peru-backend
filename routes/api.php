<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\LugareController as Lugare;
use App\Http\Controllers\Api\V1\NoticiaController as Noticia;
use App\Http\Controllers\Api\V1\TourController as Tour;
use App\Http\Controllers\Api\V1\LibroController as Libro;
use App\Http\Controllers\Api\V1\ContactenoController as Contacteno;
use App\Http\Controllers\Api\AuthController as Auth;
use App\Http\Controllers\Api\V1\TarifaController as Tarifa;
use App\Http\Controllers\Api\V1\CircuitoController as Circuito;
use App\Http\Controllers\Api\V1\PromoController as Promo;
use App\Http\Controllers\Api\V1\DiaController as Dia;

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
// Usuario
Route::post('/login', [Auth::class, 'login']);
Route::post('/register', [Auth::class, 'register']);
Route::put('/active-user/{id}', [Auth::class, 'activeUser']);
Route::put('/desactivate-user/{id}', [Auth::class, 'desactivateUser']);
Route::get('/all-users', [Auth::class, 'listarUsuarios']);
Route::delete('/delete-users/{id}', [Auth::class, 'deleteUsuario']);

// Tarifas
Route::apiResource('/v1/tarifa', Tarifa::class);
Route::get('/v1/tarifa-user/{id}', [Tarifa::class, 'listarTarifa']);

// Circuitos
Route::apiResource('/v1/circuitos', Circuito::class);
Route::apiResource('/v1/dias', Dia::class);

//Promos
Route::apiResource('/v1/promos', Promo::class);

// Route::get('/v1/tarifa', [Tarifa::class, 'index']);
// Route::get('/v1/tarifa/{id}', [Tarifa::class, 'show']);
// Route::put('/v1/tarifa/{id}', [Tarifa::class, 'update']);
// Route::post('/v1/tarifa', [Tarifa::class, 'store']);

Route::apiResource('/v1/lugares', Lugare::class);

Route::middleware('cors')->group(function () {
    Route::apiResource('/v1/noticias', Noticia::class);
});
// Route::apiResource('/v1/noticias', Noticia::class);
// Route::middleware('cors')->apiResource('/v1/noticias', Noticia::class);


Route::patch('/v1/noticias-img/{id}', [Noticia::class, 'updateImg']);
Route::apiResource('/v1/tours', Tour::class);
Route::apiResource('/v1/libros', Libro::class);
Route::apiResource('/v1/contactenos', Contacteno::class);

Route::put('/v1/tour-update/{id}', [Tour::class, 'updateTour']);
