<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePidRevisaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pid_revisao', function (Blueprint $table) {
            $table->unsignedInteger('pid_id');

            $table->foreign('pid_id')
                ->references('idPid')
                ->on('pids')
                ->onDelete('cascade');

            $table->string('email', 255);
            $table->string('pass', 150);

            $table->boolean('submetido')->default(false);

            $table->boolean('valido')->default(true);

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
        Schema::drop('pid_revisao');
    }
}
