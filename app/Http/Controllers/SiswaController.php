<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::latest()->get(); 
        
        return view('guru.siswa.data-siswa', compact('siswa')); 
    }

    public function store(Request $request)
    {
        // Validasi input disesuaikan dengan nip_nisn
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nip_nisn' => 'required|numeric|unique:users,nip_nisn' // Wajib diisi dan tidak boleh ganda
        ], [
            'nip_nisn.unique' => 'NISN ini sudah terdaftar pada sistem!',
            'email.unique' => 'Email ini sudah terdaftar!'
        ]);

        // 1. Buat Akun Login Siswa di tabel 'users'
        User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password), 
            'nip_nisn' => $request->nip_nisn, // Gunakan nip_nisn
            'role'     => 'siswa',
        ]);

        // 2. Buat Profil Nilai di tabel 'siswas'
        Siswa::create([
            'nama'  => $request->nama,
            'nilai' => 0,
        ]);

        return back()->with('success', 'Akun login dan data siswa berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
        ]);

        $siswa = Siswa::findOrFail($id);
        
        $siswa->update([
            'nama'  => $request->nama,
        ]);

        return back()->with('success', 'Data nama siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        
        User::where('name', $siswa->nama)->delete(); 
        $siswa->delete();

        return back()->with('success', 'Data siswa dan akun loginnya berhasil dihapus!');
    }
}
