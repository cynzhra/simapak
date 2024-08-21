<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaian_kinerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            $table->foreignId('kemampuan_teknis_id')->constrained('kemampuan_teknis')->onDelete('cascade');
            $table->foreignId('kualitas_pekerjaan_id')->constrained('kualitas_pekerjaan')->onDelete('cascade');
            $table->foreignId('problem_solving_id')->constrained('kemampuan_problem_solving')->onDelete('cascade');
            $table->foreignId('kemampuan_beradaptasi_id')->constrained('kemampuan_beradaptasi')->onDelete('cascade');
            $table->foreignId('kerjasama_tim_id')->constrained('kerjasama_tim')->onDelete('cascade');
            $table->foreignId('aturan_etika_id')->constrained('aturan_etika')->onDelete('cascade');
            $table->double('bobot_nilai_akhir');
            $table->string('kategori_nilai_akhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_kinerja');
    }
};
