<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE TRIGGER `penilaian_kinerja_before_insert`
            BEFORE INSERT ON `penilaian_kinerja`
            FOR EACH ROW
            BEGIN
                SET NEW.bobot_nilai_akhir = (
                    ((SELECT bobot_nilai FROM kemampuan_teknis WHERE id = NEW.kemampuan_teknis_id) * 0.2) +
                    ((SELECT bobot_nilai FROM kualitas_pekerjaan WHERE id = NEW.kualitas_pekerjaan_id) * 0.2) +
                    ((SELECT bobot_nilai FROM kemampuan_problem_solving WHERE id = NEW.problem_solving_id) * 0.2) +
                    ((SELECT bobot_nilai FROM kemampuan_beradaptasi WHERE id = NEW.kemampuan_beradaptasi_id) * 0.3) +
                    ((SELECT bobot_nilai FROM kerjasama_tim WHERE id = NEW.kerjasama_tim_id) * 0.1) +
                    ((SELECT bobot_nilai FROM aturan_etika WHERE id = NEW.aturan_etika_id) * 0)
                    );

                    IF NEW.bobot_nilai_akhir > 90 THEN
                                SET NEW.kategori_nilai_akhir = "Sangat Baik";
                            ELSEIF NEW.bobot_nilai_akhir > 80 AND NEW.bobot_nilai_akhir <= 90 THEN
                                SET NEW.kategori_nilai_akhir = "Baik";
                            ELSEIF NEW.bobot_nilai_akhir > 70 AND NEW.bobot_nilai_akhir <= 80 THEN
                                SET NEW.kategori_nilai_akhir = "Cukup";
                            ELSEIF NEW.bobot_nilai_akhir > 60 AND NEW.bobot_nilai_akhir <= 70 THEN
                                SET NEW.kategori_nilai_Akhir = "Kurang";
                            ELSE
                                SET NEW.kategori_nilai_Akhir = "Buruk";
                            END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS penilaian_kinerja_before_insert');
    }
};