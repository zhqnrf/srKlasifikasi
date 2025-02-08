<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Imports\SantrisImport;
use App\Exports\SantrisExport;
use App\Models\Riwayat;
use App\Models\TestData;
use App\Models\TrainData;
use Maatwebsite\Excel\Facades\Excel;

class ClassificationController extends Controller
{

    public function showTrainData()
    {
        // Jika train_data kosong, otomatis ambil dari riwayat
        if (TrainData::count() == 0) {
            $this->resetTrainData();
        }

        $santris = TrainData::orderBy('created_at', 'desc')->get();
        return view('pages.admin.train-data', compact('santris'));
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new SantrisImport, $request->file('file'));

        return back()->with('success', 'Data latih berhasil diimpor!');
    }

    public function exportExcel()
    {
        return Excel::download(new SantrisExport, 'data-latih.xlsx');
    }

    public function deleteTrainData($id)
    {
        TrainData::findOrFail($id)->delete();
        return response()->json(['success' => 'Data berhasil dihapus.']);
    }

    public function resetTrainData()
    {
        TrainData::truncate();

        // Ambil data dari riwayats dan simpan ke train_data
        $riwayats = Riwayat::with('user')->get();

        foreach ($riwayats as $riwayat) {
            TrainData::create([
                'nama' => $riwayat->user->name ?? '—',
                'jenis_kelamin' => $riwayat->user->jenis_kelamin ?? '—',
                'nis' => $riwayat->user->nis ?? '—',
                'asal_daerah' => $riwayat->user->asal_daerah ?? '—',
                'tahun_angkatan' => $riwayat->tahun_angkatan,
                'alquran' => $riwayat->alquran,
                'alhadis' => $riwayat->alhadis,
                'status' => $riwayat->status,
            ]);
        }

        return back()->with('success', 'Data latih direset!');
    }


    /**
     * Menampilkan hasil klasifikasi (classificationResult)
     *
     * @return \Illuminate\View\View
     */
    public function classificationResult()
    {
        // Tambahkan logika untuk mengolah dan menampilkan hasil klasifikasi
        // Misalnya, menjalankan algoritma atau mengambil data dari model

        return view('pages.admin.class-result'); // Pastikan view ini telah dibuat
    }



    public function showExamData()
    {
        // Tambahkan logika untuk mengolah dan menampilkan hasil klasifikasi
        // Misalnya, menjalankan algoritma atau mengambil data dari model

        return view('pages.admin.exam-data'); // Pastikan view ini telah dibuat
    }
}
