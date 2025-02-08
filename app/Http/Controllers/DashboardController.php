<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TestData;
use App\Models\TrainData;

use Illuminate\Routing\Controller as BaseController;

class DashboardController extends Controller
{

    public function showDashboard()
    {
        // Jumlah total santri
        $totalSantri = TrainData::count();

        // Jumlah santri tepat waktu berdasarkan data klasifikasi
        $totalTepatWaktu = TestData::where('predicted_status', 'Tercapai')->count();

        // Ambil data berdasarkan tahun angkatan
        $tahunAngkatan = TestData::select('tahun_angkatan')
            ->distinct()
            ->orderBy('tahun_angkatan', 'asc')
            ->pluck('tahun_angkatan')
            ->toArray();


        $tahunAngkatanTable = TestData::selectRaw('tahun_angkatan, 
                            COUNT(*) as total, 
                            COALESCE(SUM(CASE WHEN predicted_status = "Tercapai" THEN 1 ELSE 0 END), 0) as tepat')
            ->groupBy('tahun_angkatan')
            ->orderBy('tahun_angkatan', 'asc')
            ->get();



        // Data untuk grafik jenis kelamin berdasarkan tahun angkatan
        $genderData = TestData::selectRaw('tahun_angkatan, 
                        SUM(CASE WHEN jenis_kelamin = "Laki-laki" THEN 1 ELSE 0 END) as laki,
                        SUM(CASE WHEN jenis_kelamin = "Perempuan" THEN 1 ELSE 0 END) as perempuan')
            ->groupBy('tahun_angkatan')
            ->orderBy('tahun_angkatan', 'asc')
            ->get();

        // Data untuk grafik asal daerah berdasarkan tahun angkatan
        $regionData = TestData::selectRaw('tahun_angkatan, 
                        SUM(CASE WHEN asal_daerah = "Dalam Provinsi" THEN 1 ELSE 0 END) as dalam,
                        SUM(CASE WHEN asal_daerah = "Luar Provinsi" THEN 1 ELSE 0 END) as luar')
            ->groupBy('tahun_angkatan')
            ->orderBy('tahun_angkatan', 'asc')
            ->get();

        return view('pages.admin.dashboard', compact(
            'totalSantri',
            'totalTepatWaktu',
            'tahunAngkatan',
            'tahunAngkatanTable',
            'genderData',
            'regionData'
        ));
    }
}
