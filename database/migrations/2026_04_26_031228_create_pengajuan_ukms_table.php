<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pengajuan_ukms', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Mahasiswa yang mengajukan
        $table->string('kode_kampus'); // Kode khusus yang diinput
        $table->string('nama_ukm');
        $table->text('latar_belakang');
        $table->text('rencana_kegiatan');
        $table->text('daftar_anggota'); // Bisa teks daftar nama/NIM
        $table->string('logo')->nullable();
        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_ukms');
    }
};
