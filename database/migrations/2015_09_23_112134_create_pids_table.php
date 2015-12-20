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
            $table->string('nome', 200);
            $table->string('email', 200);
            $table->string('url', 200);

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
            $table->unsignedInteger('idPid');
            $table->foreign('idPid')
                ->references('idPid')
                ->on('pids')
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
        Schema::drop('pid_telefones');
        Schema::drop('pids');
    }
}
