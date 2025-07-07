<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KegiatanDosenModels extends Model
{
    use HasFactory;

    protected $table = 'kegiatan_dosen';
    protected $primaryKey = 'id_kegiatan_dosen';
    protected $fillable = [
        'nidn',
        'lokasi_kegiatan',
        'jenis_kegiatan',
        'tgl_mulai',
        'tgl_selesai',
        'nomor_sk',
        'file_sk',
        'keterangan',
    ];

    public $timestamps = false;

    public function dosen()
    {
        return $this->belongsTo(DosenModels::class, 'nidn', 'nidn');
    }
}
