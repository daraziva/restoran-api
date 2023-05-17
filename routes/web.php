<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestoController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/restos', [RestoController::class, 'index']);
Route::post('/restos/tambah-data', [RestoController::class, 'store']);
Route::get('/generate-token', [RestoController::class, 'createToken']);
Route::get('/restos/{id}', [RestoController::class, 'show']);
Route::patch('/restos/update/{id}', [RestoController::class, 'update']);
Route::delete('/restos/delete/{id}', [RestoController::class, 'destroy']);
Route::get('/restos/show/trash', [RestoController::class, 'trash']);
Route::get('/restos/trash/restore/{id}', [RestoController::class, 'restore']);
Route::get('/restos/trash/delete/{id}', [RestoController::class, 'permanentDelete']);