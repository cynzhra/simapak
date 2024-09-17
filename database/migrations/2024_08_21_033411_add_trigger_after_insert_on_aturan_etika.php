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
        DB::unprepared('
            CREATE TRIGGER calculate_aturan_etika_score
                BEFORE INSERT ON aturan_etika
                FOR EACH ROW
                BEGIN
                    SET NEW.bobot_nilai = (
                        NEW.patuh_aturan * 0.20 +
                        NEW.etika_kerja * 0.15 +
                        NEW.integritas * 0.30 +
                        NEW.tanggungjawab * 0.25 +
                        NEW.disiplin * 0.10
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
            CREATE TRIGGER calculate_aturan_etika_score_update
            BEFORE UPDATE ON aturan_etika
            FOR EACH ROW
            BEGIN
            SET NEW.bobot_nilai = (
                        NEW.patuh_aturan * 0.20 +
                        NEW.etika_kerja * 0.15 +
                        NEW.integritas * 0.30 +
                        NEW.tanggungjawab * 0.25 +
                        NEW.disiplin * 0.10
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
        DB::unprepared('DROP TRIGGER IF EXISTS calculate_aturan_etika_score');
        DB::unprepared('DROP TRIGGER IF EXISTS calculate_aturan_etika_score_update');
    }
};