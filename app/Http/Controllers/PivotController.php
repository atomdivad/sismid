<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use SisMid\Http\Requests;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Usuario;
use Artesaos\Defender\Facades\Defender;

class PivotController extends Controller
{

    public function index()
    {
        return view("relatorios.pivoteamento.index");
    }

    public function getDados()
    {
        $iniciativas = DB::table('pids')
            ->join('pid_iniciativas', 'pids.idPid', '=', 'pid_iniciativas.pid_id')
            ->join('iniciativas', 'pid_iniciativas.iniciativa_id', '=', 'iniciativas.idIniciativa')
            ->join('pidTipos', 'pids.tipo_id', '=', 'pidTipos.idTipo')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->join('localizacoes', 'enderecos.localizacao_id', '=', 'localizacoes.idLocalizacao')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
            ->select('iniciativas.nome as Iniciativas', 'pidTipos.tipo as Tipo', 'localizacoes.localizacao as Localização', 'cidades.nomeCidade as Cidade', 'uf.uf as UF')
            // ->take(200)
            ->get();
        return $iniciativas;
    }

}
