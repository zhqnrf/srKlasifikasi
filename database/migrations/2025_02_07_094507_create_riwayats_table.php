<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('tahun_angkatan')->nullable();
            $table->integer('alquran')->default(0);
            $table->integer('alhadis')->default(0);
            $table->float('nilai_n')->nullable();       // simpan nilai n (persentase)
            $table->string('status')->nullable();       // "Tercapai" / "Tidak Tercapai"
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayats');
    }
};
