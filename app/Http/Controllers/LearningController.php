<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;
use Illuminate\Support\Facades\Auth;

class LearningController extends Controller
{
    // Halaman Daftar Materi (Dashboard Materi)
    public function index()
    {
        $userId = Auth::id();
        
        // Ambil data materi yang sudah selesai
        $completedSteps = Progress::where('user_id', $userId)
                                   ->where('is_completed', true)
                                   ->pluck('materi_slug')
                                   ->toArray();

        // Hitung persentase (Contoh ada 3 materi)
        $totalMateri = 3;
        $progressPercent = (count($completedSteps) / $totalMateri) * 100;

        return view('materi', compact('completedSteps', 'progressPercent'));
    }

    // Fungsi untuk menandai materi selesai (Dipanggil lewat AJAX/Tombol)
    public function completeMateri($slug)
    {
        Progress::updateOrCreate(
            ['user_id' => Auth::id(), 'materi_slug' => $slug],
            ['is_completed' => true]
        );

        return redirect()->back()->with('success', 'Materi selesai!');
    }
}