<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KemampuanBeradaptasi extends Model
{
    use HasFactory;

    protected $table = 'kemampuan_beradaptasi';

    protected $fillable = [
        'karyawan_id',
        'fleksibilitas',
        'adaptabilitas',
        'mengatasi_hambatan',
        'pembelajaran_cepat',
        'umpan_balik',
        'bobot_nilai',
        'kategori_nilai',
    ];
}
