<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $primaryKey = 'id_dosen';

   protected $fillable = [
        'nidn',
        'nama_dosen',
        'jabatan_fungsional',
        'no_serdos',
    ];
}