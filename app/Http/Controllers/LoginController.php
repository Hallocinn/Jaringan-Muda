<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginController extends Controller
{
    public function show()
    {
        return view('login');
    }

    public function auth(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'nip_nisn' => 'required',
            'password' => 'required',
        ]);

        $remember = $request->has('checkRemember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'guru') {
                return redirect()->route('guru.dashboard')
                    ->with('success', 'Berhasil masuk sebagai Guru!');
            }

            return redirect()->route('dashboard')
                ->with('success', 'Berhasil masuk sebagai Siswa!');
        }

        return back()
            ->withErrors([
                'nip_nisn' => 'NIP/NISN atau Kata Sandi tidak cocok.',
            ])
            ->onlyInput('nip_nisn');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing', ['logout' => 'success'])
            ->with('success', 'Berhasil keluar!');
    }
}