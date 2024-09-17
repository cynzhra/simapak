<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KerjasamaTim extends Model
{
    use HasFactory;

    protected $table = 'kerjasama_tim';

    protected $fillable = [
        'nip',
        'komunikasi',
        'kolaborasi',
        'komitmen',
        'penyelesaian_konflik',
        'kontribusi',
        'bobot_nilai',
        'kategori_nilai',
    ];
}