<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class dimensoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dimensoes')->insert(['idDimensao' => 1, 'dimensao' => 'Infraestrutura e Acesso de Comunicação']);
        DB::table('dimensoes')->insert(['idDimensao' => 2, 'dimensao' => 'Equipamentos']);
        DB::table('dimensoes')->insert(['idDimensao' => 3, 'dimensao' => 'Treinamento']);
        DB::table('dimensoes')->insert(['idDimensao' => 4, 'dimensao' => 'Capacitação Intelectual']);
        DB::table('dimensoes')->insert(['idDimensao' => 5, 'dimensao' => 'Produção de Conteúdo']);
        DB::table('dimensoes')->insert(['idDimensao' => 6, 'dimensao' => 'Produção de Ferramenta']);
    }
}
