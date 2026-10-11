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
        Schema::create('jalans', function (Blueprint $table) {
            $table->id('id_jalan');
            $table->string('nama_ruas_jalan')->unique();
            $table->decimal('panjang_m', 12, 2)->nullable();
            $table->decimal('lebar_m', 8, 2)->nullable();
            $table->string('tipe_jalan_detail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jalans');
    }
};
