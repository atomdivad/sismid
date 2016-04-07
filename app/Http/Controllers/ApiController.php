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

class ApiController extends Controller
{
    /**
     * Retorna os dados para App Mobile
     * @route /api/app/mapa in routes.php
     * @param Request $request
     * @return mixed
     */
    public function appMapa(Request $request)
    {
        $lat_u = $request['latitude'];//-15.8193228;
        $lng_u = $request['longitude'];//-47.897423600000025;
        $raio = $request['distancia'] + 0.0;//1.0;
        if($request['uf'] == '0') {
            if(strlen($request['nome']) > 0) {
                $dados = DB::table('pids')
                    ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                    ->where('pids.ativo', '=', 1)
                    ->where('pids.nome', 'like', '%'.$request['nome'].'%')
                    ->whereRaw('enderecos.latitude between min_lat('.$lat_u.', '.$raio.') and max_lat('.$lat_u.', '.$raio.')
                            and enderecos.longitude between min_lng('.$lat_u.', '.$lng_u.', '.$raio.') and max_lng('.$lat_u.', '.$lng_u.', '.$raio.')
                            and distance_between(enderecos.latitude, enderecos.longitude, '.$lat_u.', '.$lng_u.') <= '.$raio)
                    ->get();
                return ['dados' => $dados];
            }
            else {
                $dados = DB::table('pids')
                    ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                    ->where('pids.ativo', '=', 1)
                    ->whereRaw('enderecos.latitude between min_lat('.$lat_u.', '.$raio.') and max_lat('.$lat_u.', '.$raio.')
                            and enderecos.longitude between min_lng('.$lat_u.', '.$lng_u.', '.$raio.') and max_lng('.$lat_u.', '.$lng_u.', '.$raio.')
                            and distance_between(enderecos.latitude, enderecos.longitude, '.$lat_u.', '.$lng_u.') <= '.$raio)
                    ->get();
                return ['dados' => $dados];
            }
        }
        else {
            if($request['cidade']) {
                if(strlen($request['nome']) > 0) {
                    $dados = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                        ->where('pids.ativo', '=', 1)
                        ->where('enderecos.cidade_id', '=', $request['cidade'])
                        ->where('pids.nome', 'like', '%'.$request['nome'].'%')
                        ->get();
                    return ['dados' => $dados, 'uf' => DB::table('uf')->where('idUf', '=', $request['uf'])->first()->uf];
                }
                else {
                    $dados = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                        ->where('pids.ativo', '=', 1)
                        ->where('enderecos.cidade_id', '=', $request['cidade'])
                        ->get();
                    return ['dados' => $dados, 'uf' => DB::table('uf')->where('idUf', '=', $request['uf'])->first()->uf];
                }
            }
            else {
                if(strlen($request['nome']) > 0) {
                    $dados = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                        ->where('pids.ativo', '=', 1)
                        ->where('cidades.uf_id', '=', $request['uf'])
                        ->where('pids.nome', 'like', '%'.$request['nome'].'%')
                        ->get();
                    return ['dados' => $dados, 'uf' => DB::table('uf')->where('idUf', '=', $request['uf'])->first()->uf];
                }
                else {
                    $dados = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('pids.idPid as id', 'pids.nome', 'cidades.nomeCidade', 'uf.uf', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.latitude', 'enderecos.longitude')
                        ->where('pids.ativo', '=', 1)
                        ->where('cidades.uf_id', '=', $request['uf'])
                        ->get();
                    return ['dados' => $dados, 'uf' => DB::table('uf')->where('idUf', '=', $request['uf'])->first()->uf];
                }
            }
        }
    }


    /**
     * Retorna a Lista de UF, está sendo usada p/ alimentar a app mobile
     * @return mixed
     */
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
        /*uf pode ser passado como numerico ou string, exemplo: 53 ou DF*/
        $uf = 0;
        if(isset($request['uf']))
            (!is_numeric($request['uf'])) ? $uf = DB::table('uf')->select('idUf')->where('uf', 'like', $request['uf'])->first()->idUf : $uf = $request['uf'];
        isset($request['cidade_id']) ? $cidade = $request['cidade_id'] : $cidade = 0;


        //return [$nome, $uf, $cidade];
        $instituicoes = [];

        if($nome != '') {
            if($uf > 0 && $cidade == 0) {

                $instituicoes = DB::table('instituicoes')
                    ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->where('instituicoes.nome', 'like', "%$nome%")
                    ->where('uf.idUf', '=', $uf)
                    ->get();
            }
            elseif($cidade > 0) {
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
                    ->get();
            }
        }
        else {
            if($uf > 0 && $cidade == 0) {
                $instituicoes = DB::table('instituicoes')
                    ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->where('uf.idUf', '=', $uf)
                    ->get();
            }
            elseif($cidade > 0) {
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
                    ->get();
            }
        }

        return $instituicoes;
    }

    /**
     * Retorna as informações de uma instituicao
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


    /**
     * Retorna informacoes basicas de todos os pids geral,uf ou cidade
     * @param Request $request => [uf, cidade]
     * @return mixed
     */
    public function getPids(Request $request)
    {
        $uf = 0;
        if(isset($request['uf']))
            (!is_numeric($request['uf'])) ? $uf = DB::table('uf')->select('idUf')->where('uf', 'like', $request[ 'uf'])->first()->idUf : $uf = $request[ 'uf'];

        isset($request['cidade']) ? $cidade = $request['cidade'] : $cidade = 0;

        if($uf > 0 && $cidade == 0) {
            $dados = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid', 'pids.nome', 'cidades.nomeCidade', 'uf.uf')
                ->where('pids.ativo', '=', 1)
                ->where('cidades.uf_id', '=', $uf)
                ->orderBy('pids.nome', 'asc')
                ->get();
            return $dados;
        }
        elseif($cidade > 0) {
            $dados = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid', 'pids.nome', 'cidades.nomeCidade', 'uf.uf')
                ->where('pids.ativo', '=', 1)
                ->where('enderecos.cidade_id', '=', $cidade)
                ->orderBy('pids.nome', 'asc')
                ->get();
            return $dados;
        }
        else {
            $dados = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid', 'pids.nome', 'cidades.nomeCidade', 'uf.uf')
                ->where('pids.ativo', '=', 1)
                ->orderBy('pids.nome', 'asc')
                ->get();
            return $dados;
        }
    }

    /**
     * Retorna as informações de um pid
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

            $servicos = [];
            $sv = DB::table('servicos')->select('servico', 'idServico')->lists('servico', 'idServico');
            foreach($pid->servicos as $servico) {
                $servicos[] = $sv[$servico->idServico];
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
                'servicos' => $servicos,
                'fotos' => $pid->fotos,
                'updated_at' => $pid->updated_at->format('d/m/Y'),
                'destaque' => $pid->destaque,
                'ativo' => $pid->ativo
            ];
        }
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
     * Retorna a lista de iniciativas
     * @param Request $request | nome, uf, cidade
     * @return array
     */
    public function getIniciativas(Request $request)
    {
        $nome = $request['nome'];
        /*uf pode ser passado como numerico ou string, exemplo: 53 ou DF*/
        $uf = 0;
        if(isset($request['uf']))
            (!is_numeric($request['uf'])) ? $uf = DB::table('uf')->select('idUf')->where('uf', 'like', $request['uf'])->first()->idUf : $uf = $request['uf'];
        isset($request['cidade_id']) ? $cidade = $request['cidade_id'] : $cidade = 0;

        $iniciativas = [];

        if($nome != '') {
            if($uf > 0 && $cidade == 0) {
                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->where('iniciativas.nome', 'like', "%$nome%")
                    ->where('uf.idUf', '=', $uf)
                    ->get();
            }
            elseif($cidade > 0) {
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
                    ->get();
            }
        }
        else {
            if($uf > 0 && $cidade == 0) {

                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->where('uf.idUf', '=', $uf)
                    ->get();
            }
            elseif($cidade > 0) {
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
                    ->get();
            }
        }

        return $iniciativas;
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
                'email' => $iniciativa->email,
                'url' => $iniciativa->url,
                'objetivo' => $iniciativa->objetivo,
                'informacaoComplementar' => $iniciativa->informacaoComplementar,
                'categoria' => isset($categoria->categoria)? $categoria->categoria : null,
                'fonte' => $iniciativa->fonte,
                'telefones' => $iniciativa->telefones,
                'instituicoes' => $instituicoes,
                'dimensoes' => $dimensoes
            ];
        }
    }

    /**
     * Retorna os pids de uma iniciativa
     * @param null $id
     */
    public function getIniciativaPid($id = null)
    {
        if($id != null) {
            $dados = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                ->select('pids.idPid', 'pids.nome', 'cidades.nomeCidade', 'uf.uf')
                ->where('pids.ativo', '=', 1)
                ->where('pid_iniciativas.iniciativa_id', '=', $id)
                ->orderBy('pids.nome', 'asc')
                ->get();
            return $dados;
        }
        abort(400);
    }
}
