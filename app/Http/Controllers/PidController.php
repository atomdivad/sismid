<?php

namespace SisMid\Http\Controllers;

use Artesaos\Defender\Facades\Defender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use SisMid\Models\Endereco;
use SisMid\Models\Iniciativa;
use SisMid\Models\Pid;
use SisMid\Models\Servico;
use SisMid\Models\Telefone;
use SisMid\Models\Foto;


class PidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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


        if(strlen($request['nome']) > 0 ) {
            if($request['uf'] != 0) {
                if($request['cidade_id'] != 0) {
                    //cidade + nome
                    if(Defender::hasRole('gestor')) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                            ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                            ->where('pids.nome', 'like', "%$request[nome]%")
                            ->where('cidades.idCidade', '=', $request['cidade_id'])
                            ->where('pid_iniciativas.iniciativa_id', '=', Auth::user()->iniciativa_id)
                            ->whereIn('pids.ativo', $ativo)
                            ->orderBy('pids.nome', 'asc')
                            ->paginate(10);
                    }
                    else {
                        if($request['iniciativa'][0] != 0) {
                            $pids = DB::table('pids')
                                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                                ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                                ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                                ->whereIn('pid_iniciativas.iniciativa_id', $request['iniciativa'])
                                ->where('pids.nome', 'like', "%$request[nome]%")
                                ->where('cidades.idCidade', '=', $request['cidade_id'])
                                ->whereIn('pids.ativo', $ativo)
                                ->orderBy('pids.nome', 'asc')
                                ->paginate(10);
                        }
                        else {
                            $pids = DB::table('pids')
                                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                                ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                                ->where('pids.nome', 'like', "%$request[nome]%")
                                ->where('cidades.idCidade', '=', $request['cidade_id'])
                                ->whereIn('pids.ativo', $ativo)
                                ->orderBy('pids.nome', 'asc')
                                ->paginate(10);
                        }
                    }
                }
                else {
                    //uf + nome
                    if(Defender::hasRole('gestor')) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                            ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                            ->where('pid_iniciativas.iniciativa_id', '=', Auth::user()->iniciativa_id)
                            ->where('pids.nome', 'like', "%$request[nome]%")
                            ->where('uf.idUf', '=', $request['uf'])
                            ->whereIn('pids.ativo', $ativo)
                            ->orderBy('pids.nome', 'asc')
                            ->paginate(10);
                    }
                    else {
                        if($request['iniciativa'][0] != 0) {
                            $pids = DB::table('pids')
                                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                                ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                                ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                                ->whereIn('pid_iniciativas.iniciativa_id', $request['iniciativa'])
                                ->where('pids.nome', 'like', "%$request[nome]%")
                                ->where('uf.idUf', '=', $request['uf'])
                                ->whereIn('pids.ativo', $ativo)
                                ->orderBy('pids.nome', 'asc')
                                ->paginate(10);
                        }
                        else {
                            $pids = DB::table('pids')
                                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                                ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                                ->where('pids.nome', 'like', "%$request[nome]%")
                                ->where('uf.idUf', '=', $request['uf'])
                                ->whereIn('pids.ativo', $ativo)
                                ->orderBy('pids.nome', 'asc')
                                ->paginate(10);
                        }
                    }
                }
            }
            else {
                //nome
                if(Defender::hasRole('gestor')) {
                    $pids = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                        ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('pid_iniciativas.iniciativa_id', '=', Auth::user()->iniciativa_id)
                        ->where('pids.nome', 'like', "%$request[nome]%")
                        ->whereIn('pids.ativo', $ativo)
                        ->orderBy('pids.nome', 'asc')
                        ->paginate(10);
                }
                else {
                    if($request['iniciativa'][0] != 0) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                            ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                            ->whereIn('pid_iniciativas.iniciativa_id', $request['iniciativa'])
                            ->where('pids.nome', 'like', "%$request[nome]%")
                            ->whereIn('pids.ativo', $ativo)
                            ->orderBy('pids.nome', 'asc')
                            ->paginate(10);
                    }
                    else {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                            ->where('pids.nome', 'like', "%$request[nome]%")
                            ->whereIn('pids.ativo', $ativo)
                            ->orderBy('pids.nome', 'asc')
                            ->paginate(10);
                    }
                }
            }

        }
        else {
            if($request['uf'] != 0) {
                if($request['cidade_id'] != 0) {
                    //cidade
                    if(Defender::hasRole('gestor')){
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                            ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                            ->where('pid_iniciativas.iniciativa_id', '=', Auth::user()->iniciativa_id)
                            ->where('cidades.idCidade', '=', $request['cidade_id'])
                            ->whereIn('pids.ativo', $ativo)
                            ->orderBy('pids.nome', 'asc')
                            ->paginate(10);
                    }
                    else {
                        if($request['iniciativa'][0] != 0) {
                            $pids = DB::table('pids')
                                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                                ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                                ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                                ->whereIn('pid_iniciativas.iniciativa_id', $request['iniciativa'])
                                ->where('cidades.idCidade', '=', $request['cidade_id'])
                                ->whereIn('pids.ativo', $ativo)
                                ->orderBy('pids.nome', 'asc')
                                ->paginate(10);
                        }
                        else {
                            $pids = DB::table('pids')
                                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                                ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                                ->where('cidades.idCidade', '=', $request['cidade_id'])
                                ->whereIn('pids.ativo', $ativo)
                                ->orderBy('pids.nome', 'asc')
                                ->paginate(10);
                        }
                    }
                }
                else {
                    //uf
                    if(Defender::hasRole('gestor')) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                            ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                            ->where('pid_iniciativas.iniciativa_id', '=', Auth::user()->iniciativa_id)
                            ->where('uf.idUf', '=', $request['uf'])
                            ->whereIn('pids.ativo', $ativo)
                            ->orderBy('pids.nome', 'asc')
                            ->paginate(10);
                    }
                    else {
                        if($request['iniciativa'][0] != 0) {
                            $pids = DB::table('pids')
                                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                                ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                                ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                                ->whereIn('pid_iniciativas.iniciativa_id', $request['iniciativa'])
                                ->where('uf.idUf', '=', $request['uf'])
                                ->whereIn('pids.ativo', $ativo)
                                ->orderBy('pids.nome', 'asc')
                                ->paginate(10);
                        }
                        else {
                            $pids = DB::table('pids')
                                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                                ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                                ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                                ->where('uf.idUf', '=', $request['uf'])
                                ->whereIn('pids.ativo', $ativo)
                                ->orderBy('pids.nome', 'asc')
                                ->paginate(10);
                        }
                    }
                }
            }
            else {
                //todos
                if(Defender::hasRole('gestor')) {
                    $pids = DB::table('pids')
                        ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                        ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('pid_iniciativas.iniciativa_id', '=', Auth::user()->iniciativa_id)
                        ->whereIn('pids.ativo', $ativo)
                        ->orderBy('pids.nome', 'asc')
                        ->paginate(10);
                }
                else {
                    if($request['iniciativa'][0] != 0) {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->join('pid_iniciativas', 'pid_id', '=', 'pids.idPid')
                            ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                            ->whereIn('pid_iniciativas.iniciativa_id', $request['iniciativa'])
                            ->whereIn('pids.ativo', $ativo)
                            ->orderBy('pids.nome', 'asc')
                            ->paginate(10);
                    }
                    else {
                        $pids = DB::table('pids')
                            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                            ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                            ->select('pids.*', 'cidades.nomeCidade', 'uf.uf')
                            ->whereIn('pids.ativo', $ativo)
                            ->orderBy('pids.nome', 'asc')
                            ->paginate(10);
                    }
                }
            }
        }

        $ufs = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $iniciativas = Iniciativa::all()->lists('nome', 'idIniciativa');
        $selected = isset($request['iniciativa'])? $request['iniciativa'] : array(0);
        return view('pids.index', compact('pids', 'ufs', 'iniciativas', 'selected'));
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
        $servicos = Servico::all()->lists('servico', 'idServico');

        return view('pids.create', compact('uf','localidades','localizacoes', 'telefoneTipos','pidTipos', 'servicos'));
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
        $pid->servicos()->sync($request['servicos']);

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

            $servicos = [];
            foreach($pid->servicos as $servico) {
                $servicos[] = $servico->idServico;
            }

            $cidade = DB::table('cidades')->select('uf_id')->where('idCidade', '=', $pid->endereco->cidade_id)->first();
            $uf = DB::table('uf')->select('idUf')->where('idUf', '=', $cidade->uf_id)->first();

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
                    'uf' => $uf->idUf,
                    'cidade_id' => $pid->endereco->cidade_id,
                    'latitude' => $pid->endereco->latitude,
                    'longitude' => $pid->endereco->longitude,
                    'localidade_id' => $pid->endereco->localidade_id,
                    'localizacao_id' => $pid->endereco->localizacao_id
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
        if(Defender::hasRole('gestor')) {
            $pids = DB::table('pid_iniciativas')
                ->select('pid_id')
                ->where('iniciativa_id', '=', Auth::user()->iniciativa_id)->lists('pid_id');
            if(!in_array($id, $pids))
                abort(401, 'Unauthorized action.');
        }

        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $localidades = DB::table('localidades')->orderBy('localidade')->lists('localidade','idLocalidade');
        $localizacoes = DB::table('localizacoes')->orderBy('localizacao')->lists('localizacao','idLocalizacao');
        $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $pidTipos = DB::table('pidTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $servicos = Servico::all()->lists('servico', 'idServico');

        return view('pids.edit', compact('uf','localidades','localizacoes', 'telefoneTipos','pidTipos', 'servicos'));
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
        $pid->touch();

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
        $pid->servicos()->sync($request['servicos']);

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

    /**
     * @param $id
     * @param $nome
     * @return mixed
     */
    public function fotos($id, $nome)
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fotosUpload(Request $request)
    {
        if($request->file('foto')->isValid()) {
            $file = $request->file('foto');

            $fileExtension = strtolower($file->getClientOriginalExtension());

            $extensions = ['gif', 'jpg', 'jpeg', 'png'];
            if(!in_array($fileExtension, $extensions))
                abort(406);

            $pid = Pid::findOrFail($request['idPid']);

            $storagePath = storage_path().'/imagens/'.$pid->idPid.'/';

            $fileName = str_random(32);//$file->getClientOriginalName();

            $truePath = $file->move($storagePath, $fileName);

            /*SALVAR NO BD*/
            $foto = new Foto(['nome' => $fileName, 'arquivo' => $truePath]);
            $foto = $pid->fotos()->save($foto);

            return response()->json($foto);
        }
        abort(406);
    }

    /**
     * @param Request $request
     */
    public function fotosDestroy(Request $request)
    {
        $foto = Foto::findOrFail($request['idFoto']);
        unlink($foto->arquivo);
        $foto->delete();
        return;
    }

    /**
     * @param Request $request
     * @return int
     */
    public function active(Request $request)
    {
        $pid = Pid::findOrFail($request['id']);

        $pid->update(['ativo' => !$pid->ativo]);

        return (int) $pid->ativo;
    }
}
