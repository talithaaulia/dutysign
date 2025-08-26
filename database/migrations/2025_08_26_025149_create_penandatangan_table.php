<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penandatangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');           // nama penandatangan
            $table->string('jabatan');        // jabatan (Sekretaris/Kepala)
            $table->string('pangkat_gol');    // pangkat/golongan
            $table->string('nip')->unique();  // NIP
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penandatangan');
    }
};
