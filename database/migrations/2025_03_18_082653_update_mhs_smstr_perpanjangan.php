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
            // $table->string('nama_mahasiswa', 100)->after('nim'); // Tambahkan kolom nama mahasiswa
            // $table->string('status', 50)->nullable()->after('nim'); // Tambahkan kolom status
            $table->dropColumn('alasan'); // Hapus kolom alasan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_smstr_perpanjangan', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->text('alasan')->after('tahun_akadamik'); // Kembalikan alasan jika rollback
        });
    }
};
