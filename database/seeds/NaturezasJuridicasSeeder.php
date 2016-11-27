<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class NaturezasJuridicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 1, 'naturezaJuridica' => 'Órgão Público do Poder Executivo']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 2, 'naturezaJuridica' => 'Órgão Público do Poder Legislativo']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 3, 'naturezaJuridica' => 'Órgão Público do Poder Judiciário']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 4, 'naturezaJuridica' => 'Autarquias']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 5, 'naturezaJuridica' => 'Fundações (federal, estadual, municipal)']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 6, 'naturezaJuridica' => 'Associações']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 7, 'naturezaJuridica' => 'Empresa Pública']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 8, 'naturezaJuridica' => 'Sociedade (anônimas, empresariais)']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 9, 'naturezaJuridica' => 'Cooperativas']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 10, 'naturezaJuridica' => 'Consórcios']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 11, 'naturezaJuridica' => 'Entidades sem fins Lucrativos']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 12, 'naturezaJuridica' => 'Pessoa física']);
        DB::table('naturezasJuridicas')->insert(['idNatureza' => 13, 'naturezaJuridica' => 'Organização internacional e outras instituições extraterritoriais']);
    }
}
