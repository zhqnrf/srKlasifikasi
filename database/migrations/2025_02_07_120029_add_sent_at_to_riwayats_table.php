<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('riwayats', function (Blueprint $table) {
            // Menambahkan kolom sent_at dengan tipe timestamp dan nullable
            $table->timestamp('sent_at')->nullable();
        });

        
    }

    public function down()
    {
        Schema::table('riwayats', function (Blueprint $table) {
            $table->dropColumn('sent_at');
        });
    }


    

};
