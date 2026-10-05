<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wilayahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_wilayah')->unique();
            $table->string('nama_kelurahan');
            $table->string('nama_kecamatan');
            $table->string('nama_kota');
            $table->decimal('garis_lintang', 10, 8)->nullable();
            $table->decimal('garis_bujur', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayahs');
    }
};
