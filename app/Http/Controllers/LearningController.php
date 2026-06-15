<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Siswa;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class LearningController extends Controller
{
    // Halaman Daftar Materi (Dashboard Materi)
    public function index()
    {
        $user = Auth::user();
        
        // 1. Ambil data materi yang sudah selesai dari tabel Progress
        $completedSteps = Progress::where('user_id', $user->id)
                                  ->where('is_completed', true)
                                  ->pluck('materi_slug')
                                  ->toArray();

        // 2. Ambil data nilai dari tabel Siswa dan Nilai 
        // (Mencocokkan nama akun login dengan nama di tabel siswas)
        $siswa = Siswa::where('nama', $user->name)->first();
        
        $nilais = [];
        if ($siswa) {
            $nilais = Nilai::where('siswa_id', $siswa->id)->pluck('nilai', 'jenis')->toArray();
        }

        // 3. Kalkulasi Progress: (3 Materi + 3 Kuis = Total 6 Tahap)
            // 3. Kalkulasi Progress: (Hanya hitung berdasarkan penyelesaian Kuis)
        $totalTahap = 3;
        $tahapSelesai = 0; 
        
        // Tambahkan tahap JIKA siswa sudah memiliki nilai kuis di database
        if (isset($nilais['kuis1'])) $tahapSelesai++;
        if (isset($nilais['kuis2'])) $tahapSelesai++;
        if (isset($nilais['kuis3'])) $tahapSelesai++;

        $progressPercent = ($totalTahap > 0) ? ($tahapSelesai / $totalTahap) * 100 : 0;

        // 4. Syarat Buka Evaluasi (Harus mengerjakan 3 Kuis)
        $isEligibleForEvaluasi = ($tahapSelesai >= $totalTahap);

        // Pastikan nama view sesuai dengan milik Anda (biasanya 'materi' atau 'materi.index')
        return view('materi', compact(
            'completedSteps', 
            'nilais', 
            'progressPercent', 
            'tahapSelesai', 
            'totalTahap', 
            'isEligibleForEvaluasi'
        ));
    }

    // Fungsi untuk menandai materi selesai
    public function completeMateri($slug)
    {
        Progress::updateOrCreate(
            ['user_id' => Auth::id(), 'materi_slug' => $slug],
            ['is_completed' => true]
        );

        return redirect()->back()->with('success', 'Materi selesai!');
    }
}