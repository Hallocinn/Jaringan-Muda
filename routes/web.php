<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LearningController;

/*
|--------------------------------------------------------------------------
| Web Routes - Jaringan Muda (Versi Aman)
|--------------------------------------------------------------------------
*/

// Halaman Landing
Route::get('/', function () {
    return view('home');
})->name('home');

// Dashboard Utama
Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
})->name('dashboard');

// Grouping Materi
Route::prefix('materi')->group(function () {
    // Daftar Materi (Halaman utama progres)
    Route::get('/', [LearningController::class, 'index'])->name('materi.index');

    // Detail Isi Materi
    Route::get('/1', function () { return view('materi.materi1'); })->name('materi1');
    Route::get('/2', function () { return view('materi.materi2'); })->name('materi2');
    Route::get('/3', function () { return view('materi.materi3'); })->name('materi3');

    // Route Kuis (TTS)
    // Mengarah ke: resources/views/materi/kuis1.blade.php
    Route::get('/kuis/1', function () { return view('materi.kuis1'); })->name('kuis1');
    Route::get('/kuis/2', function () { return view('materi.kuis2'); })->name('kuis2');
    Route::get('/kuis/3', function () { return view('materi.kuis3'); })->name('kuis3');

    // Simpan Progress
    Route::post('/complete/{slug}', [LearningController::class, 'completeMateri'])->name('materi.complete');
});

// Evaluasi
Route::get('/evaluasi', function () {
    return view('materi.evaluasi');
})->name('evaluasi');

// Placeholder
Route::get('/kurikulum', function () { return "Halaman Kurikulum sedang dikembangkan"; })->name('kurikulum');
Route::get('/informasi', function () { return "Halaman Informasi sedang dikembangkan"; })->name('informasi');