<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pkm extends Model
{
    protected $table = 'pkm';
    protected $primaryKey = 'id_pkm';
    public $timestamps = false; // Tambahkan jika tidak menggunakan timestamps

    protected $fillable = [
        'judul',
        'tahun',
        'lokasi',
        'anggaran',
        'status',
        'nama_dosen',
        'nidn',
        'nama_mahasiswa',
        'nim',
    ];
}