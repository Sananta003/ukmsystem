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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ukm_id')->constrained('ukms')->cascadeOnDelete();
            $table->string('nama');
            $table->date('tanggal');
            $table->string('lokasi')->nullable();
            $table->enum('status', ['Direncanakan', 'Berjalan', 'Selesai'])->default('Direncanakan');
            $table->integer('anggaran')->default(0);
            $table->integer('realisasi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
