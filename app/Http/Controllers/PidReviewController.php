<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;

use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SisMid\Models\Pid;
use SisMid\Models\Endereco;
use SisMid\Models\Iniciativa;
use SisMid\Models\Servico;
use SisMid\Models\Telefone;
use SisMid\Models\Foto;
use Intervention\Image\Facades\Image;

class PidReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
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

            $servicos = [];
            foreach($pid->servicos as $servico) {
                $servicos[] = $servico->idServico;
            }

            $cidade = DB::table('cidades')->select('uf_id', 'nomeCidade')->where('idCidade', '=', $pid->endereco->cidade_id)->first();
            $uf = DB::table('uf')->select('idUf', 'uf')->where('idUf', '=', $cidade->uf_id)->first();

            return [
                'idPid' => $pid->idPid,
                'nome' => $pid->nome,
                'email' => $pid->email,
                'url' => $pid->url,
                'tipo_id' => $pid->tipo_id,
                'tipo' => DB::table('pidTipos')->select('tipo')->where('idTipo', '=', $pid->tipo_id)->first()->tipo,
                'endereco' => [
                    'cep' => $pid->endereco->cep,
                    'logradouro' => $pid->endereco->logradouro,
                    'numero' => $pid->endereco->numero,
                    'complemento' => $pid->endereco->complemento,
                    'bairro' => $pid->endereco->bairro,
                    'idUf' => $uf->idUf,
                    'uf' => $uf->uf,
                    'cidade_id' => $pid->endereco->cidade_id,
                    'cidade' => $cidade->nomeCidade,
                    'latitude' => $pid->endereco->latitude,
                    'longitude' => $pid->endereco->longitude,
                    'localidade_id' => $pid->endereco->localidade_id,
                    'localidade' => ($pid->endereco->localidade_id)? DB::table('localidades')->select('localidade')->where('idLocalidade', '=', $pid->endereco->localidade_id)->first()->localidade : null,
                    'localizacao_id' => $pid->endereco->localizacao_id,
                    'localizacao' => ($pid->endereco->localizacao_id)? DB::table('localizacoes')->select('localizacao')->where('idLocalizacao', '=', $pid->endereco->localizacao_id)->first()->localizacao : null
                ],
                'telefones' => $pid->telefones,
                'instituicoes' => $instituicoes,
                'iniciativas' => $iniciativas,
                'servicos' => $servicos,
                'fotos' => $pid->fotos,
                'updated_at' => $pid->updated_at,
                'destaque' => boolval($pid->destaque)
            ];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $localidades = DB::table('localidades')->orderBy('localidade')->lists('localidade','idLocalidade');
        $localizacoes = DB::table('localizacoes')->orderBy('localizacao')->lists('localizacao','idLocalizacao');
        $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $pidTipos = DB::table('pidTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $servicos = Servico::all()->lists('servico', 'idServico');

        return view('revisao.pids.edit', compact('uf','localidades','localizacoes', 'telefoneTipos','pidTipos', 'servicos', 'json'));
    }

    public function confirm($id)
    {
        $json =  json_decode(file_get_contents(storage_path().'/revisao/pid_'.$id.'.json'), true);

        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $localidades = DB::table('localidades')->orderBy('localidade')->lists('localidade','idLocalidade');
        $localizacoes = DB::table('localizacoes')->orderBy('localizacao')->lists('localizacao','idLocalizacao');
        $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $pidTipos = DB::table('pidTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $servicos = Servico::all()->lists('servico', 'idServico');

        return view('revisao.pids.review', compact('uf','localidades','localizacoes', 'telefoneTipos','pidTipos', 'servicos', 'json'));
    }

    public function review($id = null)
    {
        if($id)
            return json_decode(file_get_contents(storage_path().'/revisao/pid_'.$id.'.json'), true);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        file_put_contents(storage_path().'/revisao/pid_'.$request['idPid'].'.json', json_encode($request->all()));
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
