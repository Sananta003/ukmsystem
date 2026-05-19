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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ukm_id')->constrained('ukms')->cascadeOnDelete();
            // nullable() karena tidak semua pengeluaran berhubungan dengan kegiatan tertentu
            $table->foreignId('kegiatan_id')->nullable()->constrained('kegiatans')->nullOnDelete(); 
            $table->enum('jenis', ['Pemasukan', 'Pengeluaran']);
            $table->integer('nominal');
            $table->string('keterangan');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
