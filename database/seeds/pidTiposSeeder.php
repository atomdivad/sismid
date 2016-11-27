<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pidTiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pidTipos')->insert(['idTipo' => 1, 'tipo' => 'Telecentro/Infocentro']);
        DB::table('pidTipos')->insert(['idTipo' => 2, 'tipo' => 'Laboratório de Informática']);
    }
}
