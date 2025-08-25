<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Tambahkan kolom relasi ke SPT
            $table->unsignedBigInteger('spt_id')->nullable()->after('id');
            $table->foreign('spt_id')->references('id')->on('spts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['spt_id']);
            $table->dropColumn('spt_id');
        });
    }
};
