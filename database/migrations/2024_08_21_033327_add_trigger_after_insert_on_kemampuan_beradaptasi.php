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
        CREATE TRIGGER calculate_adaptasi_score
            BEFORE INSERT ON kemampuan_beradaptasi
            FOR EACH ROW
            BEGIN
                SET NEW.bobot_nilai = (
                    NEW.fleksibilitas * 0.20 +
                    NEW.adaptabilitas * 0.15 +
                    NEW.mengatasi_hambatan * 0.30 +
                    NEW.pembelajaran_cepat * 0.25 +
                    NEW.umpan_balik * 0.10
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
        DB::unprepared('DROP TRIGGER IF EXISTS calculate_adaptasi_score');
    }
};
