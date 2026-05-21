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
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->renameColumn('nama', 'nama_kegiatan');
            $table->renameColumn('realisasi', 'realisasi_anggaran');
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->time('waktu')->nullable();
            $table->integer('target_peserta')->default(0);
            $table->integer('jumlah_pendaftar')->default(0);
            $table->string('pic_nama')->nullable();
            $table->string('pic_kontak')->nullable();
            $table->string('file_proposal')->nullable();
            $table->string('file_laporan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->renameColumn('nama_kegiatan', 'nama');
            $table->renameColumn('realisasi_anggaran', 'realisasi');
            $table->dropColumn(['kategori', 'deskripsi', 'waktu', 'target_peserta', 'jumlah_pendaftar', 'pic_nama', 'pic_kontak', 'file_proposal', 'file_laporan']);
        });
    }
};
