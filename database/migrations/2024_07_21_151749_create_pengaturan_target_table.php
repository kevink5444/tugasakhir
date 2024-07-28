<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaturanTargetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaturan_target', function (Blueprint $table) {
            $table->id('id_target');
            $table->unsignedBigInteger('id_pekerjaan');
            $table->integer('target_mingguan');
            $table->timestamps();
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
        Schema::dropIfExists('pengaturan_target');
    }
}
