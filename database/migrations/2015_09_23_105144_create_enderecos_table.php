<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Criando tabela de Localizações
         */
        Schema::create('localizacoes', function (Blueprint $table) {
            $table->increments('idLocalizacao');
            $table->string('localizacao', 50);
        });

        /*
         * Criando tabela de Localidades
         */
        Schema::create('localidades', function (Blueprint $table) {
            $table->increments('idLocalidade');
            $table->string('localidade', 50);
        });

        /*
         * Criando tabela UF
         */
        Schema::create('uf', function (Blueprint $table) {
            $table->increments('idUf');
            $table->string('uf', 2);
        });

        /*
         * Criando tabela de Cidades
         */
        Schema::create('cidades', function (Blueprint $table) {
            $table->increments('idCidade');
            $table->string('nomeCidade', 255);
            $table->unsignedInteger('uf_id');

            $table->foreign('uf_id')
                ->references('idUf')
                ->on('uf')
                ->onDelete('cascade');
        });

        /*
         * Criando tabela de Endereços
         */
        Schema::create('enderecos', function (Blueprint $table) {
            $table->increments('idEndereco');
            $table->string('cep', 25);
            $table->string('logradouro', 150);
            $table->string('numero', 25)->nullable();
            $table->string('complemento', 200)->nullable();
            $table->string('bairro', 150);
            $table->string('latitude', 50);
            $table->string('longitude', 50);

            $table->unsignedInteger('cidade_id');
            $table->unsignedInteger('localizacao_id');
            $table->unsignedInteger('localidade_id');

            $table->foreign('cidade_id')
                ->references('idCidade')
                ->on('cidades');

            $table->foreign('localizacao_id')
                ->references('idLocalizacao')
                ->on('localizacoes');

            $table->foreign('localidade_id')
                ->references('idLocalidade')
                ->on('localidades');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enderecos');
        Schema::drop('cidades');
        Schema::drop('uf');
        Schema::drop('localidades');
        Schema::drop('localizacoes');
    }
}
