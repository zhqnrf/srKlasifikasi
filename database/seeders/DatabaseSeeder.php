<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Panggil UserSeeder
        $this->call([
            UserSeeder::class,
        ]);
    }
}
