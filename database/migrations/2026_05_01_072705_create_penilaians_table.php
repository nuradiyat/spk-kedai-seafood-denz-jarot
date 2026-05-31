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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            // artinya setiap penilaian akan terkait dengan satu user (penilai)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('periode');
            $table->date('tanggal_penilaian');
            $table->enum('status_perhitungan', [
                'belum_diproses',
                'hitung_ulang_saw',
                'sudah_diproses'
            ])->default('belum_diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
