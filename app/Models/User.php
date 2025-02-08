<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi (mass assignment).
     */
    protected $fillable = [
        'name',
        'nis',
        'email',
        'password',
        'role',
        'jenis_kelamin',
        'asal_daerah',
    ];

    /**
     * Hidden kolom (misalnya password).
     */
    protected $hidden = [
        'password',
    ];
}
