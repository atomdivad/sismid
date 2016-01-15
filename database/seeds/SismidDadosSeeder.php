<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class SismidDadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sismid_dados')->insert(['id' => 1,
            'email' => 'sismid@sismid.ibict.br',
            'endereco' => 'Setor de autarquias sul - DF',
            'telefone' => '(61) 1111-1111',
            'info_equipe' => 'Teste',
            'created_at' => \Carbon\Carbon::now()
        ]);

    }
}
