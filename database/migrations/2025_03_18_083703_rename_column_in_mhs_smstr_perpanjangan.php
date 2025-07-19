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
        Schema::table('mhs_smstr_perpanjangan', function (Blueprint $table) {
            // $table->renameColumn('tahun_akadamik', 'tahun_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_smstr_perpanjangan', function (Blueprint $table) {
            $table->renameColumn('tahun_akademik', 'tahun_akadamik');
        });
    }
};
