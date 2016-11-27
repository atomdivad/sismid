<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class servicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servicos')->insert(['idServico' => 1, 'servico' => 'Acesso à Internet']);
        DB::table('servicos')->insert(['idServico' => 2, 'servico' => 'Acesso e/ou Gravação de mídias diversas(CDs, DVDs, pendrives)']);
        DB::table('servicos')->insert(['idServico' => 3, 'servico' => 'Transações de governo eletrônico (Detran, Tribunais etc.)']);
        DB::table('servicos')->insert(['idServico' => 4, 'servico' => 'Transações à órgãos privados (faculdades, bancos etc.)']);
        DB::table('servicos')->insert(['idServico' => 5, 'servico' => 'Cursos de capacitação profissional']);
        DB::table('servicos')->insert(['idServico' => 6, 'servico' => 'Treinamento em informática']);
        DB::table('servicos')->insert(['idServico' => 7, 'servico' => 'Publicação em website de conteúdos produzidos pela comunidade local']);
        DB::table('servicos')->insert(['idServico' => 8, 'servico' => 'Elaboração de currículos e outros textos']);
        DB::table('servicos')->insert(['idServico' => 9, 'servico' => 'Informações para turistas']);
        DB::table('servicos')->insert(['idServico' => 10, 'servico' => 'Edição de jornais locais/ comunitários']);
        DB::table('servicos')->insert(['idServico' => 11, 'servico' => 'Edição de folhetos e prospectos']);
        DB::table('servicos')->insert(['idServico' => 12, 'servico' => 'Palestras e seminários']);
        DB::table('servicos')->insert(['idServico' => 13, 'servico' => 'Disponibilização de programas que permitem ligações nacionais e internacionais (VOIP), Skype, ooVoo, etc']);
        DB::table('servicos')->insert(['idServico' => 14, 'servico' => 'Publicidade na web']);
        DB::table('servicos')->insert(['idServico' => 15, 'servico' => 'Curso a Distância (EAD)']);
        DB::table('servicos')->insert(['idServico' => 16, 'servico' => 'Consultoria em informática para pequenas empresas locais']);
        DB::table('servicos')->insert(['idServico' => 17, 'servico' => 'Serviço de impressão (teses, monografias, fotocópia, encadernação, etc.)']);
        DB::table('servicos')->insert(['idServico' => 18, 'servico' => 'Manutenção de computadores']);
        DB::table('servicos')->insert(['idServico' => 19, 'servico' => 'Fax']);
        DB::table('servicos')->insert(['idServico' => 20, 'servico' => 'Xerox']);
        DB::table('servicos')->insert(['idServico' => 21, 'servico' => 'Venda de créditos para celular']);
        DB::table('servicos')->insert(['idServico' => 22, 'servico' => 'Serviço de lanchonete (salgadinhos, café, refrigerantes, doces, salgados, etc.)']);
        DB::table('servicos')->insert(['idServico' => 23, 'servico' => 'Outros']);
    }
}
