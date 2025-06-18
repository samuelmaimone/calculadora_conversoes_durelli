<?php

use App\Http\Controllers\calculadoraController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::post('/somar', [calculadoraController::class, 'somar']);
Route::post('/calcularSoma', [calculadoraController::class,'calcularSoma']);
Route::post('/subtrair', [calculadoraController::class, 'subtrair']);
Route::post('/calcularSubtracao', [calculadoraController::class,'calcularSubtracao']);
Route::post('/multiplicar', [calculadoraController::class, 'multiplicar']);
Route::post('/calcularMultiplicacao', [calculadoraController::class,'calcularMultiplicacao']);
Route::post('/dividir', [calculadoraController::class, 'dividir']);
Route::post('/calcularDivisao', [calculadoraController::class,'calcularDivisao']);