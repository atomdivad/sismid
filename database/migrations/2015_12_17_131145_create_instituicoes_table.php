<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstituicoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instituicoes', function (Blueprint $table) {
            $table->increments('idInstituicao');
            $table->string('nome', 255);

            $table->unsignedInteger('endereco_id');
            $table->foreign('endereco_id')
                ->references('idEndereco')
                ->on('enderecos');

            $table->unsignedInteger('naturezaJuridica_id')->nullable();;
            $table->foreign('naturezaJuridica_id')
                ->references('idNatureza')
                ->on('naturezasJuridicas');

            $table->string('email', 255);
            $table->string('url', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        /*
         * Tabela de relacionamento INSTITUICAO-TELEFONES (many to many)
         */
        Schema::create('instituicao_telefones', function (Blueprint $table) {
            $table->unsignedInteger('idInstituicao');
            $table->foreign('idInstituicao')
                ->references('idInstituicao')
                ->on('instituicoes')
                ->onDelete('cascade');

            $table->unsignedInteger('idTelefone');
            $table->foreign('idTelefone')
                ->references('idTelefone')
                ->on('telefones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('instituicao_telefones');
        Schema::drop('instituicoes');
    }
}
