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
        Schema::table('pkm', function (Blueprint $table) {
            $table->string('nidn')->nullable()->after('nama_dosen');
            $table->string('nim')->nullable()->after('nama_mahasiswa');
        });
    }

    public function down(): void
    {
        Schema::table('pkm', function (Blueprint $table) {
            $table->dropColumn('nidn');
            $table->dropColumn('nim');
        });
    }
};