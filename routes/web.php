<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Guru\KuisController;
use App\Http\Controllers\Guru\EvaluasiController;
use App\Http\Controllers\Guru\MonitoringController;
use App\Http\Controllers\Guru\HasilEvaluasiController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\MengkomunikasikanController;
use App\Http\Controllers\ChatController;

Route::redirect('/', '/landing');

// ==========================================
// AUTHENTICATION
// ==========================================
Route::get('/', function () {
    return view('landing');
})->name('landing');
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'auth'])->name('login.auth');
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('landing');
})->name('logout');

// ==========================================
// ROUTES SETELAH LOGIN
// ==========================================
Route::middleware('auth')->group(function () {

        // Global Chat (DIARAHKAN KE MONITORING CONTROLLER AGAR STATUS SESI TERBACA)
        Route::get('/messages/{topic}', [\App\Http\Controllers\Guru\MonitoringController::class, 'getMessages']);
        Route::post('/messages', [\App\Http\Controllers\Guru\MonitoringController::class, 'storeMessage']);

    // Halaman Umum
    Route::view('/kurikulum', 'kurikulum')->name('kurikulum');
    Route::view('/informasi', 'informasi')->name('informasi');

    // ------------------------------------------
    // AKSES SISWA
    // ------------------------------------------
    Route::middleware('cekRole:siswa')->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Materi
        // Materi
        Route::prefix('materi')->group(function () {
            Route::get('/', [LearningController::class, 'index'])->name('materi.index');
            Route::view('/1', 'materi.materi1')->name('materi1');
            Route::view('/2', 'materi.materi2')->name('materi2');
            Route::view('/3', 'materi.materi3')->name('materi3');
            Route::view('/ruang-diskusi', 'materi.diskusi')->name('siswa.diskusi');
            
            // Rute menandai materi selesai dibaca
            Route::post('/complete/{slug}', [LearningController::class, 'completeMateri'])->name('materi.complete');

            // --- TAMBAHKAN RUTE INI DI SINI ---
            Route::post('/simpan-pemahaman', function (\Illuminate\Http\Request $request) {
                $request->validate([
                    'materi_slug' => 'required',
                    'jawaban' => 'required',
                    'kesimpulan' => 'required'
                ]);

                \App\Models\Pemahaman::updateOrCreate(
                    [
                        'user_id' => \Illuminate\Support\Facades\Auth::id(), 
                        'materi_slug' => $request->materi_slug
                    ],
                    [
                        'jawaban' => $request->jawaban,
                        'kesimpulan' => $request->kesimpulan
                    ]
                );
                return response()->json(['status' => 'success']);
            })->name('materi.simpan_pemahaman');
            // -----------------------------------
        });

        // Kuis 1
        Route::get('/kuis/1', function () {
            $soal = \App\Models\Soal::where('category', 'kuis')->where('kuis_id', 8)->get();
            $siswa = \App\Models\Siswa::where('nama', Auth::user()->name)->first();
            $nilaiSudahAda = $siswa ? \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'kuis1')->value('nilai') : null;
            return view('materi.kuis1', compact('soal', 'nilaiSudahAda'));
        })->name('kuis1');

        Route::post('/kuis/1/simpan', function (\Illuminate\Http\Request $request) {
            $siswa = \App\Models\Siswa::firstOrCreate(['nama' => Auth::user()->name], ['nilai' => 0]);
            $nilaiLama = \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'kuis1')->first();
            if ($nilaiLama) {
                if ($request->skor > $nilaiLama->nilai) $nilaiLama->update(['nilai' => $request->skor]);
            } else {
                \App\Models\Nilai::create(['siswa_id' => $siswa->id, 'jenis' => 'kuis1', 'nilai' => $request->skor]);
            }
            return response()->json(['status' => 'success']);
        })->name('kuis1.simpan');

        // Kuis 2
        Route::get('/kuis/2', function () {
            $soal = \App\Models\Soal::where('category', 'kuis')->where('kuis_id', 9)->get();
            $siswa = \App\Models\Siswa::where('nama', Auth::user()->name)->first();
            $nilaiSudahAda = $siswa ? \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'kuis2')->value('nilai') : null;
            return view('materi.kuis2', compact('soal', 'nilaiSudahAda'));
        })->name('kuis2');

        Route::post('/kuis/2/simpan', function (\Illuminate\Http\Request $request) {
            $siswa = \App\Models\Siswa::firstOrCreate(['nama' => Auth::user()->name], ['nilai' => 0]);
            $nilaiLama = \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'kuis2')->first();
            if ($nilaiLama) {
                if ($request->skor > $nilaiLama->nilai) $nilaiLama->update(['nilai' => $request->skor]);
            } else {
                \App\Models\Nilai::create(['siswa_id' => $siswa->id, 'jenis' => 'kuis2', 'nilai' => $request->skor]);
            }
            return response()->json(['status' => 'success']);
        })->name('kuis2.simpan');

        // Kuis 3
        Route::get('/kuis/3', function () {
            $soal = \App\Models\Soal::where('category', 'kuis')->where('kuis_id', 10)->get();
            $siswa = \App\Models\Siswa::where('nama', Auth::user()->name)->first();
            $nilaiSudahAda = $siswa ? \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'kuis3')->value('nilai') : null;
            return view('materi.kuis3', compact('soal', 'nilaiSudahAda'));
        })->name('kuis3');

        Route::post('/kuis/3/simpan', function (\Illuminate\Http\Request $request) {
            $siswa = \App\Models\Siswa::firstOrCreate(['nama' => Auth::user()->name], ['nilai' => 0]);
            $nilaiLama = \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'kuis3')->first();
            if ($nilaiLama) {
                if ($request->skor > $nilaiLama->nilai) $nilaiLama->update(['nilai' => $request->skor]);
            } else {
                \App\Models\Nilai::create(['siswa_id' => $siswa->id, 'jenis' => 'kuis3', 'nilai' => $request->skor]);
            }
            return response()->json(['status' => 'success']);
        })->name('kuis3.simpan');

        // Evaluasi Akhir
        Route::get('/evaluasi', function () {
            $soal = \App\Models\Soal::where('category', 'evaluasi')->get();
            $siswa = \App\Models\Siswa::where('nama', Auth::user()->name)->first();
            
            $nilaiSudahAda = null;
            $isEligible = false; // Flag untuk mengecek kelayakan

            if ($siswa) {
                $nilaiSudahAda = \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'evaluasi')->value('nilai');
                
                // Syarat Buka Evaluasi: Punya nilai Kuis 1, 2, dan 3
                $k1 = \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'kuis1')->exists();
                $k2 = \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'kuis2')->exists();
                $k3 = \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'kuis3')->exists();
                
                if ($k1 && $k2 && $k3) {
                    $isEligible = true;
                }
            }

            return view('materi.evaluasi', compact('soal', 'nilaiSudahAda', 'isEligible'));
        })->name('evaluasi');

        Route::post('/evaluasi/simpan', function (\Illuminate\Http\Request $request) {
            $siswa = \App\Models\Siswa::firstOrCreate(['nama' => Auth::user()->name], ['nilai' => 0]);
            $nilaiLama = \App\Models\Nilai::where('siswa_id', $siswa->id)->where('jenis', 'evaluasi')->first();
            
            // Evaluasi hanya bisa diisi 1x, tidak ada penimpaan (update) nilai
            if (!$nilaiLama) {
                \App\Models\Nilai::create(['siswa_id' => $siswa->id, 'jenis' => 'evaluasi', 'nilai' => $request->skor]);
            }
            return response()->json(['status' => 'success']);
        })->name('evaluasi.simpan');

    });

    // ------------------------------------------
    // AKSES GURU
    // ------------------------------------------
    Route::middleware('cekRole:guru')->prefix('guru')->name('guru.')->group(function () {
        
        Route::get('/dashboard-guru', function () {
            $totalSiswa = \App\Models\Siswa::count();
            $totalSoal = \App\Models\Soal::count();
            $totalDiskusi = \App\Models\Message::count();

            $avgKuis1 = \App\Models\Nilai::where('jenis', 'kuis1')->avg('nilai') ?? 0;
            $avgKuis2 = \App\Models\Nilai::where('jenis', 'kuis2')->avg('nilai') ?? 0;
            $avgKuis3 = \App\Models\Nilai::where('jenis', 'kuis3')->avg('nilai') ?? 0;
            $avgEvaluasi = \App\Models\Nilai::where('jenis', 'evaluasi')->avg('nilai') ?? 0;

            $lulus = \App\Models\Nilai::where('jenis', 'evaluasi')->where('nilai', '>=', 75)->count();
            $remedial = \App\Models\Nilai::where('jenis', 'evaluasi')->where('nilai', '<', 75)->count();

            return view('guru.dashboard', compact('totalSiswa', 'totalSoal', 'totalDiskusi', 'avgKuis1', 'avgKuis2', 'avgKuis3', 'avgEvaluasi', 'lulus', 'remedial'));
        })->name('dashboard');

        // Siswa
        Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa');
        Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
        Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        Route::get('/data-siswa', function () { return view('guru.siswa.data-siswa'); })->name('siswa.data');

        // Monitoring
        Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
        Route::post('/monitoring/toggle-session', [MonitoringController::class, 'toggleSession'])->name('monitoring.toggle');

        // Nilai & Evaluasi
        Route::get('/hasil-evaluasi', [HasilEvaluasiController::class, 'index'])->name('hasil_evaluasi');
        Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
        Route::get('/mengkomunikasikan', [MengkomunikasikanController::class, 'index'])->name('mengkomunikasikan');
        Route::post('/mengkomunikasikan/simpan', [MengkomunikasikanController::class, 'simpanPenilaian'])->name('mengkomunikasikan.simpan');

        // Kuis & Soal
        Route::get('/kuis-list', [KuisController::class, 'list'])->name('kuis.list');
        Route::resource('kuis', KuisController::class);
        Route::resource('evaluasi', EvaluasiController::class);
        Route::post('/simpan-hasil', [KuisController::class, 'simpanHasil'])->name('simpan.hasil');
    });

});