<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // Data identitas laporan
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal_laporan')->nullable();
            $table->string('nama_pelapor')->nullable();

            // Bagian sesuai format laporan
            $table->text('dasar')->nullable();
            $table->text('maksud_tujuan')->nullable();
            $table->text('waktu_pelaksanaan')->nullable();
            $table->text('nama_petugas')->nullable();
            $table->text('daerah_tujuan')->nullable();
            $table->text('hadir')->nullable();
            $table->longText('petunjuk')->nullable();
            $table->longText('masalah')->nullable();
            $table->longText('saran')->nullable();
            $table->longText('lain_lain')->nullable();

            // File laporan
            $table->string('foto_kegiatan'); // wajib
            $table->string('scan_hardcopy'); // wajib
            $table->string('e_toll')->nullable();
            $table->string('bbm')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
