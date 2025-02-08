<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan path ke Model User sudah benar

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin account
        User::create([
            'name' => null, // admin tidak butuh name, boleh dikosongi
            'nis'  => null, // admin tidak butuh NIS
            'email' => 'muhammadfirdaus@gmail.com',
            'password' => Hash::make('123456'), // password: 123456
            'role' => 'admin'
        ]);

        // Santri account
        User::create([
            'name' => 'Zhaqian',
            'nis'  => 'A13411',
            'email' => 'santri@gmail.com',
            'password' => Hash::make('123456'), // password: 123456
            'role' => 'santri',
            'jenis_kelamin' => 'Laki-laki',
            'asal_daerah' => 'Jawa',
        ]);
    }
}
