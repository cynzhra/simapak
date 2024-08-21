<?php

use App\Http\Controllers\PenilaianKinerjaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/kemampuan-teknis', [PenilaianKinerjaController::class, 'calculateKemampuanTeknis']);
Route::post('/kualitas-pekerjaan', [PenilaianKinerjaController::class, 'calculateKualitasPekerjaan']);
Route::post('/problem-solving', [PenilaianKinerjaController::class, 'calculateProblemSolving']);
Route::post('/kemampuan-beradaptasi', [PenilaianKinerjaController::class, 'calculateKemampuanBeradaptasi']);
Route::post('/kerjasama-tim', [PenilaianKinerjaController::class, 'calculateKerjasamaTim']);
Route::post('/aturan-etika', [PenilaianKinerjaController::class, 'calculateAturanEtika']);
Route::post('/penilaian-kinerja', [PenilaianKinerjaController::class, 'calculatePenilaianKinerja']);
