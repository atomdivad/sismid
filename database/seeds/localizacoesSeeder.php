<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class localizacoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('localizacoes')->insert(['idLocalizacao ' => 1, 'localizacao' => 'Área Urbana']);
        DB::table('localizacoes')->insert(['idLocalizacao ' => 2, 'localizacao' => 'Área Não-Urbana']);
    }
}
