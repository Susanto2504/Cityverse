<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('segmen_jalans', function (Blueprint $table) {
            $table->enum('kondisi_jalan', [
                'Normal',
                'Longsor',
                'Banjir',
                'Lainnya'
            ])
            ->default('Normal')
            ->after('tingkat_kepadatan');

            $table->decimal('panjang_kondisi_m', 12, 2)
                ->nullable()
                ->after('kondisi_jalan');

            $table->string('kondisi_lainnya')
                ->nullable()
                ->after('panjang_kondisi_m');

            $table->index('kondisi_jalan');
        });
    }

    public function down(): void
    {
        Schema::table('segmen_jalans', function (Blueprint $table) {
            $table->dropIndex(['kondisi_jalan']);

            $table->dropColumn([
                'kondisi_jalan',
                'panjang_kondisi_m',
                'kondisi_lainnya',
            ]);
        });
    }
};