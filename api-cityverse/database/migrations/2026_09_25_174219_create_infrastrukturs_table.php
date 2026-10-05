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
        Schema::create('infrastrukturs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('api_id')->nullable();
            $table->string('kode')->nullable();
            $table->string('jenis');
            $table->text('nama');
            $table->string('judul')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('tahun')->nullable();
            $table->decimal('nilai', 20, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('sumber')->default('Satu Data Makassar');
            $table->timestamps();

            $table->unique(['jenis', 'api_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastrukturs');
    }
};
