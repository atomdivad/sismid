<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pids', function (Blueprint $table) {
            $table->increments('idPid');
            $table->string('nome', 255);
            $table->string('email', 255);
            $table->string('url', 255)->nullable();

            $table->unsignedInteger('tipo_id')->nullable();
            $table->foreign('tipo_id')
                ->references('idTipo')
                ->on('pidTipos');

            $table->unsignedInteger('endereco_id');
            $table->foreign('endereco_id')
                ->references('idEndereco')
                ->on('enderecos');

            $table->timestamps();
            $table->softDeletes();
        });

        /*
         * Tabela de relacionamento PID-TELEFONES (many to many)
         */
        Schema::create('pid_telefones', function (Blueprint $table) {
            $table->unsignedInteger('pid_id');
            $table->foreign('pid_id')
                ->references('idPid')
                ->on('pids')
                ->onDelete('cascade');

            $table->unsignedInteger('telefone_id');
            $table->foreign('telefone_id')
                ->references('idTelefone')
                ->on('telefones');
        });

        /*
         * Tabela de relacionamento PID-INSTITUICOES (many to many)
         */
        Schema::create('pid_instituicoes', function (Blueprint $table) {
            $table->unsignedInteger('pid_id');
            $table->foreign('pid_id')
                ->references('idPid')
                ->on('pids')
                ->onDelete('cascade');

            $table->unsignedInteger('instituicao_id');
            $table->foreign('instituicao_id')
                ->references('idInstituicao')
                ->on('instituicoes');
        });

        /*
         * Tabela de relacionamento PID-INICIATIVAS (many to many)
         */
        Schema::create('pid_iniciativas', function (Blueprint $table) {
            $table->unsignedInteger('pid_id');
            $table->foreign('pid_id')
                ->references('idPid')
                ->on('pids')
                ->onDelete('cascade');

            $table->unsignedInteger('iniciativa_id');
            $table->foreign('iniciativa_id')
                ->references('idIniciativa')
                ->on('iniciativas');
        });

        /**
         * Relacionamento many to many PID-SERVICOS
         */
        Schema::create('pid_servicos', function (Blueprint $table) {
            $table->unsignedInteger('pid_id');
            $table->foreign('pid_id')->references('idPid')->on('pids');

            $table->unsignedInteger('servico_id');
            $table->foreign('servico_id')->references('idServico')->on('servicos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pid_telefones');
        Schema::drop('pid_instituicoes');
        Schema::drop('pid_iniciativas');
        Schema::drop('pid_servicos');
        Schema::drop('pids');
    }
}
