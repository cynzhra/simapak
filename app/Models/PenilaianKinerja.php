<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianKinerja extends Model
{
    use HasFactory;

    protected $table = 'penilaian_kinerja';

    protected $fillable = [
        'karyawan_id',
        'kemampuan_teknis_id',
        'kualitas_pekerjaan_id',
        'problem_solving_id',
        'kemampuan_beradaptasi_id',
        'kerjasama_tim_id',
        'aturan_etika_id',
        'bobot_nilai_akhir',
        'kategori_nilai_akhir',
    ];

    public function kemampuanTeknis()
    {
        return $this->belongsTo(KemampuanTeknis::class, 'kemampuan_teknis_id');
    }
}
