<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    /**
     * Proses login (bisa dengan Email atau NIS).
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'identifier' => 'required', // Bisa Email atau NIS
            'password'   => 'required',
        ]);

        // Coba autentikasi menggunakan Email atau NIS
        $credentials = [
            filter_var($request->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'nis' => $request->identifier,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect berdasarkan role
            return $user->role === 'admin'
                ? redirect()->route('admin.dashboard')->with('success', 'Selamat datang Admin!')
                : redirect()->route('dashboardSantri')->with('success', 'Selamat datang Santri!');
        }

        return back()->withErrors(['identifier' => 'NIS/Email atau Password salah.']);
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    /**
     * Tampilkan form register (khusus santri).
     */
    public function showRegister()
    {
        return view('pages.auth.register');
    }

    /**
     * Proses pendaftaran santri.
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'          => 'required|string|max:255',
            'nis'           => 'required|string|max:50|unique:users,nis',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'asal_daerah'   => 'required|in:dalamProvinsi,luarProvinsi',
        ]);

        // Buat user baru
        $user = User::create([
            'name'          => $request->name,
            'nis'           => $request->nis,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => 'santri',
            'jenis_kelamin' => $request->jenis_kelamin,
            'asal_daerah'   => $request->asal_daerah,
        ]);

        // Login otomatis setelah register
        Auth::login($user);

        return redirect()->route('dashboardSantri')->with('success', 'Pendaftaran berhasil!');
    }
}
