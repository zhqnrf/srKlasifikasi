<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassifiactionController extends Controller
{
    /**
     * Menampilkan data ujian (examData)
     *
     * @return \Illuminate\View\View
     */
    public function examData()
    {
        // Tambahkan logika untuk mengambil data ujian dari database jika diperlukan
        // Contoh: $data = Exam::all();

        // Return view dengan data yang diperlukan
        return view('pages.admin.exam-data'); // Pastikan view ini telah dibuat
    }

    /**
     * Menampilkan data pelatihan (trainData)
     *
     * @return \Illuminate\View\View
     */
    public function trainData()
    {
        // Tambahkan logika untuk mengambil data pelatihan
        // Contoh: $data = Train::all();

        return view('pages.admin.train-data'); // Pastikan view ini telah dibuat
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
}
