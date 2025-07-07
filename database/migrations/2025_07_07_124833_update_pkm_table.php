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
    $table->dropForeign(['nidn']);
    $table->dropForeign(['nim']);
    $table->dropColumn(['nidn', 'nim']);

    $table->string('nama_dosen');
    $table->string('nama_mahasiswa');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};