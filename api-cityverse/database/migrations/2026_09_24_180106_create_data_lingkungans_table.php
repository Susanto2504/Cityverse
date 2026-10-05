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
        Schema::create('data_lingkungans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sumber_api_id')
                ->constrained('sumber_api_lingkungans')
                ->cascadeOnDelete();

            $table->string('wilayah')->nullable();

            $table->string('kode_wilayah')->nullable();

            $table->string('parameter')->nullable();

            $table->string('indikator')->nullable();

            $table->decimal('nilai', 20, 6)->nullable();

            $table->string('satuan')->nullable();

            $table->year('tahun')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();

            $table->decimal('longitude', 10, 7)->nullable();

            $table->json('data_asli')->nullable();

            $table->timestamp('diambil_pada')->nullable();

            $table->timestamps();

            $table->index([
                'wilayah',
                'parameter',
                'tahun',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_lingkungans');
    }
};
