<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('test_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('nis')->unique();
            $table->string('asal_daerah');
            $table->string('tahun_angkatan');
            $table->integer('alquran');
            $table->integer('alhadis');
            $table->string('status');
            $table->string('predicted_status')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('test_data');
    }
};
