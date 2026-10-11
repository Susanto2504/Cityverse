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
        Schema::create('simulasi_kebijakans', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();

            $table->string('jenis_kebijakan');

            $table->string('jenis_label')->nullable();

            $table->text('skenario')->nullable();

            $table->json('target')->nullable();

            $table->unsignedBigInteger('ruas_awal_id')->nullable();

            $table->unsignedBigInteger('ruas_target_id')->nullable();

            $table->json('rekayasa_lalu_lintas')->nullable();

            $table->json('baseline')->nullable();

            $table->json('domains')->nullable();

            $table->json('hasil_ai')->nullable();

            $table->text('kesimpulan')->nullable();

            $table->enum('status', [
                'draft',
                'diajukan',
                'diterapkan'
            ])->default('draft');

            $table->timestamps();

            $table->index('jenis_kebijakan');
            $table->index('status');
            $table->index('ruas_awal_id');
            $table->index('ruas_target_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulasi_kebijakans');
    }
};
