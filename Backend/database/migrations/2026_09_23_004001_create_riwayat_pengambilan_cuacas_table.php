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
        Schema::create('riwayat_pengambilan_cuacas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_wilayah')->nullable();
            $table->dateTime('waktu_pengambilan');
            $table->enum('status', ['berhasil', 'gagal']);
            $table->text('pesan')->nullable();
            $table->integer('jumlah_data')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pengambilan_cuacas');
    }
};
