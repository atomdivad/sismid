<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Endereco;
use SisMid\Models\Pid;
use SisMid\Models\Telefone;

class PidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pids = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
            ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
            ->get();

        return view('pids.index', compact('pids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $localidades = DB::table('localidades')->orderBy('localidade')->lists('localidade','idLocalidade');
        $localizacoes = DB::table('localizacoes')->orderBy('localizacao')->lists('localizacao','idLocalizacao');
        $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $pidTipos = DB::table('pidTipos')->orderBy('tipo')->lists('tipo', 'idTipo');

        return view('pids.create', compact('uf','localidades','localizacoes', 'telefoneTipos','pidTipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required|min:5',
            'email' => 'required|email',
            'url' => 'url',
            'tipo_id' => 'exists:pidTipos,idTipo',
            'endereco.logradouro' => 'required|min:3|max:150',
            'endereco.bairro' => 'required|min:3|max:150',
            'endereco.uf' => 'required',
            'endereco.cidade_id' => 'required|exists:cidades,idCidade',
            'endereco.latitude' => 'numeric',
            'endereco.longitude' => 'numeric',
            'endereco.localidade_id'=> 'exists:localidades,idLocalidade',
            'endereco.localizacao_id'=> 'exists:localizacoes,idLocalizacao',
        ]);

        $endereco = Endereco::create($request['endereco']);
        $pid = $endereco->pid()->create($request->all());

        foreach($request['telefones'] as $telefone) {
            $pid->telefones()->create($telefone);
        }

        $instituicoes = [];
        foreach($request['instituicoes'] as $instituicao) {
            $instituicoes[] = $instituicao['idInstituicao'];
        }
        $pid->instituicoes()->sync($instituicoes);

        $iniciativas = [];
        foreach($request['iniciativas'] as $iniciativa) {
            $iniciativas[] = $iniciativa['idIniciativa'];
        }
        $pid->iniciativas()->sync($iniciativas);

        return $this->show($pid->idPid);
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
                    'uf' => 51, /*ADICIONAR A UF*/
                    'cidade_id' => $pid->endereco->cidade_id,
                    'latitude' => $pid->endereco->latitude,
                    'longitude' => $pid->endereco->longitude,
                    'localidade_id' => $pid->endereco->localidade_id,
                    'localizacao_id' => $pid->endereco->localizacao_id
                ],
                'telefones' => $pid->telefones,
                'instituicoes' => $instituicoes,
                'iniciativas' => $iniciativas
            ];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $localidades = DB::table('localidades')->orderBy('localidade')->lists('localidade','idLocalidade');
        $localizacoes = DB::table('localizacoes')->orderBy('localizacao')->lists('localizacao','idLocalizacao');
        $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $pidTipos = DB::table('pidTipos')->orderBy('tipo')->lists('tipo', 'idTipo');

        return view('pids.edit', compact('uf','localidades','localizacoes', 'telefoneTipos','pidTipos'));
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
        $this->validate($request, [
            'nome' => 'required|min:5',
            'email' => 'required|email',
            'url' => 'url',
            'tipo_id' => 'exists:pidTipos,idTipo',
            'endereco.logradouro' => 'required|min:3|max:150',
            'endereco.bairro' => 'required|min:3|max:150',
            'endereco.uf' => 'required',
            'endereco.cidade_id' => 'required|exists:cidades,idCidade',
            'endereco.latitude' => 'numeric',
            'endereco.longitude' => 'numeric',
            'endereco.localidade_id'=> 'exists:localidades,idLocalidade',
            'endereco.localizacao_id'=> 'exists:localizacoes,idLocalizacao',
        ]);

        $pid = Pid::findOrFail($request['idPid']);

        $pid->endereco()->update($request['endereco']);
        $pid->update($request->all());

        $telefones = [];
        foreach($request['telefones'] as $telefone) {
            if($telefone['idTelefone'] == null) {
                $tel = $pid->telefones()->create($telefone);
                $telefones[] = $tel->idTelefone;
            }
            else {
                $tel = Telefone::find($telefone['idTelefone']);
                $tel->update($telefone);
                $telefones[] = $tel->idTelefone;
            }
        }
        $pid->telefones()->sync($telefones);

        $instituicoes = [];
        foreach($request['instituicoes'] as $instituicao) {
            $instituicoes[] = $instituicao['idInstituicao'];
        }
        $pid->instituicoes()->sync($instituicoes);

        $iniciativas = [];
        foreach($request['iniciativas'] as $iniciativa) {
            $iniciativas[] = $iniciativa['idIniciativa'];
        }
        $pid->iniciativas()->sync($iniciativas);

        return $this->show($pid->idPid);
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
