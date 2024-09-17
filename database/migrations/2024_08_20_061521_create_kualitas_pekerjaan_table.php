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
        Schema::create('kualitas_pekerjaan', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->constrained('karyawan')->onDelete('cascade');
            $table->integer('ketepatan');
            $table->integer('ketelitian');
            $table->integer('kreativitas');
            $table->integer('kepatuhan');
            $table->integer('tepat_waktu');
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
        Schema::dropIfExists('kualitas_pekerjaan');
    }
};