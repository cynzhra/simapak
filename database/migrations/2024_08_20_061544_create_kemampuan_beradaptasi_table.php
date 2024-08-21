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
        Schema::create('kemampuan_beradaptasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            $table->integer('fleksibilitas');
            $table->integer('adaptabilitas');
            $table->integer('mengatasi_hambatan');
            $table->integer('pembelajaran_cepat');
            $table->integer('umpan_balik');
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
        Schema::dropIfExists('kemampuan_beradaptasi');
    }
};
