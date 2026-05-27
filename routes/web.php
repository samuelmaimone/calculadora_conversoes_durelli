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
Route::post('/converter-f6', [calculadoraController::class, 'suportarFracionarios']);
Route::post('/processar-csv', [calculadoraController::class, 'processarBatchCsv']);
Route::get('/quiz', [calculadoraController::class, 'iniciarQuiz']);
Route::post('/quiz', [calculadoraController::class, 'verificarQuiz']);
;