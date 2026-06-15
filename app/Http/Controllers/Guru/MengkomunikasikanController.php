<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemahaman;

class MengkomunikasikanController extends Controller
{
    public function index()
    {
        // Tarik data asli dari database
        $pemahamans = Pemahaman::with('user')->orderBy('created_at', 'desc')->get();
        
        // Format ke dalam Array untuk dikirim ke Javascript
        $siswaData = $pemahamans->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->user ? $item->user->name : 'Siswa Dihapus',
                'materi' => $item->materi_slug, // materi1, materi2, materi3
                'jawaban' => $item->jawaban,
                'kesimpulan' => $item->kesimpulan,
                'nilai' => $item->nilai,
                'feedback' => $item->feedback,
                'statusPenilaian' => $item->nilai !== null ? 'sudah' : 'belum'
            ];
        });

        return view('guru.mengkomunikasikan', compact('siswaData'));
    }

    // Fungsi menyimpan nilai yang diberikan oleh Guru
    public function simpanPenilaian(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pemahamans,id',
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        $pemahaman = Pemahaman::find($request->id);
        $pemahaman->nilai = $request->nilai;
        $pemahaman->feedback = $request->feedback;
        $pemahaman->save();

        return response()->json(['status' => 'success']);
    }
}