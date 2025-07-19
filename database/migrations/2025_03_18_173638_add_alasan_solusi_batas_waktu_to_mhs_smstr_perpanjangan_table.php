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
            $table->text('alasan')->nullable()->after('nim');
            $table->text('solusi')->nullable()->after('alasan');
            $table->integer('batas_waktu')->default(0)->after('solusi'); // batas waktu dalam tahun
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_smstr_perpanjangan', function (Blueprint $table) {
            $table->dropColumn(['alasan', 'solusi', 'batas_waktu']);
        });
    }
};
