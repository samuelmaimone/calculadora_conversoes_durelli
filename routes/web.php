<?php

use App\Http\Controllers\calculadoraController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post('/converter', [calculadoraController::class, 'converterBin']);
Route::post('/converter-para-decimal', [calculadoraController::class, 'converterParaDecimal']);
Route::post('/converter-f3', [calculadoraController::class, 'converterAgrupamento']);
Route::post('/converter-f4', [calculadoraController::class, 'converterIntermediario']);

;