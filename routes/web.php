<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenilaianKinerjaController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/penilaian', function () {
    return Inertia::render('PenilaianKinerja');
})->middleware(['auth', 'verified'])->name('penilaian');

Route::get('/formpenilaian', function () {
    return Inertia::render('FormPenilaian');
})->middleware(['auth', 'verified'])->name('formpenilaian');

Route::get('/form', function () {
    return Inertia::render('Form');
})->middleware(['auth', 'verified'])->name('form');

Route::get('/akhir', function () {
    return Inertia::render('Akhir');
})->middleware(['auth', 'verified'])->name('akhir');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/kemampuan-teknis', [PenilaianKinerjaController::class, 'calculateKemampuanTeknis']);
Route::get('api/get-kemampuan-teknis', [PenilaianKinerjaController::class, 'getKemampuanTeknis']);
Route::put('/kemampuan-teknis/{id}', [PenilaianKinerjaController::class, 'editKemampuanTeknis']);

Route::post('/kualitas-pekerjaan', [PenilaianKinerjaController::class, 'calculateKualitasPekerjaan']);
Route::get('api/get-kualitas-pekerjaan', [PenilaianKinerjaController::class, 'getKualitasPekerjaan']);
Route::put('/kualitas-pekerjaan/{id}', [PenilaianKinerjaController::class, 'editKualitasPekerjaan']);

Route::post('/problem-solving', [PenilaianKinerjaController::class, 'calculateProblemSolving']);
Route::get('api/get-problem-solving', [PenilaianKinerjaController::class, 'getProblemSolving']);
Route::put('/problem-solving/{id}', [PenilaianKinerjaController::class, 'editProblemSolving']);


Route::post('/kemampuan-beradaptasi', [PenilaianKinerjaController::class, 'calculateKemampuanBeradaptasi']);
Route::get('api/get-kemampuan-beradaptasi', [PenilaianKinerjaController::class, 'getKemampuanBeradaptasi']);
Route::put('/kemampuan-beradaptasi/{id}', [PenilaianKinerjaController::class, 'editKemampuanBeradaptasi']);


Route::post('/kerjasama-tim', [PenilaianKinerjaController::class, 'calculateKerjasamaTim']);
Route::get('api/get-kerjasama-tim', [PenilaianKinerjaController::class, 'getKerjasamaTim']);
Route::put('/kerjasama-tim/{id}', [PenilaianKinerjaController::class, 'editKerjasamaTim']);


Route::post('/aturan-etika', [PenilaianKinerjaController::class, 'calculateAturanEtika']);
Route::get('api/get-aturan-etika', [PenilaianKinerjaController::class, 'getKualitasPekerjaan']);
Route::put('/aturan-etika/{id}', [PenilaianKinerjaController::class, 'editKualitasPekerjaan']);


Route::post('/penilaian-kinerja', [PenilaianKinerjaController::class, 'calculatePenilaianKinerja']);


Route::get('api/karyawan', [KaryawanController::class, 'index']);
require __DIR__.'/auth.php';