<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('spts', function (Blueprint $table) {
        $table->unsignedBigInteger('penandatangan_id')->nullable()->after('file_scan');
        $table->foreign('penandatangan_id')->references('id')->on('penandatangans');
    });
}

public function down()
{
    Schema::table('spts', function (Blueprint $table) {
        $table->dropForeign(['penandatangan_id']);
        $table->dropColumn('penandatangan_id');
    });
}

};
