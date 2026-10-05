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
        Schema::create('prakiraan_cuacas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_wilayah');
            $table->foreign('kode_wilayah')->references('kode_wilayah')->on('wilayahs')->onDelete('cascade');
            $table->dateTime('waktu_prakiraan');
            $table->decimal('suhu', 5, 2);
            $table->integer('kelembapan');
            $table->string('kode_cuaca');
            $table->string('keterangan_cuaca');
            $table->decimal('kecepatan_angin', 5, 2)->nullable();
            $table->string('arah_angin')->nullable();
            $table->integer('tutupan_awan')->nullable();
            $table->string('jarak_pandang')->nullable();
            $table->text('gambar_cuaca')->nullable();
            $table->dateTime('waktu_diambil');
            $table->timestamp('dibuat_pada')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prakiraan_cuacas');
    }
};
