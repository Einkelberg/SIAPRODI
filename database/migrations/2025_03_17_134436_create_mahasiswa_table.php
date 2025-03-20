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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('id_mahasiswa');
            $table->string('nim')->unique();
            $table->string('nama_mahasiswa');
            $table->string('no_hp');
            $table->text('alamat');
            $table->string('tahun_masuk');
<<<<<<< Updated upstream
            $table->string('status_aktif')->default('Aktif');
=======
            $table->string('status_aktif')->default("Aktif");
            $table->string('no_ortu');
>>>>>>> Stashed changes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
