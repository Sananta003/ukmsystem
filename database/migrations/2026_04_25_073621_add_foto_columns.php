<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ukms', function (Blueprint $table) {
            $table->string('logo')->nullable()->after('deskripsi');
            // TAMBAHKAN BARIS INI:
            $table->string('foto_kegiatan')->nullable()->after('logo'); 
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('ukms', function (Blueprint $table) {
            // TAMBAHKAN BARIS INI JUGA:
            $table->dropColumn(['logo', 'foto_kegiatan']); 
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }
};