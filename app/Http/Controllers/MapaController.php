<?php

namespace SisMid\Http\Controllers;

use Artesaos\Defender\Facades\Defender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Pid;

class MapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        return view("mapa.index", compact('uf'));
    }

    public function iframe()
    {
        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        return view("mapa.iframe", compact('uf'));
    }
    /**
     * Retorna as info do mapa
     * @param Request $request
     * @return array
     */
    public function getMapa(Request $request)
    {
        /****
         * Variavel com um ponto de lat/lng em cada estado
        */
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
        /****
         * Usuarios que podem ver pid+iniciativas, outros usuarios veem somente pid
        */
        $usuarios = ['gestor','admin'];
        /****
         * Parametros da busca
         */
        $agrupamento = $request['agrupamento'];
        $uf = $request['uf'];
        $cidade = $request['cidade'];
        $tipo = $request['tipo'];

        if($agrupamento == 'estado') {
            if($uf != 0) {
                if($cidade != '') {
                    /* Busca agrupada por estado filtrando por cidade */
                    $pids = $this->getDadosAgrupadosByCidade($tipo, $cidade, [1], $usuarios, 1);
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
                    $pids = $this->getDadosAgrupados($tipo, [$uf], [1], $usuarios, 1);
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
                $pids = $this->getDadosAgrupados($tipo, [11, 12, 13, 14, 15, 16, 17, 21, 22, 23, 24, 25, 26, 27, 28, 29, 31, 32, 33, 35, 41, 42, 43, 50, 51, 52, 53], [1], $usuarios, 1);
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
                    $pids = $this->getDadosAgrupadosByCidade($tipo, $cidade, [1], $usuarios, 0);
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
                    $pids = $this->getDadosAgrupados($tipo, [$uf], [1], $usuarios, 0);
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

                $norte = $this->getDadosAgrupados($tipo, [11, 12, 13, 14, 15, 16, 17], [1], $usuarios, 0);
                foreach($norte as $pid) {
                    $pid->latitude = $latlng['AM']['latitude'];
                    $pid->longitude = $latlng['AM']['longitude'];
                }
                foreach($norte as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }

                $nordeste = $this->getDadosAgrupados($tipo, [21, 22, 23, 24, 25, 26, 27, 28, 29], [1], $usuarios, 0);
                foreach($nordeste as $pid) {
                    $pid->latitude = $latlng['PI']['latitude'];
                    $pid->longitude = $latlng['PI']['longitude'];
                }
                foreach($nordeste as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }

                $suldeste = $this->getDadosAgrupados($tipo, [31, 32, 33, 35], [1], $usuarios, 0);
                foreach($suldeste as $pid) {
                    $pid->latitude = $latlng['MG']['latitude'];
                    $pid->longitude = $latlng['MG']['longitude'];
                }
                foreach($suldeste as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }

                $sul = $this->getDadosAgrupados($tipo, [41, 42, 43], [1], $usuarios, 0);
                foreach($sul as $pid) {
                    $pid->latitude = $latlng['SC']['latitude'];
                    $pid->longitude = $latlng['SC']['longitude'];
                }
                foreach($sul as $pid) {
                    for($i = 0; $i < $pid->total; $i++) {
                        $estado[] = $pid;
                    }
                }

                $centroeste = $this->getDadosAgrupados($tipo, [50, 51, 52, 53], [1], $usuarios, 0);
                foreach($centroeste as $pid) {
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
            if($uf != 0) {
                if($cidade != '') {
                    /*busca pid/iniciativa de uma cidade*/
                    return $this->getDadosByCidade($cidade, $tipo, [1], $usuarios);
                }
                else {
                    /*busca pid/iniciativa de um estado*/
                    return $this->getDadosByUf([$uf], $tipo, [1], $usuarios);
                }
            }
            else {
                /*busca todos os pid/iniciativa*/
                return $this->getDados($tipo, [1], $usuarios);
            }
        }
    }

    /**
     * @param $tipo
     * @param $ativo
     * @param $localizacao
     * @return \Illuminate\Http\JsonResponse
     */
    private function getDados($tipo, $ativo, $usuarios)
    {
        $pids = $iniciativas = [];

        if(Defender::is($usuarios)) {
            $iniciativas = DB::table('iniciativas')
                ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('iniciativas.idIniciativa as id', 'iniciativas.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->whereIn('iniciativas.tipo_id', $tipo)
                ->orderBy('uf.uf', 'asc')
                ->get();
        }

        if(in_array(0, $tipo))
        {
            $pids = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid as id', 'pids.nome', 'pids.ativo', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->whereIn('pids.ativo', $ativo)
                ->orderBy('uf.uf', 'asc')
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
    private function getDadosByUf($uf, $tipo, $ativo, $usuarios)
    {
        $pids = $iniciativas = [];

        if(Defender::is($usuarios)) {
            $iniciativas = DB::table('iniciativas')
                ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('iniciativas.idIniciativa as id', 'iniciativas.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->whereIn('cidades.uf_id', $uf)
                ->whereIn('iniciativas.tipo_id', $tipo)
                ->orderBy('cidades.nomeCidade', 'asc')
                ->get();
        }

        if(in_array(0, $tipo)) {
            $pids = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->whereIn('cidades.uf_id', $uf)
                ->whereIn('pids.ativo', $ativo)
                ->orderBy('cidades.nomeCidade', 'asc')
                ->get();
        }
        return response()->json(['pids' => $pids, 'iniciativas' => $iniciativas]);
    }

    /**
     * @param $idCidade
     * @param $tipo
     * @param $ativo
     * @param $localizacao
     * @return \Illuminate\Http\JsonResponse
     */
    private function getDadosByCidade($idCidade, $tipo, $ativo, $usuarios)
    {
        $pids = $iniciativas = [];

        if(Defender::is($usuarios)) {
            $iniciativas = DB::table('iniciativas')
                ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('iniciativas.idIniciativa as id', 'iniciativas.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->where('cidades.idCidade', '=', $idCidade)
                ->whereIn('iniciativas.tipo_id', $tipo)
                ->get();
        }

        if(in_array(0, $tipo)) {
            $pids = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                ->where('cidades.idCidade', '=', $idCidade)
                ->whereIn('pids.ativo', $ativo)
                ->get();
        }

        return response()->json(['pids' => $pids, 'iniciativas' => $iniciativas]);

    }

    private function getDadosAgrupados($tipo, $uf, $ativo, $usuarios, $agrupado)
    {
        /* Busca agrupada por região sem os paramentros UF e Cidade*/
        $iniciativas = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
            ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
            ->whereIn('iniciativas.tipo_id', $tipo)
            ->whereIn('idUf', $uf);

        if(in_array(0, $tipo)) {
            $pids = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->select('uf.uf', 'uf.idUf', DB::raw('COUNT( uf.uf ) as total'))
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->whereIn('idUf', $uf)
                ->whereIn('pids.ativo', $ativo);

            if(Defender::is($usuarios)) {
                $pids->union($iniciativas);
            }

            if($agrupado)
                return $pids->groupby('uf.uf')->get();
            else
                return $pids->get();
        }
        else {
            return $iniciativas->get();
        }
    }

    private function getDadosAgrupadosByCidade($tipo, $cidade, $ativo, $usuarios, $agrupado)
    {
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
                ->where('pids.ativo', '=', $ativo);

            if(Defender::is($usuarios)) {
                $pids->union($iniciativas);
            }

            if($agrupado)
                return $pids->groupby('uf.uf')->get();
            else
                return $pids->get();
        }
        else {
            return  $iniciativas->get();
        }
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
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

            $cidade = DB::table('cidades')->select('nomeCidade','uf_id')->where('idCidade', '=', $pid->endereco->cidade_id)->first();
            $uf = DB::table('uf')->select('uf')->where('idUf', '=', $cidade->uf_id)->first();

            return [
                'idPid' => $pid->idPid,
                'nome' => $pid->nome,
                'email' => $pid->email,
                'url' => $pid->url,
                'tipo_id' => $pid->tipo_id,
                'endereco' => [
                    'cep' => $pid->endereco->cep,
                    'logradouro' => $pid->endereco->logradouro,
                    'numero' => $pid->endereco->numero,
                    'complemento' => $pid->endereco->complemento,
                    'bairro' => $pid->endereco->bairro,
                    'uf' => $uf->uf,
                    'cidade_id' => $cidade->nomeCidade,
                    'latitude' => $pid->endereco->latitude,
                    'longitude' => $pid->endereco->longitude,
                    'localidade_id' => $pid->endereco->localidade_id,
                    'localizacao_id' => $pid->endereco->localizacao_id
                ],
                'telefones' => $pid->telefones,
                'instituicoes' => $instituicoes,
                'iniciativas' => $iniciativas,
                'fotos' => $pid->fotos
            ];
        }
    }
}
