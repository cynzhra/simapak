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
            'nip' => 'required|exists:karyawan,nip',
            'pengetahuan' => 'required|numeric',
            'keterampilan' => 'required|numeric',
            'pengalaman' => 'required|numeric',
            'implementasi' => 'required|numeric',
            'sertifikasi' => 'required|numeric',
        ]);
        $karyawan = Karyawan::where('nip', $validatedData['nip'])->first();

        // Jika karyawan tidak ditemukan
        if (!$karyawan) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        }

        $kemampuanTeknis = KemampuanTeknis::create($validatedData);
        return response()->json($kemampuanTeknis);
    }

    public function getKemampuanTeknis(Request $request)
    {
        $search = $request->input('search');
        $kemampuanTeknis = KemampuanTeknis::where('nip', '=', "{$search}")
            ->get();

        return response()->json($kemampuanTeknis);
    }

    public function editKemampuanTeknis(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'pengetahuan' => 'required|numeric',
            'keterampilan' => 'required|numeric',
            'pengalaman' => 'required|numeric',
            'implementasi' => 'required|numeric',
            'sertifikasi' => 'required|numeric',
        ]);

        $kemampuanTeknis = KemampuanTeknis::find($id);

        // Jika kemampuan teknis tidak ditemukan
        if (!$kemampuanTeknis) {
            return response()->json(['error' => 'Kemampuan teknis tidak ditemukan'], 404);
        }

        // Isi data kemampuan teknis dengan data validasi
        $kemampuanTeknis->fill($validatedData);
        $kemampuanTeknis->save();

        return response()->json($kemampuanTeknis);
    }




    public function calculateKualitasPekerjaan(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nip' => 'required|exists:karyawan,nip',
            'ketepatan' => 'required|numeric',
            'ketelitian' => 'required|numeric',
            'kreativitas' => 'required|numeric',
            'kepatuhan' => 'required|numeric',
            'tepat_waktu' => 'required|numeric',
        ]);

        $karyawan = Karyawan::where('nip', $validatedData['nip'])->first();

        // Jika karyawan tidak ditemukan
        if (!$karyawan) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        }

        $kualitasPekerjaan = KualitasPekerjaan::create($validatedData);
        return response()->json($kualitasPekerjaan);
    }
    public function getKualitasPekerjaan(Request $request)
    {
        $search = $request->input('search');
        $kualitasPekerjaan = KualitasPekerjaan::where('nip', '=', "{$search}")
            ->get();

        return response()->json($kualitasPekerjaan);
    }

    public function editKualitasPekerjaan(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'ketepatan' => 'required|numeric',
            'ketelitian' => 'required|numeric',
            'kreativitas' => 'required|numeric',
            'kepatuhan' => 'required|numeric',
            'tepat_waktu' => 'required|numeric',
        ]);

        $kualitasPekerjaan = KualitasPekerjaan::find($id);

        // Jika kemampuan teknis tidak ditemukan
        if (!$kualitasPekerjaan) {
            return response()->json(['error' => 'Kualitas Pekerjaan tidak ditemukan'], 404);
        }

        // Isi data kemampuan teknis dengan data validasi
        $kualitasPekerjaan->fill($validatedData);
        $kualitasPekerjaan->save();

        return response()->json($kualitasPekerjaan);
    }

    public function calculateProblemSolving(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nip' => 'required|exists:karyawan,nip',
            'identifikasi_masalah' => 'required|numeric',
            'analisis' => 'required|numeric',
            'kreativitas_solusi' => 'required|numeric',
            'implementasi_solusi' => 'required|numeric',
            'evaluasi_solusi' => 'required|numeric',
        ]);
        $karyawan = Karyawan::where('nip', $validatedData['nip'])->first();

        // Jika karyawan tidak ditemukan
        if (!$karyawan) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        }

        $problemSolving = KemampuanProblemSolving::create($validatedData);
        return response()->json($problemSolving);
    }

    public function getProblemSolving(Request $request)
    {
        $search = $request->input('search');
        $kemampuanProblemSolving = KemampuanProblemSolving::where('nip', '=', "{$search}")
            ->get();

        return response()->json($kemampuanProblemSolving);
    }

    public function editProblemSolving(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'identifikasi_masalah' => 'required|numeric',
            'analisis' => 'required|numeric',
            'kreativitas_solusi' => 'required|numeric',
            'implementasi_solusi' => 'required|numeric',
            'evaluasi_solusi' => 'required|numeric',
        ]);

        $kemampuanProblemSolving = KemampuanProblemSolving::find($id);

        // Jika kemampuan teknis tidak ditemukan
        if (!$kemampuanProblemSolving) {
            return response()->json(['error' => 'Kemampuan Problem Solving tidak ditemukan'], 404);
        }

        // Isi data kemampuan teknis dengan data validasi
        $kemampuanProblemSolving->fill($validatedData);
        $kemampuanProblemSolving->save();

        return response()->json($kemampuanProblemSolving);
    }


    public function calculateKemampuanBeradaptasi(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nip' => 'required|exists:karyawan,nip',
            'fleksibilitas' => 'required|numeric',
            'adaptabilitas' => 'required|numeric',
            'mengatasi_hambatan' => 'required|numeric',
            'pembelajaran_cepat' => 'required|numeric',
            'umpan_balik' => 'required|numeric',
        ]);

        $karyawan = Karyawan::where('nip', $validatedData['nip'])->first();

        // Jika karyawan tidak ditemukan
        if (!$karyawan) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        }

        $kemampuanBeradaptasi = KemampuanBeradaptasi::create($validatedData);
        return response()->json($kemampuanBeradaptasi);
    }
    public function getKemampuanBeradaptasi(Request $request)
    {
        $search = $request->input('search');
        $kemampuanBeradaptasi = KemampuanBeradaptasi::where('nip', '=', "{$search}")
            ->get();

        return response()->json($kemampuanBeradaptasi);
    }

    public function editKemampuanBeradaptasi(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'fleksibilitas' => 'required|numeric',
            'adaptabilitas' => 'required|numeric',
            'mengatasi_hambatan' => 'required|numeric',
            'pembelajaran_cepat' => 'required|numeric',
            'umpan_balik' => 'required|numeric',
        ]);

        $kemampuanBeradaptasi = KemampuanBeradaptasi::find($id);

        // Jika kemampuan teknis tidak ditemukan
        if (!$kemampuanBeradaptasi) {
            return response()->json(['error' => 'Kemampuan Beradaptasi tidak ditemukan'], 404);
        }

        // Isi data kemampuan teknis dengan data validasi
        $kemampuanBeradaptasi->fill($validatedData);
        $kemampuanBeradaptasi->save();

        return response()->json($kemampuanBeradaptasi);
    }

    public function calculateKerjasamaTim(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nip' => 'required|exists:karyawan,nip',
            'komunikasi' => 'required|numeric',
            'kolaborasi' => 'required|numeric',
            'komitmen' => 'required|numeric',
            'penyelesaian_konflik' => 'required|numeric',
            'kontribusi' => 'required|numeric',
        ]);

        $karyawan = Karyawan::where('nip', $validatedData['nip'])->first();

        // Jika karyawan tidak ditemukan
        if (!$karyawan) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        }

        $kerjasamaTim = KerjasamaTim::create($validatedData);
        return response()->json($kerjasamaTim);
    }

    public function getKerjasamaTim(Request $request)
    {
        $search = $request->input('search');
        $kerjasamaTim = KerjasamaTim::where('nip', '=', "{$search}")
            ->get();

        return response()->json($kerjasamaTim);
    }

    public function editKerjasamaTim(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'komunikasi' => 'required|numeric',
            'kolaborasi' => 'required|numeric',
            'komitmen' => 'required|numeric',
            'penyelesaian_konflik' => 'required|numeric',
            'kontribusi' => 'required|numeric',
        ]);

        $kerjasamaTim= KerjasamaTim::find($id);

        // Jika kemampuan teknis tidak ditemukan
        if (!$kerjasamaTim) {
            return response()->json(['error' => 'Kerjasama Tim tidak ditemukan'], 404);
        }

        // Isi data kemampuan teknis dengan data validasi
        $kerjasamaTim->fill($validatedData);
        $kerjasamaTim->save();

        return response()->json($kerjasamaTim);
    }


    public function calculateAturanEtika(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nip' => 'required|exists:karyawan,nip',
            'patuh_aturan' => 'required|numeric',
            'etika_kerja' => 'required|numeric',
            'integritas' => 'required|numeric',
            'tanggungjawab' => 'required|numeric',
            'disiplin' => 'required|numeric',
        ]);

        $karyawan = Karyawan::where('nip', $validatedData['nip'])->first();

        // Jika karyawan tidak ditemukan
        if (!$karyawan) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        }

        $aturanEtika = AturanEtika::create($validatedData);
        return response()->json($aturanEtika);
    }
    public function getAturanEtika(Request $request)
    {
        $search = $request->input('search');
        $aturanEtika = AturanEtika::where('nip', '=', "{$search}")
            ->get();

        return response()->json($aturanEtika);
    }

    public function editAturanEtika(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'patuh_aturan' => 'required|numeric',
            'etika_kerja' => 'required|numeric',
            'integritas' => 'required|numeric',
            'tanggungjawab' => 'required|numeric',
            'disiplin' => 'required|numeric',
        ]);

        $aturanEtika= AturanEtika::find($id);

        // Jika kemampuan teknis tidak ditemukan
        if (!$aturanEtika) {
            return response()->json(['error' => 'Aturan Etika tidak ditemukan'], 404);
        }

        // Isi data kemampuan teknis dengan data validasi
        $aturanEtika->fill($validatedData);
        $aturanEtika->save();

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
            'nip'  => 'required|numeric',
            'kemampuan_teknis_id' => 'required|numeric',
            'kualitas_pekerjaan_id' => 'required|numeric',
            'problem_solving_id' => 'required|numeric',
            'kemampuan_beradaptasi_id' => 'required|numeric',
            'kerjasama_tim_id' => 'required|numeric',
            'aturan_etika_id' => 'required|numeric',
        ]);

        $karyawan = Karyawan::where('nip', $validatedData['nip'])->first();

        // Jika karyawan tidak ditemukan
        if (!$karyawan) {
            return response()->json(['error' => 'Karyawan tidak ditemukan'], 404);
        }

        $penilaianKinerja = PenilaianKinerja::create($validatedData);
        return response()->json($penilaianKinerja);
    }
}
