<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\Kuis;
use App\Models\Nilai; // Pastikan Model Nilai di-import
use Illuminate\Http\Request;

class KuisController extends Controller
{
    // =========================
    // LIST KUIS (Daftar Folder Kuis)
    // =========================
    public function list()
    {
        $kuis = Kuis::all();
        return view('guru.kuis.list', compact('kuis'));
    }

    // =========================
    // INDEX (Daftar Soal di Dalam Kuis)
    // =========================
    public function index(Request $request)
    {
        $kuis = Kuis::all();

        $soal = Soal::where('category', 'kuis')
            ->when($request->kuis_id, function ($query) use ($request) {
                $query->where('kuis_id', $request->kuis_id);
            })
            ->get();

        return view('guru.kuis.index', compact('soal', 'kuis'));
    }

    // =========================
    // CRUD SOAL (Create, Store, Edit, Update, Destroy)
    // =========================
    public function create()
    {
        $kuis = Kuis::all();
        return view('guru.kuis.form', compact('kuis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'tipe_soal' => 'required',
            'kunci' => 'required',
            'kuis_id' => 'required'
        ]);

        $data = $request->all();
        $data['category'] = 'kuis';

        // Bersihkan pilihan jika soal isian
        if ($request->tipe_soal == 'isian') {
            $data['a'] = $data['b'] = $data['c'] = $data['d'] = null;
        }

        Soal::create($data);

        return redirect()->route('guru.kuis.index', ['kuis_id' => $request->kuis_id])
                         ->with('success', 'Soal berhasil disimpan');
    }

    public function edit($id)
    {
        $soal = Soal::findOrFail($id);
        $kuis = Kuis::all();
        return view('guru.kuis.form', compact('soal', 'kuis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'tipe_soal' => 'required',
            'kunci' => 'required',
            'kuis_id' => 'required'
        ]);

        $soal = Soal::findOrFail($id);
        $data = $request->all();

        if ($request->tipe_soal == 'isian') {
            $data['a'] = $data['b'] = $data['c'] = $data['d'] = null;
        }

        $soal->update($data);

        return redirect()->route('guru.kuis.index', ['kuis_id' => $request->kuis_id])
                         ->with('success', 'Soal berhasil diperbarui');
    }

    public function destroy($id)
    {
        Soal::destroy($id);
        return back()->with('success', 'Soal berhasil dihapus');
    }

    // ============================================================
    // LOGIKA SIMPAN HASIL (Dijalankan setelah Siswa Submit Kuis)
    // ============================================================
    // ============================================================
    // LOGIKA SIMPAN HASIL (Maksimal 3x Percobaan)
    // ============================================================
    public function simpanHasil(Request $request) 
    {
        try {
            $siswaId = auth()->id(); // Pastikan ID ini nyambung ke tabel siswas jika foreign key-nya ke sana
            $jenisTugas = $request->jenis_tugas; // 'kuis 1', 'kuis 2', dll
            $skorBaru = $request->skor_hasil;

            // 1. Cek jumlah percobaan yang sudah dilakukan siswa untuk kuis ini
            $jumlahPercobaan = \App\Models\Nilai::where('siswa_id', $siswaId)
                                ->where('jenis', $jenisTugas)
                                ->count();

            // 2. Batasi maksimal 3x percobaan
            if ($jumlahPercobaan >= 3) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Batas maksimal 3 kali percobaan sudah habis!'
                ], 403);
            }

            // 3. Simpan sebagai percobaan baru
            \App\Models\Nilai::create([
                'siswa_id' => $siswaId, 
                'jenis'    => $jenisTugas, 
                'nilai'    => $skorBaru
            ]);

            return response()->json([
                'success' => true, 
                'message' => 'Nilai berhasil disimpan. Ini adalah percobaan ke-' . ($jumlahPercobaan + 1)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}