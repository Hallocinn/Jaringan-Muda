<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi disesuaikan: ubah nimInput jadi nip_nisn, dan tambah aturan 'unique'
        $request->validate([
            'namaInput' => 'required',
            'emailInput' => 'required|email|unique:users,email', 
            'nip_nisn' => 'required|numeric|unique:users,nip_nisn', 
            'passwordInput' => 'required|min:8|confirmed',
            'roleInput' => 'required|in:guru,siswa',
        ], [
            // Kustomisasi pesan error agar lebih ramah dibaca (Opsional)
            'nip_nisn.unique' => 'NIP/NISN ini sudah terdaftar!',
            'emailInput.unique' => 'Email ini sudah terdaftar!'
        ]);

        // Simpan data ke kolom yang sesuai
        $query = User::create([
            'name' => $request->namaInput,
            'email' => $request->emailInput,
            'nip_nisn' => $request->nip_nisn, // <--- Simpan ke kolom baru
            // 'NIK' => $request->nip_nisn, // (Opsional) Jika kolom NIK lama masih wajib diisi, bisa diisi data yang sama atau biarkan null jika sudah diizinkan null di DB.
            'password' => Hash::make($request->passwordInput),
            'role' => $request->roleInput
        ]);

        if ($query) {
            // Bisa tambahkan alert sukses via session jika mau
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login menggunakan NIP/NISN.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendaftar.');
        }
    }
}