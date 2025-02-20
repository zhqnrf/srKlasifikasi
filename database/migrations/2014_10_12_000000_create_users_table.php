<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Hanya diperlukan oleh santri, maka boleh null
            $table->string('nis')->nullable();  // Hanya diperlukan oleh santri, maka boleh null
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'santri'])->default('santri');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('asal_daerah', ['Dalam Provinsi', 'Luar Provinsi'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
