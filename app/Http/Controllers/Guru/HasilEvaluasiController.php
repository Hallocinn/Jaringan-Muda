<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class HasilEvaluasiController extends Controller
{
    public function index()
    {
        // Mengambil semua siswa beserta nilai mereka
        $siswas = Siswa::with('nilais')->latest()->get();
        
        // Kita passing angka KKM (Kriteria Ketuntasan Minimal) agar Guru tahu siapa yang remedial
        $kkm = 75; 

        return view('guru.evaluasi.hasil', compact('siswas', 'kkm'));
    }
}