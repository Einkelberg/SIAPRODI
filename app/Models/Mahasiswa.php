<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $primaryKey = 'id_mahasiswa';

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'no_hp',
        'alamat',
        'tahun_masuk',
        'status_aktif',
    ];

    public function tahunMasuk()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_masuk');
    }
    
    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_masuk', 'id_tahun_akademik');
    }
    public function getAmbilTahunAkademikAttribute()
    {
        if ($this->tahun_masuk) {
            $tahunAwal = (int) $this->tahun_masuk;
            return $tahunAwal . '/' . ($tahunAwal + 1);
        }
        return null;
    }
    public function ipk()
    {
        return $this->hasOne(Ipk::class, 'nim', 'nim');
    }
}
