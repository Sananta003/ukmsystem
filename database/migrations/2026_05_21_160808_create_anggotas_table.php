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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ukm_id')->constrained('ukms')->cascadeOnDelete();
            $table->string('nama');
            $table->string('nim');
            $table->string('fakultas')->nullable();
            $table->string('prodi')->nullable();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('status')->default('Aktif');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
