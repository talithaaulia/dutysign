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
        Schema::table('spts', function (Blueprint $table) {
            $table->string('penandatangan_nama', 100)->nullable()->after('penandatangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spt', function (Blueprint $table) {
            $table->dropColumn('penandatangan_nama');
        });
    }
};
