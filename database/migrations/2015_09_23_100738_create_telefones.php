<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelefones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telefones', function (Blueprint $table) {
            $table->increments('idTelefone');
            $table->string('telefone', 20);
            $table->string('responsavel', 150);

            $table->unsignedInteger('telefoneTipo_id');
            $table->foreign('telefoneTipo_id')
                ->references('idTipo')
                ->on('telefoneTipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('telefones');
    }
}
