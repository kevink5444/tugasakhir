<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAbsensiTable extends Migration
{
    public function up()
    {
        Schema::table('absensi', function (Blueprint $table) {
            if (!Schema::hasColumn('absensi', 'id_karyawan')) {
                $table->unsignedBigInteger('id_karyawan');
            }
            if (!Schema::hasColumn('absensi', 'jam_masuk')) {
                $table->time('jam_masuk')->nullable();
            }
            if (!Schema::hasColumn('absensi', 'jam_keluar')) {
                $table->time('jam_keluar')->nullable();
            }

            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('absensi', function (Blueprint $table) {
            if (Schema::hasColumn('absensi', 'id_karyawan')) {
                $table->dropForeign(['id_karyawan']);
                $table->dropColumn('id_karyawan');
            }
            if (Schema::hasColumn('absensi', 'jam_masuk')) {
                $table->dropColumn('jam_masuk');
            }
            if (Schema::hasColumn('absensi', 'jam_keluar')) {
                $table->dropColumn('jam_keluar');
            }
        });
    }
}

