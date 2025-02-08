<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('riwayats', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->after('user_id');
            $table->string('munaqosah_status')->nullable()->after('status');
            // Jika perlu, tambahkan relasi foreign key
            // $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('riwayats', function (Blueprint $table) {
            $table->dropColumn(['admin_id', 'munaqosah_status']);
        });
    }
};
