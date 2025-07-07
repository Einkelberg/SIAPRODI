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
        Schema::create('pkm', function (Blueprint $table) {
            $table->id('id_pkm');
            $table->string('nidn');
            $table->string('nim');
            $table->string('judul');
            $table->year('tahun');
            $table->string('lokasi');
            $table->char('anggaran');
            $table->foreign('nidn')->references('nidn')->on('dosen');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkm');
    }
};