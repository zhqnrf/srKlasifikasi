<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman tambah admin (list admin).
     */
    public function index()
    {
        // Ambil semua user yang ber-role admin
        $admins = User::where('role', 'admin')->get();

        return view('pages.admin.add-admin', compact('admins'));
    }

    public function dashboard()
    {

        $user = Auth::user();
        if (!$user) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        return view('pages.admin.dashboard', compact('user'));
    }

    /**
     * Simpan admin baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:6',
            'confirm_password' => 'required|same:password',
        ]);

        // Buat user dengan role admin
        User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return redirect()->route('admin.add')->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Hapus Admin.
     */
    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.add')->with('success', 'Admin berhasil dihapus.');
    }

    /**
     * Tampilkan form ubah password (Admin).
     */
    public function showChangePassword()
    {
        return view('pages.admin.change-password');
    }

    /**
     * Proses ubah password (Admin).
     */
    /**
     * Proses ubah password (Admin).
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'password'              => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ], [
            'password_confirmation.same' => 'Konfirmasi password tidak sama dengan password baru.'
        ]);

        // Ambil user yang sedang login menggunakan Auth
        $user = Auth::user();
        if (!$user) {
            return back()->withErrors(['User tidak ditemukan atau belum login.']);
        }

        // Update password menggunakan metode update() tanpa memanggil $user->save()
        User::where('id', $user->id)
            ->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password berhasil diubah!');
    }

}
