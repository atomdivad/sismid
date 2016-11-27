<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSismidDados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sismid_dados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255);
            $table->string('endereco', 255);
            $table->string('telefone', 255);
            $table->longText('info_equipe');
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
        Schema::drop('sismid_dados');
    }
}
