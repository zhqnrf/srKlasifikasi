<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestData extends Model
{
    use HasFactory;

    protected $table = 'test_data';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'nis',
        'asal_daerah',
        'tahun_angkatan',
        'alquran',
        'alhadis',
        'status',
        'predicted_status',
    ];

    public $timestamps = true; // Pastikan timestamps diaktifkan
}
