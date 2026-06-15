<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

class NilaiController extends Controller
{
    public function index(Request $request) 
    {
        // Mengambil semua data siswa beserta relasi nilainya secara langsung
        $siswas = Siswa::with('nilais')->latest()->get();

        // Mengirim data ke view (variabel kita ubah namanya menjadi $siswas agar lebih ringkas)
        return view('guru.nilai.nilai', compact('siswas'));
    }
}