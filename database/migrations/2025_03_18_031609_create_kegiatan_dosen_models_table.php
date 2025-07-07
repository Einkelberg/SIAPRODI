<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kegiatan_dosen', function (Blueprint $table) {
            $table->id('id_kegiatan_dosen');
            $table->integer('nidn');
            $table->string('lokasi_kegiatan');
            $table->string('jenis_kegiatan');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->string('nomor_sk');
            $table->string('file_sk');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_dosen_models');
    }
};
