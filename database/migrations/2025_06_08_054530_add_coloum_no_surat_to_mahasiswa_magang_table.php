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
        Schema::table('mahasiswa_magang', function (Blueprint $table) {
            $table->string('no_surat')->nullable()->after('nim');
            $table->string('dosen_id')->after('no_surat');
            $table->string('nilai_dosen')->nullable()->after('nilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa_magang', function (Blueprint $table) {
            //
        });
    }
};
