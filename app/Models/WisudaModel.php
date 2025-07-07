<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WisudaModel extends Model
{
    protected $table = 'wisuda';
    protected $fillable = ['nim', 'semester',
    'tahun_masuk', 'status_wisuda', 'tahun_wisuda_id']; 

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'nim', 'nim');
    }

    public function sk()
    {
        return $this->belongsTo(TahunWisudaModel::class, 'tahun_wisuda_id', 'id');
    }
     public function tahunWisuda()
    {
        return $this->belongsTo(TahunWisudaModel::class, 'tahun_wisuda_id', 'id');
    }
}
