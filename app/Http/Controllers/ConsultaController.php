<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        return view('consultas.index', compact('uf'));
    }

    public function search(Request $request)
    {
        $agrupamento = $request['agrupamento'];
        $uf = $request['uf'];
        $cidade = $request['cidade'];
        $tipo = $request['tipo'];
        if(isset($request['ativo'])) {
            switch($request['ativo']) {
                case 1:
                    $ativo = [1];
                    break;
                case 2:
                    $ativo = [0];
                    break;
                case 3:
                    $ativo = [1,0];
                    break;
            }
        }
        else {
            $ativo = [1];
        }

        if(isset($request['localizacao'])) {
            switch($request['localizacao']) {
                case 1: /*Área Urbana*/
                    $localizacao = [1];
                    break;
                case 2:/*Áre não urbana*/
                    $localizacao = [2];
                    break;
                case 3:/*Todas*/
                    $localizacao = [0,1,2];
                    break;
            }
        }
        else {
            $localizacao = [1,2];
        }

        if($agrupamento == 0 || $uf != 0) {
            if($uf != 0) {
                if($cidade != '') {
                    /*busca pid/iniciativa de uma cidade*/
                    return $this->getDadosByCidade($cidade, $tipo, $ativo, $localizacao);
                }
                else {
                    /*busca pid/iniciativa de um estado*/
                    return $this->getDadosByUf([$uf], $tipo, $ativo, $localizacao);
                }
            }
            else {
                /*busca todos os pid/iniciativa*/
                return $this->getDados($tipo, $ativo, $localizacao);
            }
        }
        else {
            switch($agrupamento) {

                case '1':
                    /*Centro Oeste*/
                    return $this->getDadosByUf([50, 51, 52, 53], $tipo, $ativo, $localizacao);
                    break;

                case '2':
                    /*Norte*/
                    return $this->getDadosByUf([11, 12, 13, 14, 15, 16, 17], $tipo, $ativo, $localizacao);
                    break;

                case '3':
                    /*Nordeste*/
                    return $this->getDadosByUf([21, 22, 23, 24, 25, 26, 27, 28, 29], $tipo, $ativo, $localizacao);
                    break;

                case '4':
                    /*Sul*/
                    return $this->getDadosByUf([41, 42, 43], $tipo, $ativo, $localizacao);
                    break;

                case '5':
                    /*Suldeste*/
                    return $this->getDadosByUf([31, 32, 33, 35], $tipo, $ativo, $localizacao);
                    break;
            }
        }
    }

    private function getDadosByCidade($idCidade, $tipo, $ativo, $localizacao)
    {
        $pids = $iniciativas = [];

        $iniciativas = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
            ->select('iniciativas.idIniciativa as id', 'iniciativas.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
            ->where('cidades.idCidade', '=', $idCidade)
            ->whereIn('iniciativas.tipo_id', $tipo)
            ->whereIn('enderecos.localizacao_id', $localizacao)
            ->get();

        if(in_array(0, $tipo)) {
            $pids = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->where('cidades.idCidade', '=', $idCidade)
                ->whereIn('pids.ativo', $ativo)
                ->whereIn('enderecos.localizacao_id', $localizacao)
                ->get();
        }

        return response()->json(['pids' => $pids, 'iniciativas' => $iniciativas]);

    }

    private function getDadosByUf($uf, $tipo, $ativo, $localizacao)
    {
        $pids = $iniciativas = [];

        $iniciativas = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
            ->select('iniciativas.idIniciativa as id', 'iniciativas.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
            ->whereIn('cidades.uf_id', $uf)
            ->whereIn('iniciativas.tipo_id', $tipo)
            ->whereIn('enderecos.localizacao_id', $localizacao)
            ->orderBy('cidades.nomeCidade', 'asc')
            ->get();

        if(in_array(0, $tipo)) {
            $pids = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->whereIn('cidades.uf_id', $uf)
                ->whereIn('pids.ativo', $ativo)
                ->whereIn('enderecos.localizacao_id', $localizacao)
                ->orderBy('cidades.nomeCidade', 'asc')
                ->get();
        }
        return response()->json(['pids' => $pids, 'iniciativas' => $iniciativas]);
    }

    private function getDados($tipo, $ativo, $localizacao)
    {
        $pids = $iniciativas = [];

        $iniciativas = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
            ->select('iniciativas.idIniciativa as id', 'iniciativas.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
            ->whereIn('iniciativas.tipo_id', $tipo)
            ->whereIn('enderecos.localizacao_id', $localizacao)
            ->orderBy('uf.uf', 'asc')
            ->get();

        if(in_array(0, $tipo))
        {
            $pids = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid as id', 'pids.nome', 'pids.ativo', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->whereIn('pids.ativo', $ativo)
                ->whereIn('enderecos.localizacao_id', $localizacao)
                ->orderBy('uf.uf', 'asc')
                ->get();
        }

        return response()->json(['pids' => $pids, 'iniciativas' => $iniciativas]);
    }

}
