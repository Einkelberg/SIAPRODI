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
        Schema::create('wisuda', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 9);
            $table->string('semester', 2);
            $table->string('status_wisuda', 20);
            $table->unsignedBigInteger('tahun_wisuda_id')->nullable();
            $table->timestamps();
        
            // Foreign key ke tabel tahun_wisuda
            $table->foreign('tahun_wisuda_id')->references('id')->on('tahun_wisuda')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wisuda');
    }
};
