<?php

namespace App\Imports;

use App\Models\TrainData;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SantrisImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return TrainData::updateOrCreate(
            ['nis' => $row['nis']],  // Jika NIS sudah ada, perbarui data
            [
                'nama' => $row['nama'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'asal_daerah' => $row['asal_daerah'],
                'tahun_angkatan' => $row['tahun_angkatan'],
                'alquran' => $row['capaian_al_quran'],
                'alhadis' => $row['capaian_hadis'],
                'status' => $row['status']
            ]
        );
    }
}
