<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Riwayat;

class MunaqosahController extends Controller
{
    // Method untuk menghapus data riwayat (digunakan di admin dan santri)
    public function destroy($id)
    {
        $riwayat = Riwayat::findOrFail($id);
        $riwayat->delete();
        return redirect()->back()->with('success', 'Data Munaqosah berhasil dihapus.');
    }

    /**
     * Kirim data riwayat ke admin yang dipilih.
     */
    public function send(Request $request, $id)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id', // pastikan admin_id valid
        ]);

        $riwayat = Riwayat::findOrFail($id);
        $riwayat->admin_id = $request->admin_id;
        $riwayat->sent_at = now();
        $riwayat->munaqosah_status = 'Sedang di Verifikasi';
        $riwayat->save();

        return redirect()->back()->with('success', 'Data berhasil dikirim ke admin.');
    }


    /**
     * Tampilkan data munaqosah untuk admin.
     */
    public function showMunaqosah()
    {
        $riwayat = Riwayat::whereNotNull('sent_at')
            ->where('admin_id', auth()->id()) // hanya data untuk admin yang sedang login
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.admin.data-santri', compact('riwayat'));
    }


    /**
     * Verifikasi data munaqosah.
     */
    public function verify($id)
    {
        $riwayat = Riwayat::findOrFail($id);
        $riwayat->munaqosah_status = 'Terverifikasi';
        $riwayat->save();

        return redirect()->back()->with('success', 'Data telah diverifikasi.');
    }

    /**
     * Tolak data munaqosah.
     */
    public function reject($id)
    {
        $riwayat = Riwayat::findOrFail($id);
        $riwayat->munaqosah_status = 'Ditolak';
        $riwayat->save();

        return redirect()->back()->with('success', 'Data telah ditolak.');
    }
}
