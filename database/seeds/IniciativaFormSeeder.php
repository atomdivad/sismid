<?php

use Illuminate\Database\Seeder;

class IniciativaFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('iniciativaTipos')->insert(['idTipo' => 1, 'tipo' => 'Programa']);
        DB::table('iniciativaTipos')->insert(['idTipo' => 2, 'tipo' => 'Projeto']);
        DB::table('iniciativaTipos')->insert(['idTipo' => 3, 'tipo' => 'Ação']);


        DB::table('iniciativaCategorias')->insert(['idCategoria' => 1, 'categoria' => 'Governo Federal']);
        DB::table('iniciativaCategorias')->insert(['idCategoria' => 2, 'categoria' => 'Governo Estadual']);
        DB::table('iniciativaCategorias')->insert(['idCategoria' => 3, 'categoria' => 'Governo Municipal']);
        DB::table('iniciativaCategorias')->insert(['idCategoria' => 4, 'categoria' => 'Tercerio Setor']);
    }
}
