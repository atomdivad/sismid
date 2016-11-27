<?php

namespace SisMid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Iniciativa;
use SisMid\Models\Pid;
use ZipArchive;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param $idCidade
     * @param $tipo
     * @param $ativo
     * @param $localizacao
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param $uf
     * @param $tipo
     * @param $ativo
     * @param $localizacao
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param $tipo
     * @param $ativo
     * @param $localizacao
     * @return \Illuminate\Http\JsonResponse
     */
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

        return (['pids' => $pids, 'iniciativas' => $iniciativas]);
    }

    /**
     * Retorna o arquivo csv da consulta
     * @param Request $request
     */
    public function download(Request $request)
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
                    $dados =  $this->getFullDadosByCidade($cidade, $tipo, $ativo, $localizacao);
                }
                else {
                    /*busca pid/iniciativa de um estado*/
                    $dados =  $this->getFullDadosByUf([$uf], $tipo, $ativo, $localizacao);
                }
            }
            else {
                /*busca todos os pid/iniciativa*/
                $dados =  $this->getFullDados($tipo, $ativo, $localizacao);
            }
        }
        else {
            switch($agrupamento) {

                case '1':
                    /*Centro Oeste*/
                    $dados =  $this->getFullDadosByUf([50, 51, 52, 53], $tipo, $ativo, $localizacao);
                    break;

                case '2':
                    /*Norte*/
                    $dados =  $this->getFullDadosByUf([11, 12, 13, 14, 15, 16, 17], $tipo, $ativo, $localizacao);
                    break;

                case '3':
                    /*Nordeste*/
                    $dados =  $this->getFullDadosByUf([21, 22, 23, 24, 25, 26, 27, 28, 29], $tipo, $ativo, $localizacao);
                    break;

                case '4':
                    /*Sul*/
                    $dados =  $this->getFullDadosByUf([41, 42, 43], $tipo, $ativo, $localizacao);
                    break;

                case '5':
                    /*Suldeste*/
                    $dados =  $this->getFullDadosByUf([31, 32, 33, 35], $tipo, $ativo, $localizacao);
                    break;
            }
        }

        /*Converte os dados de pids de stdClass para Array*/
        $pids = [];
        foreach($dados['pids'] as &$dados['pids']) {
            $pids[] = (array)$dados['pids'];
        }

        /*Converte os dados de iniciativas de stdClass para Array*/
        $iniciativas = [];
        foreach($dados['iniciativas'] as &$dados['iniciativas']) {
            $iniciativas[] = (array)$dados['iniciativas'];
        }

        $id = Carbon::now()->format('dmYhis');
        $pathPid = storage_path().'/consultas/pids'.$id.'.csv';
        $pathIniciativa = storage_path().'/consultas/iniciativas'.$id.'.csv';

        $handle = fopen($pathPid, 'w+');
        fputcsv($handle, array('id', 'nome', 'email', 'url', 'tipo_id', 'destaque', 'ativo', 'updated_at', 'nomeCidade', 'uf', 'logradouro', 'numero', 'latitude', 'longitude'));
        foreach($pids as $row) {
            fputcsv($handle, array(
                $row['id'],
                $row['nome'],
                $row['email'],
                $row['url'],
                $row['tipo_id'],
                $row['destaque'],
                $row['ativo'],
                $row['updated_at'],
                $row['nomeCidade'],
                $row['uf'],
                $row['logradouro'],
                $row['numero'],
                $row['latitude'],
                $row['longitude'],
            ));
        }
        fclose($handle);

        $handle = fopen($pathIniciativa, 'w+');
        fputcsv($handle, array('id', 'tipo_id', 'nome', 'sigla', 'email', 'url', 'objetivo', 'informacaoComplementar', 'categoria_id', 'fonte', 'nomeCidade', 'uf', 'logradouro', 'numero', 'latitude', 'longitude'));
        foreach($iniciativas as $row) {
            fputcsv($handle, array(
                $row['id'],
                $row['tipo_id'],
                $row['nome'],
                $row['sigla'],
                $row['email'],
                $row['url'],
                $row['objetivo'],
                $row['informacaoComplementar'],
                $row['categoria_id'],
                $row['fonte'],
                $row['nomeCidade'],
                $row['uf'],
                $row['logradouro'],
                $row['numero'],
                $row['latitude'],
                $row['longitude'],
            ));
        }
        fclose($handle);

        $zipPath = storage_path().'/consultas/consulta'.$id.'.zip';
        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE);
        $zip->addFile($pathPid, 'Pids.csv');
        $zip->addFile($pathIniciativa, 'Iniciativas.csv');
        $zip->close();

        unlink($pathPid);
        unlink($pathIniciativa);

        return Response::download($zipPath);
    }

    /**
     * @param $idCidade
     * @param $tipo
     * @param $ativo
     * @param $localizacao
     * @return \Illuminate\Http\JsonResponse
     */
    private function getFullDadosByCidade($idCidade, $tipo, $ativo, $localizacao)
    {
        $pids = $iniciativas = [];

        $iniciativas = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
            ->select('iniciativas.idIniciativa as id', 'iniciativas.tipo_id', 'iniciativas.nome', 'iniciativas.sigla', 'iniciativas.email', 'iniciativas.url', 'iniciativas.objetivo', 'iniciativas.informacaoComplementar', 'iniciativas.categoria_id', 'iniciativas.fonte', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
            ->where('cidades.idCidade', '=', $idCidade)
            ->whereIn('iniciativas.tipo_id', $tipo)
            ->whereIn('enderecos.localizacao_id', $localizacao)
            ->get();

        if(in_array(0, $tipo)) {
            $pids = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid as id', 'pids.nome', 'pids.email', 'pids.url', 'pids.tipo_id', 'pids.destaque', 'pids.ativo', 'pids.updated_at', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->where('cidades.idCidade', '=', $idCidade)
                ->whereIn('pids.ativo', $ativo)
                ->whereIn('enderecos.localizacao_id', $localizacao)
                ->get();
        }

        return (['pids' => $pids, 'iniciativas' => $iniciativas]);

    }

    /**
     * @param $uf
     * @param $tipo
     * @param $ativo
     * @param $localizacao
     * @return \Illuminate\Http\JsonResponse
     */
    private function getFullDadosByUf($uf, $tipo, $ativo, $localizacao)
    {
        $pids = $iniciativas = [];

        $iniciativas = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
            ->select('iniciativas.idIniciativa as id', 'iniciativas.tipo_id', 'iniciativas.nome', 'iniciativas.sigla', 'iniciativas.email', 'iniciativas.url', 'iniciativas.objetivo', 'iniciativas.informacaoComplementar', 'iniciativas.categoria_id', 'iniciativas.fonte', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
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
                ->select('pids.idPid as id', 'pids.nome', 'pids.email', 'pids.url', 'pids.tipo_id', 'pids.destaque', 'pids.ativo', 'pids.updated_at', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->whereIn('cidades.uf_id', $uf)
                ->whereIn('pids.ativo', $ativo)
                ->whereIn('enderecos.localizacao_id', $localizacao)
                ->orderBy('cidades.nomeCidade', 'asc')
                ->get();
        }
        return (['pids' => $pids, 'iniciativas' => $iniciativas]);
    }

    /**
     * @param $tipo
     * @param $ativo
     * @param $localizacao
     * @return \Illuminate\Http\JsonResponse
     */
    private function getFullDados($tipo, $ativo, $localizacao)
    {
        $pids = $iniciativas = [];

        $iniciativas = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
            ->select('iniciativas.idIniciativa as id', 'iniciativas.tipo_id', 'iniciativas.nome', 'iniciativas.sigla', 'iniciativas.email', 'iniciativas.url', 'iniciativas.objetivo', 'iniciativas.informacaoComplementar', 'iniciativas.categoria_id', 'iniciativas.fonte', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
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
                ->select('pids.idPid as id', 'pids.nome', 'pids.email', 'pids.url', 'pids.tipo_id', 'pids.destaque', 'pids.ativo', 'pids.updated_at', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->whereIn('pids.ativo', $ativo)
                ->whereIn('enderecos.localizacao_id', $localizacao)
                ->orderBy('uf.uf', 'asc')
                ->get();
        }

        return (['pids' => $pids, 'iniciativas' => $iniciativas]);
    }
}
