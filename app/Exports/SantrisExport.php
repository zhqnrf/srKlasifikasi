<?php

namespace App\Exports;

use App\Models\Riwayat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

namespace App\Exports;

use App\Models\TrainData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SantrisExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return TrainData::all()->map(function ($trainData) {
            return [
                'Nama' => $trainData->nama,
                'Jenis Kelamin' => $trainData->jenis_kelamin,
                'NIS' => $trainData->nis,
                'Asal Daerah' => $trainData->asal_daerah,
                'Tahun Angkatan' => $trainData->tahun_angkatan,
                'Capaian Al Qur\'an' => $trainData->alquran,
                'Capaian Hadis' => $trainData->alhadis,
                'Status' => $trainData->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Jenis Kelamin',
            'NIS',
            'Asal Daerah',
            'Tahun Angkatan',
            'Capaian Al Qur\'an',
            'Capaian Hadis',
            'Target'
        ];
    }
}
