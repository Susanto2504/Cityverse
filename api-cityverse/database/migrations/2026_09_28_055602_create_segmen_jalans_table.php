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
        Schema::create('segmen_jalans', function (Blueprint $table) {
            $table->id('id_segmen');

            $table->foreignId('jalan_id')
                ->constrained('jalans', 'id_jalan')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('osm_id')->unique();

            $table->json('koordinat_geometri')->nullable();

            $table->decimal('panjang_m', 12, 2)->nullable();

            $table->decimal('lebar_m', 8, 2)->nullable();

            $table->string('tipe_jalan_detail')->nullable();

            $table->integer('kapasitas_jalan')->nullable();

            $table->integer('volume_kendaraan')->nullable();

            $table->enum('tingkat_kepadatan', [
                'Lancar',
                'Sedang',
                'Macet'
            ])->nullable();
            
            $table->timestamps();

            $table->index('jalan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segmen_jalans');
    }
};
