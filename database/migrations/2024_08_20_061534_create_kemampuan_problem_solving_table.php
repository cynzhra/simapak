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
        Schema::create('kemampuan_problem_solving', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            $table->integer('identifikasi_masalah');
            $table->integer('analisis');
            $table->integer('kreativitas_solusi');
            $table->integer('implementasi_solusi');
            $table->integer('evaluasi_solusi');
            $table->double('bobot_nilai');
            $table->string('kategori_nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kemampuan_problem_solving');
    }
};
