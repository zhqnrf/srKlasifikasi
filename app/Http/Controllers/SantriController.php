<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SantriController extends Controller
{
    /**
     * Tampilkan halaman profil Santri.
     */
    public function showProfile()
    {
        // Ambil user yang sedang login menggunakan Auth
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('pages.santri.profil', compact('user'));
    }

    /**
     * Tampilkan halaman dashboard Santri.
     */
    public function dashboard()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        // Ambil riwayat terbaru berdasarkan user_id
        $latestRiwayat = Riwayat::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('pages.santri.dashboard', compact('user', 'latestRiwayat'));
    }

    /**
     * Update profil Santri.
     */
    public function updateProfile(Request $request)
    {
        // Ambil user yang sedang login menggunakan Auth
        $user = Auth::user();
        if (!$user) {
            return back()->withErrors(['User tidak ditemukan atau belum login.']);
        }

        // Validasi input
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'asal_daerah' => 'required|in:Dalam Provinsi,Luar Provinsi',
            'password'    => 'nullable|min:6|same:password_confirmation',
        ], [
            'password.same' => 'Konfirmasi password tidak cocok.',
        ]);

        // Kumpulkan data yang akan diperbarui
        $data = [
            'name'        => $request->name,
            'email'       => $request->email,
            'asal_daerah' => $request->asal_daerah,
        ];

        // Perbarui password jika field password diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update data menggunakan DB facade
        $updated = DB::table('users')
            ->where('id', $user->id)
            ->update($data);

        if ($updated) {
            return back()->with('success', 'Profil berhasil diperbarui!');
        } else {
            return back()->withErrors(['Gagal memperbarui profil.']);
        }
    }
}
