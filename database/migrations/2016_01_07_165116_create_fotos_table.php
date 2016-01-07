<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos', function (Blueprint $table) {
            $table->increments('idFoto');
            $table->string('nome', 255);
            $table->string('arquivo', 255);
            $table->unsignedInteger('pid_id');
            $table->foreign('pid_id')->references('idPid')->on('pids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fotos');
    }
}
