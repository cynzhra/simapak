<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanEtika extends Model
{
    use HasFactory;

    protected $table = 'aturan_etika';

    protected $fillable = [
        'nip',
        'patuh_aturan',
        'etika_kerja',
        'integritas',
        'tanggungjawab',
        'disiplin',
        'bobot_nilai',
        'kategori_nilai',
    ];
}