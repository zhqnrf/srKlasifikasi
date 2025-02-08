<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
            'alquran' => 'required|integer|min:0',
            'alhadis' => 'required|integer|min:0',
        ]);

        // Buat objek Carbon dari "1 Januari [year angkatan]"
        $start = Carbon::create($request->year, 1, 1); // 1 Jan tahun angkatan
        $now   = Carbon::today();                      // Hari ini (tanggal saja)
        $x = $start->diffInDays($now);

        // Jumlah halaman diisi
        $y = $request->alquran + $request->alhadis;

        // Default nilai n dan status
        $n = 0;
        $status = 'Tidak Tercapai';

        // 1) Jika y >= 2603, langsung "Tercapai"
        if ($y >= 2603) {
            $n = 100;  // atau nilai lain yang Anda inginkan
            $status = 'Tercapai';
        }
        // 2) Jika y < 2603 dan x > 0, hitung kecepatan
        elseif ($x > 0) {
            $userSpeed   = $y / $x;
            $targetSpeed = 2603 / 1095;
            $n = ($userSpeed / $targetSpeed) * 100;
            $status = $n >= 100 ? 'Tercapai' : 'Tidak Tercapai';
        }
        // 3) Jika x == 0 dan y < 2603, nilai default tetap 0 dengan status "Tidak Tercapai"

        // Simpan data ke database
        Riwayat::create([
            'user_id'        => Auth::id(),
            'tahun_angkatan' => $request->year,
            'alquran'        => $request->alquran,
            'alhadis'        => $request->alhadis,
            'nilai_n'        => $n,
            'status'         => $status,
        ]);

        // Ambil entri terbaru untuk ditampilkan
        $latest = Riwayat::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

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

        return view('pages.santri.history', compact('riwayat'));
    }
}
