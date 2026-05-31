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
        Schema::create('hasil_saws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->constrained()->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrained()->cascadeOnDelete();
            $table->decimal('nilai_akhir', 8, 4);
            $table->integer('ranking');
            $table->enum('status_bonus', [
                'layak',
                'tidak_layak'
            ])->nullable();
            $table->decimal('bonus_karyawan', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_saws');
    }
};
