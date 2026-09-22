<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IdiomaController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\ExpansionController;
use App\Http\Controllers\BusquedaController;

Route::get('/busqueda-avanzada', [BusquedaController::class, 'index'])->name('busqueda.avanzada');

Route::get('/', function () {
    return redirect()->route('juegos.index');
});

Route::get('/juegos/busqueda', [JuegoController::class, 'busqueda'])->name('juegos.busqueda');

Route::resource('idiomas', IdiomaController::class);
Route::resource('juegos', JuegoController::class);
Route::resource('expansiones', ExpansionController::class);