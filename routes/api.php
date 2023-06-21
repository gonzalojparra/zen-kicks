<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TimerController;

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

// Timer
Route::get('/seleccion/{idPasada}', [TimerController::class, 'seleccion']);
Route::get('/enviarTiempo/{tiempoTotal}.{idPasada}', [TimerController::class, 'enviarTiempo']);
Route::post('/iniciarTimer/{idPasada}', [TimerController::class, 'iniciarTimer']);
Route::post('/pararTimer/{idPasada}', [TimerController::class, 'pararTimer']);
Route::post('/resetearTimer/{idPasada}', [TimerController::class, 'resetearTimer']);

// Pulsador
Route::post('/cantJuecesn/{idPasada}', [PulsadorController::class, 'cantJueces']);
Route::post('/esperarTimern/{idPasada}', [PulsadorController::class, 'esperarTimer']);
Route::post('/enviarn/{idPasada}', [PulsadorController::class, 'enviar']);