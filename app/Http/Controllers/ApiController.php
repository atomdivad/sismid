<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Instituicao;

class ApiController extends Controller
{
    /**
     * Retorna as cidades de uma UF
     *
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


        if($agrupamento == 'estado') {
            if($uf != 0) {
                if($cidade != '') {
                    $pids = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();

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
                    $pids = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->where('uf.idUf', '=', $uf)
                        ->groupby('uf.uf')
                        ->get();

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
                $pids = DB::table('pids')
                    ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->groupby('uf.uf')
                    ->get();

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
                    $pids = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();

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
                    $pids = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->where('uf.idUf', '=', $uf)
                        ->groupby('uf.uf')
                        ->get();

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
                $norte = DB::table('pids')
                    ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('idUf', [11, 12, 13, 14, 15, 16, 17])
                    ->get();

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

                $nordeste = DB::table('pids')
                    ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('idUf', [21, 22, 23, 24, 25, 26, 27, 28, 29])
                    ->get();

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

                $suldeste = DB::table('pids')
                    ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('idUf', [31, 32, 33, 35])
                    ->get();

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

                $sul = DB::table('pids')
                    ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('idUf', [41, 42, 43])
                    ->get();

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

                $centroeste = DB::table('pids')
                    ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                    ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->whereIn('idUf', [50, 51, 52, 53])
                    ->get();

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

            return [
                'pontos' => $estado,
                'contagem' => [
                    'norte' => $norteTotal,
                    'nordeste' => $nordesteTotal,
                    'sul' => $sulTotal,
                    'suldeste' => $suldesteTotal,
                    'centroeste' => $centroesteTotal,
            ]];
        }
        else {
            if($uf != 0) {
                if($cidade != '') {
                    //cidades
                    $pids = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('pids.idPid', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();
                }
                else {
                    //sem cidade
                    $pids = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('pids.idPid', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                        ->where('cidades.uf_id', '=', $uf)
                        ->orderBy('cidades.nomeCidade', 'asc')
                        ->get();
                }
            }
            else {
                //Sem parametros
                $pids = DB::table('pids')
                    ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('pids.idPid', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                    ->orderBy('uf.uf', 'asc')
                    ->get();
            }
        }

        return $pids;
    }
}
