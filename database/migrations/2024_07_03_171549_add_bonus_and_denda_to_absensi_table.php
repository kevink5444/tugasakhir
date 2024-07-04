<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBonusAndDendaToAbsensiTable extends Migration
{
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->string('status_kehadiran')->nullable();
            $table->integer('bonus')->default(0);
            $table->integer('denda')->default(0);
        });
    }

    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn('status_kehadiran');
            $table->dropColumn('bonus');
            $table->dropColumn('denda');
        });
    }
}
