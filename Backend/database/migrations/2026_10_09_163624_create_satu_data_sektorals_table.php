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
        Schema::create('satu_data_sektorals', function (Blueprint $table) {
            $table->id();
            $table->string('sumber')->default('data.makassarkota.go.id');
            $table->string('kode_sektor');
            $table->string('kode_data');
            $table->unsignedSmallInteger('tahun');
            $table->json('data');
            $table->timestamp('disinkronkan_pada')->nullable();
            $table->timestamps();

            $table->unique(
                ['sumber', 'kode_sektor', 'kode_data', 'tahun'],
                'satu_data_sektorals_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satu_data_sektorals');
    }
};
