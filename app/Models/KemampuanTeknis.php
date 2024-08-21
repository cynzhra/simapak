<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KemampuanTeknis extends Model
{
    use HasFactory;

    protected $table = 'kemampuan_teknis';

    protected $fillable = [
        'karyawan_id',
        'pengetahuan',
        'keterampilan',
        'pengalaman',
        'implementasi',
        'sertifikasi',
        'bobot_nilai',
        'kategori_nilai',
    ];
}
