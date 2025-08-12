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
