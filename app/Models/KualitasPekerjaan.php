<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KualitasPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'kualitas_pekerjaan';

    protected $fillable = [
        'nip',
        'ketepatan',
        'ketelitian',
        'kreativitas',
        'kepatuhan',
        'tepat_waktu',
        'bobot_nilai',
        'kategori_nilai',
    ];
}