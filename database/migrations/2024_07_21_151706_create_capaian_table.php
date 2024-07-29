<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capaian', function (Blueprint $table) {
            $table->id('id_capaian');
            $table->unsignedBigInteger('id_karyawan');
            $table->unsignedBigInteger('id_pekerjaan');
            $table->integer('jumlah_capaian');
            $table->date('tanggal');
            $table->timestamps();
            $table->foreign('id_karyawan')->references('id_karyawan')->on('karyawan');
            $table->foreign('id_pekerjaan')->references('id_pekerjaan')->on('pekerjaan');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('capaian');
    }
}
