<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use Illuminate\Http\Request;

class EvaluasiController extends Controller
{
    public function index() {
        $soal = Soal::where('category', 'evaluasi')->get();
        return view('guru.evaluasi.index', compact('soal'));
    }

    public function create() {
        return view('guru.evaluasi.form');
    }

    public function store(Request $request) {
        $data = $request->all();
        $data['category'] = 'evaluasi'; // Paksa category jadi evaluasi
        $data['kuis_id'] = null; // Secara eksplisit set kuis_id menjadi null

        Soal::create($data);
        return redirect()->route('guru.evaluasi.index')->with('success', 'Soal evaluasi berhasil disimpan!');
    }

    public function edit($id) {
        $soal = Soal::findOrFail($id);
        return view('guru.evaluasi.form', compact('soal'));
    }

    public function update(Request $request, $id) {
        $soal = Soal::findOrFail($id);
        
        $data = $request->all();
        $data['category'] = 'evaluasi'; 
        $data['kuis_id'] = null; 

        $soal->update($data);
        return redirect()->route('guru.evaluasi.index')->with('success', 'Soal evaluasi berhasil diperbarui!');
    }

    public function destroy($id) {
        Soal::destroy($id);
        return back()->with('success', 'Soal evaluasi berhasil dihapus!');
    }
}