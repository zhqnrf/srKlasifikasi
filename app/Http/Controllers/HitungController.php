<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HitungController extends Controller
{
    /**
     * Menampilkan halaman counting (form + hasil terbaru).
     */
    public function showCounting()
    {
        $userId = Auth::id();
        $latest = Riwayat::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('pages.santri.counting', compact('latest'));
    }

    /**
     * Menerima POST form, menghitung nilai n, menyimpan ke DB, lalu kembali ke halaman counting.
     */
    public function processCounting(Request $request)
    {
        $request->validate([
            'year'    => 'required|integer',
            'alquran' => 'required|integer|min:0|max:606',   // maksimal 606 halaman
            'alhadis' => 'required|integer|min:0|max:2174',  // maksimal 2174 halaman
        ]);

        // Buat objek Carbon dari "1 Januari [tahun angkatan]"
        $start = Carbon::create($request->year, 1, 1); // 1 Jan tahun angkatan
        $now   = Carbon::today();                      // Hari ini (tanggal saja)
        $x = $start->diffInDays($now);

        // Jumlah halaman yang diisi (alquran + alhadis)
        $y = $request->alquran + $request->alhadis;

        // Default nilai n dan status
        $n = 0;
        $status = 'Tidak Tercapai';

        // 1) Jika jumlah halaman (y) >= 2780, langsung "Tercapai"
        if ($y >= 2780) {
            $n = 100;  // Anda dapat mengganti nilai sesuai kebutuhan
            $status = 'Tercapai';
        }
        // 2) Jika y < 2780 dan x > 0, hitung kecepatan pencapaian
        elseif ($x > 0) {
            $userSpeed   = $y / $x;
            $targetSpeed = 2780 / 1095;
            $n = ($userSpeed / $targetSpeed) * 100;
            $status = $n >= 100 ? 'Tercapai' : 'Tidak Tercapai';
        }
        // 3) Jika x == 0 dan y < 2780, nilai default tetap 0 dengan status "Tidak Tercapai"

        // Simpan data ke database
        Riwayat::create([
            'user_id'        => Auth::id(),
            'tahun_angkatan' => $request->year,
            'alquran'        => $request->alquran,
            'alhadis'        => $request->alhadis,
            'nilai_n'        => $n,
            'status'         => $status,
        ]);

        // Kembali ke halaman counting dengan pesan sukses
        return redirect()->route('countingSantri')
            ->with('success', 'Data berhasil dihitung dan disimpan!');
    }

    /**
     * Menampilkan riwayat hitung bagi user saat ini.
     */
    public function history()
    {
        $userId = Auth::id();
        $riwayat = Riwayat::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data admin (sesuaikan query dengan struktur database Anda)
        $admins = User::where('role', 'admin')->get();

        return view('pages.santri.history', compact('riwayat', 'admins'));
    }
}
