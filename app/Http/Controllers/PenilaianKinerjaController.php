<?php

namespace App\Http\Controllers;

use App\Models\AturanEtika;
use App\Models\Karyawan;
use App\Models\KemampuanBeradaptasi;
use App\Models\KemampuanProblemSolving;
use App\Models\KemampuanTeknis;
use App\Models\KerjasamaTim;
use App\Models\KualitasPekerjaan;
use App\Models\PenilaianKinerja;
use Illuminate\Http\Request;

class PenilaianKinerjaController extends Controller
{
    public function calculateKemampuanTeknis(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'karyawan_id',
            'pengetahuan' => 'required|numeric',
            'keterampilan' => 'required|numeric',
            'pengalaman' => 'required|numeric',
            'implementasi' => 'required|numeric',
            'sertifikasi' => 'required|numeric',
        ]);

        $kemampuanTeknis = KemampuanTeknis::create($validatedData);
        return response()->json($kemampuanTeknis);
    }

    public function calculateKualitasPekerjaan(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            // 'karyawan_id',
            'ketepatan' => 'required|numeric',
            'ketelitian' => 'required|numeric',
            'kreativitas' => 'required|numeric',
            'kepatuhan' => 'required|numeric',
            'tepat_waktu' => 'required|numeric',
        ]);

        $kualitasPekerjaan = KualitasPekerjaan::create($validatedData);
        return response()->json($kualitasPekerjaan);
    }

    public function calculateProblemSolving(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            // 'karyawan_id',
            'identifikasi_masalah' => 'required|numeric',
            'analisis' => 'required|numeric',
            'kreativitas_solusi' => 'required|numeric',
            'implementasi_solusi' => 'required|numeric',
            'evaluasi_solusi' => 'required|numeric',
        ]);

        $problemSolving = KemampuanProblemSolving::create($validatedData);
        return response()->json($problemSolving);
    }

    public function calculateKemampuanBeradaptasi(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            // 'karyawan_id',
            'fleksibilitas' => 'required|numeric',
            'adaptabilitas' => 'required|numeric',
            'mengatasi_hambatan' => 'required|numeric',
            'pembelajaran_cepat' => 'required|numeric',
            'umpan_balik' => 'required|numeric',
        ]);

        $kemampuanBeradaptasi = KemampuanBeradaptasi::create($validatedData);
        return response()->json($kemampuanBeradaptasi);
    }

    public function calculateKerjasamaTim(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            // 'karyawan_id',
            'komunikasi' => 'required|numeric',
            'kolaborasi' => 'required|numeric',
            'komitmen' => 'required|numeric',
            'penyelesaian_konflik' => 'required|numeric',
            'kontribusi' => 'required|numeric',
        ]);

        $kerjasamaTim = KerjasamaTim::create($validatedData);
        return response()->json($kerjasamaTim);
    }

    public function calculateAturanEtika(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'patuh_aturan' => 'required|numeric',
            'etika_kerja' => 'required|numeric',
            'integritas' => 'required|numeric',
            'tanggungjawab' => 'required|numeric',
            'disiplin' => 'required|numeric',
        ]);

        $aturanEtika = AturanEtika::create($validatedData);
        return response()->json($aturanEtika);
    }


    public function createPenilaianKinerja()
    {
        $karyawan = Karyawan::all();
        return redirect()->route('', compact('karyawan')); ///ini buat redirect ke form penilaian kinerjanya, terus dia bakal ngambil id karyawannya juga.
    }

    public function calculatePenilaianKinerja(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'karyawan_id'  => 'required|numeric',
            'kemampuan_teknis_id' => 'required|numeric',
            'kualitas_pekerjaan_id' => 'required|numeric',
            'problem_solving_id' => 'required|numeric',
            'kemampuan_beradaptasi_id' => 'required|numeric',
            'kerjasama_tim_id' => 'required|numeric',
            'aturan_etika_id' => 'required|numeric',
        ]);

        $penilaianKinerja = PenilaianKinerja::create($validatedData);
        return response()->json($penilaianKinerja);
    }
}
