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
     * Proses login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Ambil kredensial
        $credentials = $request->only('email', 'password');

        // Coba autentikasi menggunakan kredensial
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk menghindari session fixation
            $request->session()->regenerate();

            // Ambil data user yang telah login
            $user = Auth::user();

            // Redirect sesuai role user
            if ($user->role === 'admin') {
                return redirect()->route('dashboardAdmin')->with('success', 'Selamat datang Admin!');
            } else {
                return redirect()->route('dashboardSantri')->with('success', 'Selamat datang Santri!');
            }
        }

        // Jika autentikasi gagal, kembalikan ke halaman login dengan error
        return back()->withErrors(['email' => 'Email / Password salah.']);
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
        // Validasi input pendaftaran
        $request->validate([
            'name'           => 'required|string|max:255',
            'nis'            => 'required|string|max:50|unique:users,nis',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:6',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'asal_daerah'    => 'required|in:dalamProvinsi,luarProvinsi',
        ]);

        // Buat user baru dengan role "santri"
        $user = User::create([
            'name'           => $request->name,
            'nis'            => $request->nis,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => 'santri',
            'jenis_kelamin'  => $request->jenis_kelamin,
            'asal_daerah'    => $request->asal_daerah,
        ]);

        // Login user secara otomatis
        Auth::login($user);

        return redirect()->route('dashboardSantri')->with('success', 'Pendaftaran Santri berhasil!');
    }
}
