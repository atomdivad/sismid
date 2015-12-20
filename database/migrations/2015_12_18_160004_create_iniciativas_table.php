<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIniciativasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iniciativas', function (Blueprint $table) {
            $table->increments('idIniciativa');

            $table->unsignedInteger('tipo_id');
            $table->foreign('tipo_id')->references('idTipo')->on('iniciativaTipos');

            $table->string('nome', 255);
            $table->string('sigla', 10);

            $table->unsignedInteger('endereco_id');
            $table->foreign('endereco_id')->references('idEndereco')->on('enderecos');

            $table->unsignedInteger('naturezaJuridica_id');
            $table->foreign('naturezaJuridica_id')->references('idNatureza')->on('naturezasJuridicas');

            $table->string('email', 255);
            $table->string('url', 255);
            $table->longText('objetivo');
            $table->longText('informacaoComplementar');

            $table->unsignedInteger('categoria_id');
            $table->foreign('categoria_id')->references('idCategoria')->on('iniciativaCategorias');

            $table->string('fonte');
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * Relacionamento many to many telefones
         */
        Schema::create('iniciativa_telefones', function (Blueprint $table) {
            $table->unsignedInteger('iniciativa_id');
            $table->foreign('iniciativa_id')->references('idIniciativa')->on('iniciativas');

            $table->unsignedInteger('telefone_id');
            $table->foreign('telefone_id')->references('idTelefone')->on('telefones');

        });

        /**
         * Relacionamento many to many iniciativas
         */
        Schema::create('iniciativa_servicos', function (Blueprint $table) {
            $table->unsignedInteger('iniciativa_id');
            $table->foreign('iniciativa_id')->references('idIniciativa')->on('iniciativas');

            $table->unsignedInteger('servico_id');
            $table->foreign('servico_id')->references('idServico')->on('servicos');

        });

        /**
         * Relacionamento many to many dimensões
         */
        Schema::create('iniciativa_dimensoes', function (Blueprint $table) {
            $table->unsignedInteger('iniciativa_id');
            $table->foreign('iniciativa_id')->references('idIniciativa')->on('iniciativas');

            $table->unsignedInteger('dimensao_id');
            $table->foreign('dimensao_id')->references('idDimensao')->on('dimensoes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iniciativa_telefones');
        Schema::drop('iniciativa_servicos');
        Schema::drop('iniciativa_dimensoes');
        Schema::drop('iniciativas');
    }
}
