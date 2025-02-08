<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayats';

    protected $fillable = [
        'user_id',
        'tahun_angkatan',
        'alquran',
        'alhadis',
        'nilai_n',
        'status',
        'sent_at',
        'admin_id',
        'munaqosah_status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->select(['id', 'name', 'jenis_kelamin', 'nis', 'asal_daerah']);
    }
}
