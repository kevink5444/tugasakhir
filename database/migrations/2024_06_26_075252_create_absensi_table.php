<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id_absensi');
            $table->unsignedBigInteger('id_karyawan');
            $table->string('nama_karyawan');
            $table->date('tanggal_absen');
            $table->time('waktu_masuk');
            $table->string('status')->default('Hadir'); // Status absensi
            $table->integer('bonus')->default(0); // Bonus harian
            $table->integer('denda')->default(0); // Denda harian
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi');
    }
}


