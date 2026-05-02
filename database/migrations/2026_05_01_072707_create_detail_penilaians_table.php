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
        Schema::create('detail_penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penilaian')
                ->constrained('penilaians')
                ->cascadeOnDelete();
            $table->foreignId('id_karyawan')
                ->constrained('karyawans')
                ->cascadeOnDelete();
            $table->foreignId('id_kriteria')
                ->constrained('kriterias')
                ->cascadeOnDelete();
            $table->float('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penilaians');
    }
};
