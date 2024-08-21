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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 255)->unique();
            $table->string('nama');
            $table->integer('umur');
            $table->enum('jk', ['p', 'l']);
            $table->string('jabatan');
            $table->enum('pendidikan', ['sd', 'smp', 'sma', 'd3', 'd4', 's1', 's2', 's3']);
            $table->string('unit_kerja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
