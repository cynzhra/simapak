<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KemampuanProblemSolving extends Model
{
    use HasFactory;
    protected $table = 'kemampuan_problem_solving';

    protected $fillable = [
        'nip',
        'identifikasi_masalah',
        'analisis',
        'kreativitas_solusi',
        'implementasi_solusi',
        'evaluasi_solusi',
        'bobot_nilai',
        'kategori_nilai',
    ];
}