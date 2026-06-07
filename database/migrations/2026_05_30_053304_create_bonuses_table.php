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
        Schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_bonus', 15, 2)->nullable();
            $table->enum('status_bonus', [
                'belum_di_berikan',
                'sudah_di_berikan',
            ])->default('belum_di_berikan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonuses');
    }
};
