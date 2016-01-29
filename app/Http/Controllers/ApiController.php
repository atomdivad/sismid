<?php

namespace SisMid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use SisMid\Models\Instituicao;
use SisMid\Models\Pid;
use SisMid\Models\Iniciativa;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    public function appMapa()
    {
        return DB::table('enderecos')
            ->select('idEndereco', 'latitude', 'longitude')
            ->where('latitude', '!=', '')
            ->where('longitude', '!=', '')
            ->take(5)->get();
    }

    public function getUf()
    {
        $uf = DB::table('uf')->select('uf', 'idUf')->orderBy('uf', 'asc')->get();
        return $uf;
    }

    /**
     * Retorna as cidades de uma UF
     * @param $idUf
     */
    public function getCidades($idUf)
    {
        $cidades = DB::table('cidades')
            ->where('uf_id', '=', $idUf)
            ->orderBy('nomeCidade')
            ->get();
        return $cidades;
    }

    /**
     * Retorna a lista de instituioes
     * @param Request $request
     * @return array
     */
    public function getInstituicoes(Request $request)
    {
        $nome = $request['nome'];
        $uf = $request['uf'];
        $cidade = $request['cidade_id'];

        //return [$nome, $uf, $cidade];
        $instituicoes = [];

        if($nome != '') {
            if($uf != 0) {
                if($cidade != 0) {
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('instituicoes.nome', 'like', "%$nome%")
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();
                }
                else {
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('instituicoes.nome', 'like', "%$nome%")
                        ->where('uf.idUf', '=', $uf)
                        ->get();
                }
            }
            else {
                $instituicoes = DB::table('instituicoes')
                    ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->where('instituicoes.nome', 'like', "%$nome%")
                    ->get();
            }
        }
        else {
            if($uf != 0) {
                if($cidade != 0) {
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();
                }
                else {
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('uf.idUf', '=', $uf)
                        ->get();
                }
            }
            else {
                $instituicoes = DB::table('instituicoes')
                    ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->get();
            }
        }

        return $instituicoes;
    }

    /**
     * Retorna a lista de iniciativas
     * @param Request $request
     * @return array
     */
    public function getIniciativas(Request $request)
    {
        $nome = $request['nome'];
        $uf = $request['uf'];
        $cidade = $request['cidade_id'];

        $iniciativas = [];

        if($nome != '') {
            if($uf != 0) {
                if($cidade != 0) {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('iniciativas.nome', 'like', "%$nome%")
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();
                }
                else {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('iniciativas.nome', 'like', "%$nome%")
                        ->where('uf.idUf', '=', $uf)
                        ->get();
                }
            }
            else {
                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->where('iniciativas.nome', 'like', "%$nome%")
                    ->get();
            }
        }
        else {
            if($uf != 0) {
                if($cidade != 0) {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();
                }
                else {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('uf.idUf', '=', $uf)
                        ->get();
                }
            }
            else {
                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->get();
            }
        }

        return $iniciativas;
    }

    /**
     * Retorna as info do mapa
     * @param Request $request
     * @return array
     */
    public function getMapa(Request $request)
    {
        $latlng = [
            "AC" => ["latitude" => "-9.031917", "longitude" => "-71.674805"],
            "AL" => ["latitude" => "-9.639000", "longitude" => "-35.793457"],
            "AM" => ["latitude" => "-3.141887", "longitude" => "-64.423828"],
            "AP" => ["latitude" => "2.480761", "longitude" => "-51.503906"],
            "BA" => ["latitude" => "-13.048710", "longitude" => "-42.011719"],
            "CE" => ["latitude" => "-5.435896", "longitude" => "-39.353027"],
            "DF" => ["latitude" => "-15.812157", "longitude" => "-47.878418"],
            "ES" => ["latitude" => "-19.347752", "longitude" => "-39.990234"],
            "GO" => ["latitude" => "-16.868948", "longitude" => "-50.888672"],
            "MA" => ["latitude" => "-4.807733", "longitude" => "-45.263672"],
            "MG" => ["latitude" => "-18.886148", "longitude" => "-44.912109"],
            "MS" => ["latitude" => "-20.293757", "longitude" => "-54.799805"],
            "MT" => ["latitude" => "-10.899391", "longitude" => "-55.722656"],
            "PA" => ["latitude" => "-3.756004", "longitude" => "-52.031250"],
            "PB" => ["latitude" => "-7.182991", "longitude" => "-34.914551"],
            "PE" => ["latitude" => "-8.744615", "longitude" => "-37.089844"],
            "PI" => ["latitude" => "-6.556839", "longitude" => "-41.748047"],
            "PR" => ["latitude" => "-24.987303", "longitude" => "-50.009766"],
            "RJ" => ["latitude" => "-22.773807", "longitude" => "-43.406982"],
            "RN" => ["latitude" => "-5.299511", "longitude" => "-36.562500"],
            "RO" => ["latitude" => "-9.948562", "longitude" => "-63.105469"],
            "RR" => ["latitude" => "2.831946", "longitude" => "-61.171875"],
            "RS" => ["latitude" => "-29.898996", "longitude" => "-52.470703"],
            "SC" => ["latitude" => "-27.040780", "longitude" => "-50.097656"],
            "SE" => ["latitude" => "-7.182991", "longitude" => "-34.914551"],
            "SP" => ["latitude" => "-23.473954", "longitude" => "-46.669922"],
            "TO" => ["latitude" => "-9.515434", "longitude" => "-48.251953"]
        ];

        $agrupamento = $request['agrupamento'];
        $uf = $request['uf'];
        $cidade = $request['cidade'];
        $tipo = $request['tipo'];
        $todos = [];


        if($agrupamento == 'estado') {
            if($uf != 0) {
                if($cidade != '') {
                    /* Busca agrupada por estado filtrando por cidade */
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->whereIn('iniciativas.tipo_id', $tipo)
                        ->where('cidades.idCidade', '=', $cidade);

                    if(in_array(0, $tipo)) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->where('cidades.idCidade', '=', $cidade)
                            ->where('pids.ativo', '=', 1)
                            ->union($iniciativas)
                            ->get();
                    }
                    else {
                        $pids =  $iniciativas->get();
                    }

                    foreach($pids as $pid) {
                        $pid->latitude = $latlng[$pid->uf]['latitude'];
                        $pid->longitude = $latlng[$pid->uf]['longitude'];
                    }
                    $estado = [];
                    foreach($pids as $pid) {
                        for($i = 0; $i < $pid->total; $i++) {
                            $estado[] = $pid;
                        }
                    }
                }
                else {
                    /* Busca agrupada por estado filtrando por UF */
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->where('uf.idUf', '=', $uf)
                        ->whereIn('iniciativas.tipo_id', $tipo)
                        ->groupby('uf.uf');

                    if(in_array(0, $tipo)) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->where('uf.idUf', '=', $uf)
                            ->where('pids.ativo', '=', 1)
                            ->groupby('uf.uf')
                            ->union($iniciativas)
                            ->get();
                    }
                    else {
                        $pids = $iniciativas->get();
                    }

                    foreach($pids as $pid) {
                        $pid->latitude = $latlng[$pid->uf]['latitude'];
                        $pid->longitude = $latlng[$pid->uf]['longitude'];
                    }
                    $estado = [];
                    foreach($pids as $pid) {
                        for($i = 0; $i < $pid->total; $i++) {
                            $estado[] = $pid;
                        }
                    }
                }
            }
            else {
                /* Busca agrupada por estado sem parametros de filtros*/
                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('iniciativas.tipo_id', $tipo)
                    ->groupby('uf.uf');

                if(in_array(0, $tipo)) {
                    $pids = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->where('pids.ativo', '=', 1)
                        ->groupby('uf.uf')
                        ->union($iniciativas)
                        ->get();
                }
                else {
                    $pids = $iniciativas->get();
                }

                foreach($pids as $pid) {
                    $pid->latitude = $latlng[$pid->uf]['latitude'];
                    $pid->longitude = $latlng[$pid->uf]['longitude'];
                }
                $estado = [];
                foreach($pids as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }
            }

            return $estado;
        }
        elseif($agrupamento == 'regiao') {
            $estado = [];
            if($uf != 0 ) {
                if($cidade != '') {
                    /*Busca agrupada por região - Cidade*/
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->whereIn('iniciativas.tipo_id', $tipo)
                        ->where('cidades.idCidade', '=', $cidade);

                    if(in_array(0, $tipo)){
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->where('cidades.idCidade', '=', $cidade)
                            ->where('pids.ativo', '=', 1)
                            ->union($iniciativas)
                            ->get();
                    }
                    else {
                        $pids  =  $iniciativas->get();
                    }

                    foreach($pids as $pid) {
                        $pid->latitude = $latlng[$pid->uf]['latitude'];
                        $pid->longitude = $latlng[$pid->uf]['longitude'];
                    }
                    $estado = [];
                    foreach($pids as $pid) {
                        for($i = 0; $i < $pid->total; $i++) {
                            $estado[] = $pid;
                        }
                    }
                }
                else {
                    /* Busca agrupada por região - UF sem parametro cidade*/
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->whereIn('iniciativas.tipo_id', $tipo)
                        ->where('uf.idUf', '=', $uf)
                        ->groupby('uf.uf');

                    if(in_array(0, $tipo)) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->where('uf.idUf', '=', $uf)
                            ->where('pids.ativo', '=', 1)
                            ->groupby('uf.uf')
                            ->union($iniciativas)
                            ->get();
                    }
                    else {
                        $pids = $iniciativas->get();
                    }

                    foreach($pids as $pid) {
                        $pid->latitude = $latlng[$pid->uf]['latitude'];
                        $pid->longitude = $latlng[$pid->uf]['longitude'];
                    }
                    $estado = [];
                    foreach($pids as $pid) {
                        for($i = 0; $i < $pid->total; $i++) {
                            $estado[] = $pid;
                        }
                    }
                }
            }
            else {
                /* Busca agrupada por região sem os paramentros UF e Cidade*/
                $norteIniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('iniciativas.tipo_id', $tipo)
                    ->whereIn('idUf', [11, 12, 13, 14, 15, 16, 17]);

                if(in_array(0, $tipo)) {
                    $norte = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->whereIn('idUf', [11, 12, 13, 14, 15, 16, 17])
                        ->where('pids.ativo', '=', 1)
                        ->union($norteIniciativas)
                        ->get();
                }
                else {
                    $norte = $norteIniciativas->get();
                }

                foreach($norte as $pid) {
                    $norteTotal = $pid->total;
                    $pid->latitude = $latlng['AM']['latitude'];
                    $pid->longitude = $latlng['AM']['longitude'];
                }
                foreach($norte as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }

                $nordesteIniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('iniciativas.tipo_id', $tipo)
                    ->whereIn('idUf', [21, 22, 23, 24, 25, 26, 27, 28, 29]);

                if(in_array(0, $tipo)) {
                    $nordeste = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->whereIn('idUf', [21, 22, 23, 24, 25, 26, 27, 28, 29])
                        ->where('pids.ativo', '=', 1)
                        ->union($nordesteIniciativas)
                        ->get();
                }
                else {
                    $nordeste = $nordesteIniciativas->get();
                }

                foreach($nordeste as $pid) {
                    $nordesteTotal = $pid->total;
                    $pid->latitude = $latlng['PI']['latitude'];
                    $pid->longitude = $latlng['PI']['longitude'];
                }
                foreach($nordeste as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }

                $suldesteIniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('iniciativas.tipo_id', $tipo)
                    ->whereIn('idUf', [31, 32, 33, 35]);

                if(in_array(0, $tipo)) {
                    $suldeste = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->whereIn('idUf', [31, 32, 33, 35])
                        ->where('pids.ativo', '=', 1)
                        ->union($suldesteIniciativas)
                        ->get();
                }
                else {
                    $suldeste = $suldesteIniciativas->get();
                }

                foreach($suldeste as $pid) {
                    $suldesteTotal = $pid->total;
                    $pid->latitude = $latlng['MG']['latitude'];
                    $pid->longitude = $latlng['MG']['longitude'];
                }
                foreach($suldeste as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }

                $sulIniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('iniciativas.tipo_id', $tipo)
                    ->whereIn('idUf', [41, 42, 43]);

                if(in_array(0, $tipo)) {
                    $sul = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->whereIn('idUf', [41, 42, 43])
                        ->where('pids.ativo', '=', 1)
                        ->union($sulIniciativas)
                        ->get();
                }
                else {
                    $sul = $sulIniciativas->get();
                }

                foreach($sul as $pid) {
                    $sulTotal = $pid->total;
                    $pid->latitude = $latlng['SC']['latitude'];
                    $pid->longitude = $latlng['SC']['longitude'];
                }
                foreach($sul as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }

                $centroesteIniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('iniciativas.tipo_id', $tipo)
                    ->whereIn('idUf', [50, 51, 52, 53]);

                if(in_array(0, $tipo)) {
                    $centroeste = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->whereIn('idUf', [50, 51, 52, 53])
                        ->where('pids.ativo', '=', 1)
                        ->union($centroesteIniciativas)
                        ->get();
                }
                else {
                    $centroeste = $centroesteIniciativas->get();
                }

                foreach($centroeste as $pid) {
                    $centroesteTotal = $pid->total;
                    $pid->latitude = $latlng['MT']['latitude'];
                    $pid->longitude = $latlng['MT']['longitude'];
                }
                foreach($centroeste as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }
            }

            return $estado;
        }
        else {
            $pids = [];
            if($uf != 0) {
                if($cidade != '') {
                    //cidades
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa as id', 'iniciativas.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                        ->where('cidades.idCidade', '=', $cidade)
                        ->whereIn('iniciativas.tipo_id', $tipo)
                        ->get();

                    if(in_array(0, $tipo)) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                            ->where('cidades.idCidade', '=', $cidade)
                            ->where('pids.ativo', '=', 1)
                            ->get();
                    }
                }
                else {
                    //sem cidade
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa as id', 'iniciativas.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                        ->where('cidades.uf_id', '=', $uf)
                        ->whereIn('iniciativas.tipo_id', $tipo)
                        ->orderBy('cidades.nomeCidade', 'asc')
                        ->get();

                    if(in_array(0, $tipo)) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                            ->where('cidades.uf_id', '=', $uf)
                            ->where('pids.ativo', '=', 1)
                            ->orderBy('cidades.nomeCidade', 'asc')
                            ->get();
                    }
                }
            }
            else {
                //Sem parametros
                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('iniciativas.idIniciativa as id', 'iniciativas.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                    ->whereIn('iniciativas.tipo_id', $tipo)
                    ->orderBy('uf.uf', 'asc')
                    ->get();

                if(in_array(0, $tipo))
                {
                    if(!Cache::has('pids')) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                            ->where('pids.ativo', '=', 1)
                            ->orderBy('uf.uf', 'asc')
                            ->get();

                        Cache::put('pids', $pids, 5);
                    }
                    $pids = Cache::get('pids');
                }
            }
        }
        return response()->json(['pids' => $pids, 'iniciativas' => $iniciativas]);
    }


    /**
     * Retorna uma imagem
     * @param $id
     * @param $nome
     * @return mixed
     */
    public function getFotos($id, $nome)
    {
        $pid = Pid::findOrFail($id);
        $foto = $pid->fotos()->where('nome', '=', $nome)->first();
        $img = Image::make($foto->arquivo);

        $img->resize(171, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $img->response();
    }

    /**
     * Retorna as informações de uma iniciativa
     * @param $id
     */
    public function getIniciativa($id = null)
    {
        if($id) {
            $iniciativa = Iniciativa::findOrFail($id);

            $instituicoes = [];
            foreach($iniciativa->instituicoes as $instituicao) {

                $cidade = DB::table('cidades')->select('nomeCidade', 'uf_id')->where('idCidade', '=', $instituicao->endereco->cidade_id)->first();
                $uf = DB::table('uf')->select('uf')->where('idUf', '=', $cidade->uf_id)->first();

                $instituicoes[] = array (
                    'idInstituicao' => $instituicao->idInstituicao,
                    'nome' => $instituicao->nome,
                    'nomeCidade' => $cidade->nomeCidade,
                    'uf' => $uf->uf,
                    'tipoVinculo' => ($instituicao->pivot->tipoVinculo == 1)? 'Apoiador' : 'Mantenendor'
                );
            }

            $dimensoes = [];
            $dm = DB::table('dimensoes')->select('dimensao', 'idDimensao')->lists('dimensao', 'idDimensao');
            foreach($iniciativa->dimensoes as $dimensao) {
                $dimensoes[] = $dm[$dimensao->idDimensao];
            }

            $servicos = [];
            $sv = DB::table('servicos')->select('servico', 'idServico')->lists('servico', 'idServico');
            foreach($iniciativa->servicos as $servico) {
                $servicos[] = $sv[$servico->idServico];
            }

            $cidade = DB::table('cidades')->select('nomeCidade', 'uf_id')->where('idCidade', '=', $iniciativa->endereco->cidade_id)->first();
            $uf = DB::table('uf')->select('uf')->where('idUf', '=', $cidade->uf_id)->first();
            $tipo = DB::table('iniciativaTipos')->select('tipo')->where('idTipo', '=', $iniciativa->tipo_id)->first();
            $localidade = DB::table('localidades')->select('localidade')->where('idLocalidade', '=', $iniciativa->endereco->localidade_id)->first();
            $localizacao = DB::table('localizacoes')->select('localizacao')->where('idLocalizacao', '=', $iniciativa->endereco->localizacao_id)->first();
            $naturezaJuridica = DB::table('naturezasJuridicas')->select('naturezaJuridica')->where('idNatureza', '=', $iniciativa->naturezaJuridica_id)->first();
            $categoria = DB::table('iniciativaCategorias')->select('categoria')->where('idCategoria', '=', $iniciativa->categoria_id)->first();

            return [
                'idIniciativa' =>  $iniciativa->idIniciativa,
                'tipo' => isset($tipo->tipo)? $tipo->tipo : null,
                'nome' => $iniciativa->nome,
                'sigla' => $iniciativa->sigla,
                'endereco' => [
                    'cep' => $iniciativa->endereco->cep,
                    'logradouro' => $iniciativa->endereco->logradouro,
                    'numero' => $iniciativa->endereco->numero,
                    'complemento' => $iniciativa->endereco->complemento,
                    'bairro' => $iniciativa->endereco->bairro,
                    'uf' => $uf->uf,
                    'cidade' => $cidade->nomeCidade,
                    'latitude' => $iniciativa->endereco->latitude,
                    'longitude' => $iniciativa->endereco->longitude,
                    'localidade' => isset($localidade->localidade)? $localidade->localidade : null,
                    'localizacao' => isset($localizacao->localizacao)? $localizacao->localizacao : null,
                ],
                'naturezaJuridica' => isset($naturezaJuridica->naturezaJuridica)? $naturezaJuridica->naturezaJuridica : null,
                'email' => $iniciativa->email,
                'url' => $iniciativa->url,
                'objetivo' => $iniciativa->objetivo,
                'informacaoComplementar' => $iniciativa->informacaoComplementar,
                'categoria' => isset($categoria->categoria)? $categoria->categoria : null,
                'fonte' => $iniciativa->fonte,
                'telefones' => $iniciativa->telefones,
                'instituicoes' => $instituicoes,
                'dimensoes' => $dimensoes,
                'servicos' => $servicos
            ];
        }
    }

    /**
     * @param null $id
     * @return array
     */
    public function getPid($id = null)
    {
        if($id) {
            $pid = Pid::findOrFail($id);

            $instituicoes = [];
            foreach($pid->instituicoes as $instituicao) {

                $cidade = DB::table('cidades')->select('nomeCidade', 'uf_id')->where('idCidade', '=', $instituicao->endereco->cidade_id)->first();
                $uf = DB::table('uf')->select('uf')->where('idUf', '=', $cidade->uf_id)->first();

                $instituicoes[] = array (
                    'idInstituicao' => $instituicao->idInstituicao,
                    'nome' => $instituicao->nome,
                    'nomeCidade' => $cidade->nomeCidade,
                    'uf' => $uf->uf,
                    'tipoVinculo' => $instituicao->pivot->tipoVinculo
                );
            }

            $iniciativas = [];
            foreach($pid->iniciativas as $iniciativa) {

                $cidade = DB::table('cidades')->select('nomeCidade', 'uf_id')->where('idCidade', '=', $iniciativa->endereco->cidade_id)->first();
                $uf = DB::table('uf')->select('uf')->where('idUf', '=', $cidade->uf_id)->first();

                $iniciativas[] = array (
                    'idIniciativa' => $iniciativa->idIniciativa,
                    'nome' => $iniciativa->nome,
                    'nomeCidade' => $cidade->nomeCidade,
                    'uf' => $uf->uf,
                );
            }

            $cidade = DB::table('cidades')->select('nomeCidade', 'uf_id')->where('idCidade', '=', $pid->endereco->cidade_id)->first();
            $uf = DB::table('uf')->select('uf')->where('idUf', '=', $cidade->uf_id)->first();
            $tipo = DB::table('pidTipos')->select('tipo')->where('idTipo', '=', $pid->tipo_id)->first();
            $localidade = DB::table('localidades')->select('localidade')->where('idLocalidade', '=', $pid->endereco->localidade_id)->first();
            $localizacao = DB::table('localizacoes')->select('localizacao')->where('idLocalizacao', '=', $pid->endereco->localizacao_id)->first();

            return [
                'idPid' => $pid->idPid,
                'nome' => $pid->nome,
                'email' => $pid->email,
                'url' => $pid->url,
                'tipo' => isset($tipo->tipo)? $tipo->tipo : null,
                'endereco' => [
                    'cep' => $pid->endereco->cep,
                    'logradouro' => $pid->endereco->logradouro,
                    'numero' => $pid->endereco->numero,
                    'complemento' => $pid->endereco->complemento,
                    'bairro' => $pid->endereco->bairro,
                    'uf' => $uf->uf,
                    'cidade' => $cidade->nomeCidade,
                    'latitude' => $pid->endereco->latitude,
                    'longitude' => $pid->endereco->longitude,
                    'localidade' => isset($localidade->localidade)? $localidade->localidade : null,
                    'localizacao' => isset($localizacao->localizacao)? $localizacao->localizacao : null,
                ],
                'telefones' => $pid->telefones,
                'instituicoes' => $instituicoes,
                'iniciativas' => $iniciativas,
                'fotos' => $pid->fotos
            ];
        }
    }

    /**
     * @param null $id
     * @return array
     */
    public function getInstituicao($id = null)
    {
        if($id) {
            $instituicao = Instituicao::findOrFail($id);

            $naturezaJuridica = DB::table('naturezasJuridicas')->select('naturezaJuridica')->where('idNatureza', '=', $instituicao->naturezaJuridica_id)->first();
            $cidade = DB::table('cidades')->select('nomeCidade', 'uf_id')->where('idCidade', '=', $instituicao->endereco->cidade_id)->first();
            $uf = DB::table('uf')->select('uf')->where('idUf', '=', $cidade->uf_id)->first();
            $localidade = DB::table('localidades')->select('localidade')->where('idLocalidade', '=', $instituicao->endereco->localidade_id)->first();
            $localizacao = DB::table('localizacoes')->select('localizacao')->where('idLocalizacao', '=', $instituicao->endereco->localizacao_id)->first();

            return  [
                'idInstituicao' => $instituicao->idInstituicao,
                'nome' => $instituicao->nome,
                'email' => $instituicao->email,
                'url' => $instituicao->url,
                'naturezaJuridica' => isset($naturezaJuridica->naturezaJuridica)? $naturezaJuridica->naturezaJuridica : null,
                'endereco' => [
                    'cep' => $instituicao->endereco->cep,
                    'logradouro' => $instituicao->endereco->logradouro,
                    'numero' => $instituicao->endereco->numero,
                    'complemento' => $instituicao->endereco->complemento,
                    'bairro' => $instituicao->endereco->bairro,
                    'uf' => $uf->uf,
                    'cidade' => $cidade->nomeCidade,
                    'latitude' => $instituicao->endereco->latitude,
                    'longitude' => $instituicao->endereco->longitude,
                    'localidade' => isset($localidade->localidade)? $localidade->localidade : null,
                    'localizacao' => isset($localizacao->localizacao)? $localizacao->localizacao : null,
                ],
                'telefones' => $instituicao->telefones
            ];
        }
    }

    public function feedback(Request $request)
    {
        $msg = "Nome: $request[nome]\nEmail: $request[email]\nMensagem:\n$request[msg]";
        Mail::raw($msg, function($message)
        {
            $message->to('mapinguarisoftware@gmail.com');
            $message->subject("Feedback SisMid " . Carbon::now()->format('d/m/Y'));
        });
        return;
    }


}
