<?php
use Barryvdh\Cors\HandleCors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArchivoController;

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

Route::post('/crear-archivo', [ArchivoController::class, 'crear']);
Route::get('/mostrar-archivo', [ArchivoController::class, 'mostrar']);
Route::put('/modificar-archivo/{id}', [ArchivoController::class, 'modificar']);
Route::delete('/borrar-archivo/{id}', [ArchivoController::class, 'borrar']);

