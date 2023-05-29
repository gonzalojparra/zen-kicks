<?php

use App\Http\Controllers\CompetidorController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Security;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*  Route::get('/', function () {
     return view('welcome');
 }); */

/* Route::get('/', function () {
    return view('welcome');
})->name('home'); */
Route::get('/', function () {
    return view('/dashboard');
})->name('dashboard');
Route::get('/resultados', function () {
    return view('resultados');
})->name('resultados');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {



    Route::get('permisos', [Security\PermissionController::class, 'index'])->name('permisos.index');

    Route::get('roles', [Security\RolesController::class, 'index'])->name('roles.index');
});

Route::resource('competidores', CompetidorController::class);

Route::post('/competidores/create', [CompetidorController::class, 'buscarCompetidor'])->name('competidores.buscarCompetidor');

