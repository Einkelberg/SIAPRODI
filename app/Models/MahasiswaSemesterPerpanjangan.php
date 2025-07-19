<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaSemesterPerpanjangan extends Model
{
    use HasFactory;

    protected $table = 'mhs_smstr_perpanjangan'; // Nama tabel di database

    protected $primaryKey = 'id'; // Pastikan ada primary key (jika bukan 'id', sesuaikan)

    public $timestamps = true; // Jika tabel memiliki created_at & updated_at (ubah ke false jika tidak ada)

    protected $fillable = [
        'nim',
        'semester',
        'alasan',
        'solusi',
        'batas_waktu',
    ];

    /**
     * Relasi ke model Mahasiswa (berdasarkan NIM)
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim'); 
    }
}
