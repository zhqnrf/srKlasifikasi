<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;

class MunaqosahController extends Controller
{
    /**
     * Hapus data riwayat berdasarkan ID.
     */
    public function destroy($id)
    {
        // Cari data Riwayat
        $riwayat = Riwayat::findOrFail($id);

        // Hapus
        $riwayat->delete();

        // Redirect balik dengan pesan sukses
        return redirect()->back()->with('success', 'Data riwayat berhasil dihapus.');
    }

    /**
     * Kirim data riwayat ke admin (misalnya tandai "is_sent" atau terserah logika Anda).
     */
    public function send($id)
    {
        // Cari data Riwayat
        $riwayat = Riwayat::findOrFail($id);

        // Misalnya Anda punya kolom "sent_to_admin" (boolean) atau "sent_at" (datetime) untuk menandai bahwa data sudah dikirim
        // Contoh: kita set "sent_at" menjadi sekarang
        $riwayat->sent_at = now();
        $riwayat->save();

        // Redirect balik dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil dikirim ke admin.');
    }


    // Contoh: Tampilkan semua Riwayat yang "sent_at" != null
public function showMunaqosah()
{
    $riwayat = Riwayat::whereNotNull('sent_at')
                ->orderBy('created_at', 'desc')
                ->get();

    return view('pages.admin.data-santri', compact('riwayat'));
}

}
