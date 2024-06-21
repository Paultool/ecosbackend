<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DecadaController;
use App\Http\Controllers\EscenaController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\PoligonoController;

Route::apiResource('decadas', DecadaController::class);
Route::apiResource('escenas', EscenaController::class);
Route::apiResource('contenidos', ContenidoController::class);
Route::apiResource('poligonos', PoligonoController::class);

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
