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
        $trainPercentage = $request->input('train_percentage', 80); // Default 80%
        $testPercentage = 100 - $trainPercentage;
        $totalTrainData = TrainData::count();
        $trainLimit = round(($trainPercentage / 100) * $totalTrainData);
        $testLimit = round(($testPercentage / 100) * $totalTrainData);
        // **Hapus semua data uji sebelum insert baru**
        TestData::query()->delete();

        // **Ambil data latih acak sesuai persentase**
        $trainData = TrainData::inRandomOrder()->limit($trainLimit)->get();

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
        // Ganti pemanggilan classifyData() seperti ini
        $this->classifyData($request);


        $testData = TestData::limit($testLimit)->get();
        $totalTestData = $testData->count();


        // **Hitung Akurasi**
        $correctPredictions = $testData->filter(function ($item) {
            return $item->status === $item->predicted_status;
        })->count();

        $accuracy = ($totalTestData > 0) ? ($correctPredictions / max(1, $totalTestData)) * 100 : 0;

        // **Hitung True Positive, False Positive, dan False Negative**
        $TP = $testData->filter(function ($item) {
            return $item->status === 'Tercapai' && $item->predicted_status === 'Tercapai';
        })->count();

        $FP = $testData->filter(function ($item) {
            return $item->status === 'Tidak Tercapai' && $item->predicted_status === 'Tercapai';
        })->count();

        $FN = $testData->filter(function ($item) {
            return $item->status === 'Tercapai' && $item->predicted_status === 'Tidak Tercapai';
        })->count();

        // **Hitung Precision dan Recall**
        $precision = ($TP + $FP) > 0 ? ($TP / ($TP + $FP)) * 100 : 0;
        $recall = ($TP + $FN) > 0 ? ($TP / ($TP + $FN)) * 100 : 0;

        // **Hitung probabilitas status prediksi**
        $probStatus = [
            'Tepat' => $testData->filter(function ($item) {
                return $item->predicted_status === 'Tercapai';
            })->count() * 100 / max(1, $totalTestData),
            'Terlambat' => $testData->filter(function ($item) {
                return $item->predicted_status === 'Tidak Tercapai';
            })->count() * 100 / max(1, $totalTestData),
        ];

        // **Probabilitas berdasarkan jenis kelamin**
        $probGender = $testData->groupBy('jenis_kelamin')->map(function ($group) use ($totalTestData) {
            return [
                'probability' => ($group->count() * 100) / max(1, $totalTestData),
                'count' => $group->count()
            ];
        })->toArray();

        $probGender = [
            'Laki-laki' => $probGender['Laki-laki'] ?? 0,
            'Perempuan' => $probGender['Perempuan'] ?? 0,
        ];


        // Hitung total jumlah "Tercapai" dan "Tidak Tercapai" untuk masing-masing kategori
        $totalTercapai = $testData->where('status', 'Tercapai')->count();
        $totalTidakTercapai = $testData->where('status', 'Tidak Tercapai')->count();

        $probKelamin = [
            'Tercapai' => [
                'Laki-laki' => [
                    'probability' => $totalTercapai > 0 ? $testData->where('status', 'Tercapai')->where('jenis_kelamin', 'Laki-laki')->count() / $totalTercapai : 0,
                    'count' => $testData->where('status', 'Tercapai')->where('jenis_kelamin', 'Laki-laki')->count(),
                ],
                'Perempuan' => [
                    'probability' => $totalTercapai > 0 ? $testData->where('status', 'Tercapai')->where('jenis_kelamin', 'Perempuan')->count() / $totalTercapai : 0,
                    'count' => $testData->where('status', 'Tercapai')->where('jenis_kelamin', 'Perempuan')->count(),
                ],
            ],
            'Tidak Tercapai' => [
                'Laki-laki' => [
                    'probability' => $totalTidakTercapai > 0 ? $testData->where('status', 'Tidak Tercapai')->where('jenis_kelamin', 'Laki-laki')->count() / $totalTidakTercapai : 0,
                    'count' => $testData->where('status', 'Tidak Tercapai')->where('jenis_kelamin', 'Laki-laki')->count(),
                ],
                'Perempuan' => [
                    'probability' => $totalTidakTercapai > 0 ? $testData->where('status', 'Tidak Tercapai')->where('jenis_kelamin', 'Perempuan')->count() / $totalTidakTercapai : 0,
                    'count' => $testData->where('status', 'Tidak Tercapai')->where('jenis_kelamin', 'Perempuan')->count(),
                ],
            ],
        ];


        // **Probabilitas berdasarkan asal daerah**
        $probRegion = $testData->groupBy('asal_daerah')->map(function ($group) use ($totalTestData) {
            return [
                'probability' => ($group->count() * 100) / max(1, $totalTestData),
                'count' => $group->count()
            ];
        })->toArray();


        $probRegion = [
            'Dalam Provinsi' => $probRegion['Dalam Provinsi'] ?? 0,
            'Luar Provinsi' => $probRegion['Luar Provinsi'] ?? 0,
        ];

        $probProvinsi = [
            'Tercapai' => [
                'Dalam Provinsi' => [
                    'probability' => $totalTercapai > 0 ? $testData->where('status', 'Tercapai')->where('asal_daerah', 'Dalam Provinsi')->count() / $totalTercapai : 0,
                    'count' => $testData->where('status', 'Tercapai')->where('asal_daerah', 'Dalam Provinsi')->count(),
                ],
                'Luar Provinsi' => [
                    'probability' => $totalTercapai > 0 ? $testData->where('status', 'Tercapai')->where('asal_daerah', 'Luar Provinsi')->count() / $totalTercapai : 0,
                    'count' => $testData->where('status', 'Tercapai')->where('asal_daerah', 'Luar Provinsi')->count(),
                ],
            ],
            'Tidak Tercapai' => [
                'Dalam Provinsi' => [
                    'probability' => $totalTidakTercapai > 0 ? $testData->where('status', 'Tidak Tercapai')->where('asal_daerah', 'Dalam Provinsi')->count() / $totalTidakTercapai : 0,
                    'count' => $testData->where('status', 'Tidak Tercapai')->where('asal_daerah', 'Dalam Provinsi')->count(),
                ],
                'Luar Provinsi' => [
                    'probability' => $totalTidakTercapai > 0 ? $testData->where('status', 'Tidak Tercapai')->where('asal_daerah', 'Luar Provinsi')->count() / $totalTidakTercapai : 0,
                    'count' => $testData->where('status', 'Tidak Tercapai')->where('asal_daerah', 'Luar Provinsi')->count(),
                ],
            ],
        ];

        // **Hitung peluang tepat waktu berdasarkan jenis kelamin**
        $peluangGender = $testData->groupBy('jenis_kelamin')->map(function ($group) {
            $total = $group->count();
            $tercapai = $group->filter(function ($item) {
                return $item->predicted_status === 'Tercapai';
            })->count();

            return [
                'peluang' => ($tercapai * 100) / max(1, $total),
                'count' => $total
            ];
        })->toArray();

        // **Hitung peluang tepat waktu berdasarkan asal daerah**
        $peluangRegion = $testData->groupBy('asal_daerah')->map(function ($group) {
            $total = $group->count();
            $tercapai = $group->filter(function ($item) {
                return $item->predicted_status === 'Tercapai';
            })->count();

            return [
                'peluang' => ($tercapai * 100) / max(1, $total),
                'count' => $total
            ];
        })->toArray();

        $probNumerik = [
            'alquran' => [
                'Tercapai' => $this->calculateMeanStdDev('alquran', 'Tercapai', $testData),
                'Tidak Tercapai' => $this->calculateMeanStdDev('alquran', 'Tidak Tercapai', $testData),
            ],
            'alhadis' => [
                'Tercapai' => $this->calculateMeanStdDev('alhadis', 'Tercapai', $testData),
                'Tidak Tercapai' => $this->calculateMeanStdDev('alhadis', 'Tidak Tercapai', $testData),
            ],
            'tahun_angkatan' => [
                'Tercapai' => $this->calculateMeanStdDev('tahun_angkatan', 'Tercapai', $testData),
                'Tidak Tercapai' => $this->calculateMeanStdDev('tahun_angkatan', 'Tidak Tercapai', $testData),
            ],
        ];




        return view('pages.admin.test-data', compact(
            'testData',
            'totalTestData',
            'totalTrainData',
            'trainPercentage',
            'testPercentage',
            'accuracy',
            'probStatus',
            'probGender',
            'probRegion',
            'peluangGender',
            'peluangRegion',
            'precision',
            'recall',
            'probNumerik',
            'probKelamin',
            'totalTercapai',
            'totalTidakTercapai',
            'probProvinsi',
            'testLimit',
            'trainLimit',

        ));
    }

    public function showClassify()
    {
        $classifiedData = TestData::whereNotNull('predicted_status')->get();

        return view('pages.admin.class-result', compact('classifiedData'));
    }
    private function classifyData(Request $request)
    {
        $trainPercentage = $request->input('train_percentage', 80); // Default 80%
        $testPercentage = 100 - $trainPercentage;
        $totalTrainData = TrainData::count();
        $trainLimit = round(($trainPercentage / 100) * $totalTrainData);
        $testLimit = round(($testPercentage / 100) * $totalTrainData);

        // Ambil data uji sesuai limit yang dihitung
        $testData = TestData::limit($testLimit)->get();
        $totalTestData = $testData->count();

        if ($totalTestData == 0) {
            return;
        }

        // Ambil data latih untuk model
        $trainSamples = TrainData::limit($trainLimit)->get()->map(function ($item) {
            return [$item->alquran, $item->alhadis]; // Fitur
        })->toArray();

        $trainLabels = TrainData::limit($trainLimit)->pluck('status')->values()->toArray();

        // Ambil data uji
        $testSamples = $testData->map(function ($item) {
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

    private function calculateMeanStdDev($column, $status, $testData)
    {
        // Filter data sesuai status dan ambil nilai kolom yang diminta
        $data = $testData->where('status', $status)->pluck($column);

        $count = $data->count();
        $mean = $count > 0 ? $data->average() : 0;

        // Hitung standar deviasi
        $std_dev = $count > 1 ? sqrt($data->map(fn($x) => pow($x - $mean, 2))->sum() / ($count - 1)) : 0;

        return [
            'mean' => $mean,
            'std_dev' => $std_dev
        ];
    }


    public function setPercentage(Request $request)
    {
        // Mengambil persentase dari input pengguna atau default 80%
        $trainPercentage = $request->input('train_percentage', 80); // Default 80%
        $testPercentage = 100 - $trainPercentage;

        // Redirect ke halaman test-data dengan persentase yang telah dipilih
        return redirect()->route('testData.show', [
            'train_percentage' => $trainPercentage,
            'test_percentage' => $testPercentage,
        ]);
    }
}
