<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class telefoneTiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('telefoneTipos')->insert(['idTipo' => 1, 'tipo' => 'Celular']);
        DB::table('telefoneTipos')->insert(['idTipo' => 2, 'tipo' => 'Residencial']);
        DB::table('telefoneTipos')->insert(['idTipo' => 3, 'tipo' => 'Comercial']);
    }
}
