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
        Schema::create('mhs_smstr_perpanjangan', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 15);
            $table->text('alasan');
            $table->text('semester');
            // $table->text('solusi');
            // $table->string('batas_waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mhs_smstr_perpanjangan');
    }
};
