<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Trigger to calculate bobot_nilai on INSERT
        DB::unprepared('
            CREATE TRIGGER calculate_kemampuan_teknis_score_insert
            BEFORE INSERT ON kemampuan_teknis
            FOR EACH ROW
            BEGIN
                 SET NEW.bobot_nilai = (
                    (NEW.pengetahuan * 0.20) +
                    (NEW.keterampilan * 0.20) +
                    (NEW.pengalaman * 0.20) +
                    (NEW.implementasi * 0.30) +
                    (NEW.sertifikasi * 0.10)
                );

                IF NEW.bobot_nilai > 90 THEN
                    SET NEW.kategori_nilai = "Sangat Baik";
                ELSEIF NEW.bobot_nilai > 80 AND NEW.bobot_nilai <= 90 THEN
                    SET NEW.kategori_nilai = "Baik";
                ELSEIF NEW.bobot_nilai > 70 AND NEW.bobot_nilai <= 80 THEN
                    SET NEW.kategori_nilai = "Cukup";
                ELSEIF NEW.bobot_nilai > 60 AND NEW.bobot_nilai <= 70 THEN
                    SET NEW.kategori_nilai = "Kurang";
                ELSE
                    SET NEW.kategori_nilai = "Buruk";
                END IF;
            END
        ');

        // Trigger to calculate bobot_nilai on UPDATE
        DB::unprepared('
            CREATE TRIGGER calculate_kemampuan_teknis_score_update
            BEFORE UPDATE ON kemampuan_teknis
            FOR EACH ROW
            BEGIN
                SET NEW.bobot_nilai = (
                    (NEW.pengetahuan * 0.20) +
                    (NEW.keterampilan * 0.20) +
                    (NEW.pengalaman * 0.20) +
                    (NEW.implementasi * 0.30) +
                    (NEW.sertifikasi * 0.10)
                );

                IF NEW.bobot_nilai > 90 THEN
                    SET NEW.kategori_nilai = "Sangat Baik";
                ELSEIF NEW.bobot_nilai > 80 AND NEW.bobot_nilai <= 90 THEN
                    SET NEW.kategori_nilai = "Baik";
                ELSEIF NEW.bobot_nilai > 70 AND NEW.bobot_nilai <= 80 THEN
                    SET NEW.kategori_nilai = "Cukup";
                ELSEIF NEW.bobot_nilai > 60 AND NEW.bobot_nilai <= 70 THEN
                    SET NEW.kategori_nilai = "Kurang";
                ELSE
                    SET NEW.kategori_nilai = "Buruk";
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS calculate_kemampuan_teknis_score_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS calculate_kemampuan_teknis_score_update');
    }
};
