<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TrainData;
use App\Models\TestData;
use Phpml\Classification\NaiveBayes;

class TestDataController extends Controller
{
    public function showTestData(Request $request)
    {
        $percentage = $request->input('percentage', 100);
        $totalTrainData = TrainData::count();
        $limit = round(($percentage / 100) * $totalTrainData);

        // **Hapus semua data uji sebelum insert baru**
        TestData::query()->delete();

        // **Ambil data latih acak sesuai persentase**
        $trainData = TrainData::inRandomOrder()->limit($limit)->get();

        // **Gunakan array untuk memastikan NIS unik**
        $existingNIS = [];

        foreach ($trainData as $data) {
            if (!in_array($data->nis, $existingNIS)) {
                TestData::create([
                    'nama' => $data->nama,
                    'jenis_kelamin' => $data->jenis_kelamin,
                    'nis' => $data->nis,
                    'asal_daerah' => $data->asal_daerah,
                    'tahun_angkatan' => $data->tahun_angkatan,
                    'alquran' => $data->alquran,
                    'alhadis' => $data->alhadis,
                    'status' => $data->status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $existingNIS[] = $data->nis;
            }
        }

        // **Jalankan klasifikasi otomatis**
        $this->classifyData();

        // **Ambil kembali data uji**
        $testData = TestData::all();
        $totalTestData = $testData->count();

        // **Hitung akurasi berdasarkan prediksi**
        $correctPredictions = TestData::whereColumn('status', 'predicted_status')->count();
        $accuracy = ($totalTestData > 0) ? ($correctPredictions / max(1, $totalTestData)) * 100 : 0;

        // **Hitung probabilitas status prediksi**
        $probStatus = [
            'Tepat' => TestData::where('predicted_status', 'Tercapai')->count() * 100 / max(1, $totalTestData),
            'Terlambat' => TestData::where('predicted_status', 'Tidak Tercapai')->count() * 100 / max(1, $totalTestData),
        ];

        // **Probabilitas berdasarkan jenis kelamin**
        $probGender = TestData::groupBy('jenis_kelamin')
            ->selectRaw("jenis_kelamin, COUNT(*) * 100 / $totalTestData as probability")
            ->pluck('probability', 'jenis_kelamin')
            ->toArray();

        $probGender = [
            'Laki-laki' => $probGender['Laki-laki'] ?? 0,
            'Perempuan' => $probGender['Perempuan'] ?? 0,
        ];

        // **Probabilitas berdasarkan asal daerah**
        $probRegion = TestData::groupBy('asal_daerah')
            ->selectRaw("asal_daerah, COUNT(*) * 100 / $totalTestData as probability")
            ->pluck('probability', 'asal_daerah')
            ->toArray();

        $probRegion = [
            'Dalam Provinsi' => $probRegion['Dalam Provinsi'] ?? 0,
            'Luar Provinsi' => $probRegion['Luar Provinsi'] ?? 0,
        ];

        // **Hitung peluang tepat waktu berdasarkan kategori**
        $peluangGender = TestData::groupBy('jenis_kelamin')
            ->selectRaw("jenis_kelamin, SUM(CASE WHEN predicted_status = 'Tercapai' THEN 1 ELSE 0 END) * 100 / COUNT(*) as peluang")
            ->pluck('peluang', 'jenis_kelamin')
            ->toArray();

        $peluangRegion = TestData::groupBy('asal_daerah')
            ->selectRaw("asal_daerah, SUM(CASE WHEN predicted_status = 'Tercapai' THEN 1 ELSE 0 END) * 100 / COUNT(*) as peluang")
            ->pluck('peluang', 'asal_daerah')
            ->toArray();

        return view('pages.admin.exam-data', compact(
            'testData',
            'totalTestData',
            'accuracy',
            'probStatus',
            'probGender',
            'probRegion',
            'peluangGender',
            'peluangRegion'
        ));
    }

    public function showClassify()
    {
        $classifiedData = TestData::whereNotNull('predicted_status')->get();

        return view('pages.admin.class-result', compact('classifiedData'));
    }

    private function classifyData()
    {
        if (TestData::count() == 0) {
            return;
        }

        // Ambil data latih untuk model
        $trainSamples = TrainData::all()->map(function ($item) {
            return [$item->alquran, $item->alhadis]; // Fitur
        })->toArray();

        $trainLabels = TrainData::pluck('status')->values()->toArray();

        // Ambil data uji
        $testSamples = TestData::all()->map(function ($item) {
            return [$item->alquran, $item->alhadis]; // Fitur
        })->toArray();

        if (count($trainSamples) == 0 || count($testSamples) == 0) {
            return;
        }

        // Jalankan Naive Bayes
        $classifier = new NaiveBayes();
        $classifier->train($trainSamples, $trainLabels);
        $predictedLabels = $classifier->predict($testSamples);

        // Simpan hasil prediksi
        $testData = TestData::all();
        foreach ($testData as $index => $data) {
            $data->predicted_status = $predictedLabels[$index] ?? 'Belum Diklasifikasi';
            $data->save();
        }

        // ✅ Tambahkan debug log untuk memastikan prediksi disimpan
        Log::info("DEBUG: Hasil Prediksi Naive Bayes", [
            "Total Test Data" => count($testSamples),
            "Predicted Labels" => $predictedLabels,
        ]);
    }

    public function resetData()
    {
        TestData::query()->delete();
        return back()->with('success', 'Data uji telah direset.');
    }
}
