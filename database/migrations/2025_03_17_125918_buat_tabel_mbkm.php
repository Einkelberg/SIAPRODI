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
        Schema::create('mbkm', function (Blueprint $table) {
            $table->id();
            $table->integer('nim');
            $table->string('nama_program');
            $table->string('namaLembaga');
            $table->string('lokasi');
            $table->string('bidangProgram');
            $table->string('durasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mbkm');
    }
};
