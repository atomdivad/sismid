<?php

namespace SisMid\Http\Controllers;

use Artesaos\Defender\Facades\Defender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SisMid\Models\Dimensao;
use SisMid\Models\Endereco;
use SisMid\Models\Iniciativa;
use SisMid\Models\Servico;
use SisMid\Models\Telefone;

class IniciativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(strlen($request['nome']) > 0 ) {
            if($request['uf'] != 0) {
                if($request['cidade_id'] != 0) {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('iniciativas.nome', 'like', "%$request[nome]%")
                        ->where('cidades.idCidade', '=', $request['cidade_id'])
                        ->paginate(10);
                }
                else {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('iniciativas.nome', 'like', "%$request[nome]%")
                        ->where('uf.idUf', '=', $request['uf'])
                        ->paginate(10);
                }
            }
            else {
                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('iniciativas.*', 'cidades.nomeCidade', 'uf.uf')
                    ->where('iniciativas.nome', 'like', "%$request[nome]%")
                    ->paginate(10);
            }
        }
        else {
            if($request['uf'] != 0) {
                if($request['cidade_id'] != 0) {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('cidades.idCidade', '=', $request['cidade_id'])
                        ->paginate(10);
                }
                else {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('uf.idUf', '=', $request['uf'])
                        ->paginate(10);
                }
            }
            else {
                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('iniciativas.*', 'cidades.nomeCidade', 'uf.uf')
                    ->paginate(10);
            }
        }

        $ufs = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        return view('iniciativas.index', compact('iniciativas', 'ufs'));
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
        $naturezasJuridicas = DB::table('naturezasJuridicas')->orderBy('naturezaJuridica')->lists('naturezaJuridica','idNatureza');
        $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $dimensoes = Dimensao::all()->lists('dimensao', 'idDimensao');
        $servicos = Servico::all()->lists('servico', 'idServico');

        return view('iniciativas.create', compact('uf','localidades','localizacoes','naturezasJuridicas','telefoneTipos', 'dimensoes', 'servicos'));
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
            'nome' => 'required|min:3|max:255',
            'sigla' => 'min:2|max:10',
            'tipo_id' => 'required|exists:iniciativaTipos,idTipo',
            'endereco.logradouro' => 'required|min:3|max:150',
            'endereco.bairro' => 'required|min:3|max:150',
            'endereco.uf' => 'required',
            'endereco.cidade_id' => 'required|exists:cidades,idCidade',
            'endereco.latitude' => 'numeric',
            'endereco.longitude' => 'numeric',
            'endereco.localidade_id'=> 'exists:localidades,idLocalidade',
            'endereco.localizacao_id'=> 'exists:localizacoes,idLocalizacao',
            'naturezaJuridica_id' => 'exists:naturezasJuridicas,idNatureza',
            'email' => 'required|email',
            'url' => 'url',
            'objetivo' => 'min:3|max:255',
            'informacaoComplementar' => 'min:3|max:255',
            'categoria_id' => 'required|exists:iniciativaCategorias,idCategoria',
            'fonte' => 'required|min:3|max:255',
        ]);

        $endereco = Endereco::create($request['endereco']);
        $iniciativa = $endereco->iniciativa()->create($request->all());

        foreach($request['telefones'] as $telefone) {
            $iniciativa->telefones()->create($telefone);
        }

        if(count($request['instituicoes']) > 0) {
            $instituicoes = [];
            foreach($request['instituicoes'] as $instituicao) {
                $instituicoes[$instituicao['idInstituicao']] = array('tipoVinculo' => $instituicao['tipoVinculo']);
            }
            $iniciativa->instituicoes()->sync($instituicoes);
        }

        $iniciativa->dimensoes()->sync($request['dimensoes']);
        $iniciativa->servicos()->sync($request['servicos']);

        return $this->show($iniciativa->idIniciativa);
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
                    'tipoVinculo' => $instituicao->pivot->tipoVinculo
                );
            }

            $dimensoes = [];
            foreach($iniciativa->dimensoes as $dimensao) {
                $dimensoes[] = $dimensao->idDimensao;
            }

            $servicos = [];
            foreach($iniciativa->servicos as $servico) {
                $servicos[] = $servico->idServico;
            }

            $cidade = DB::table('cidades')->select('uf_id')->where('idCidade', '=', $iniciativa->endereco->cidade_id)->first();
            $uf = DB::table('uf')->select('idUf')->where('idUf', '=', $cidade->uf_id)->first();

            return [
                'idIniciativa' =>  $iniciativa->idIniciativa,
                'tipo_id' => $iniciativa->tipo_id,
                'nome' => $iniciativa->nome,
                'sigla' => $iniciativa->sigla,
                'endereco' => [
                    'cep' => $iniciativa->endereco->cep,
                    'logradouro' => $iniciativa->endereco->logradouro,
                    'numero' => $iniciativa->endereco->numero,
                    'complemento' => $iniciativa->endereco->complemento,
                    'bairro' => $iniciativa->endereco->bairro,
                    'uf' => $uf->idUf,
                    'cidade_id' => $iniciativa->endereco->cidade_id,
                    'latitude' => $iniciativa->endereco->latitude,
                    'longitude' => $iniciativa->endereco->longitude,
                    'localidade_id' => $iniciativa->endereco->localidade_id,
                    'localizacao_id' => $iniciativa->endereco->localizacao_id
                ],
                'naturezaJuridica_id' => $iniciativa->naturezaJuridica_id,
                'email' => $iniciativa->email,
                'url' => $iniciativa->url,
                'objetivo' => $iniciativa->objetivo,
                'informacaoComplementar' => $iniciativa->informacaoComplementar,
                'categoria_id' => $iniciativa->categoria_id,
                'fonte' => $iniciativa->fonte,
                'telefones' => $iniciativa->telefones,
                'instituicoes' => $instituicoes,
                'dimensoes' => $dimensoes,
                'servicos' => $servicos
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
            if(Auth::user()->iniciativa_id != $id) {
                abort(401, 'Unauthorized action.');
            }
        }

        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $localidades = DB::table('localidades')->orderBy('localidade')->lists('localidade','idLocalidade');
        $localizacoes = DB::table('localizacoes')->orderBy('localizacao')->lists('localizacao','idLocalizacao');
        $naturezasJuridicas = DB::table('naturezasJuridicas')->orderBy('naturezaJuridica')->lists('naturezaJuridica','idNatureza');
        $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $dimensoes = Dimensao::all()->lists('dimensao', 'idDimensao');
        $servicos = Servico::all()->lists('servico', 'idServico');

        return view('iniciativas.edit', compact('uf','localidades','localizacoes','naturezasJuridicas','telefoneTipos', 'dimensoes', 'servicos'));
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
            'tipo_id' => 'required|exists:iniciativaTipos,idTipo',
            'nome' => 'required|min:3|max:255',
            'sigla' => 'min:2|max:10',
            'endereco.logradouro' => 'required|min:3|max:150',
            'endereco.bairro' => 'required|min:3|max:150',
            'endereco.uf' => 'required',
            'endereco.cidade_id' => 'required|exists:cidades,idCidade',
            'endereco.latitude' => 'numeric',
            'endereco.longitude' => 'numeric',
            'endereco.localidade_id'=> 'exists:localidades,idLocalidade',
            'endereco.localizacao_id'=> 'exists:localizacoes,idLocalizacao',
            'naturezaJuridica_id' => 'exists:naturezasJuridicas,idNatureza',
            'email' => 'required|email',
            'url' => 'url',
            'objetivo' => 'min:3|max:255',
            'informacaoComplementar' => 'min:3|max:255',
            'categoria_id' => 'required|exists:iniciativaCategorias,idCategoria',
            'fonte' => 'required|min:3|max:255',
        ]);

        $iniciativa = Iniciativa::findOrFail($request['idIniciativa']);

        $iniciativa->endereco()->update($request['endereco']);
        $iniciativa->update($request->all());

        $telefones = [];
        foreach($request['telefones'] as $telefone) {
            if($telefone['idTelefone'] == null) {
                $tel = $iniciativa->telefones()->create($telefone);
                $telefones[] = $tel->idTelefone;
            }
            else {
                $tel = Telefone::find($telefone['idTelefone']);
                $tel->update($telefone);
                $telefones[] = $tel->idTelefone;
            }
        }
        $iniciativa->telefones()->sync($telefones);

        $instituicoes = [];
        foreach($request['instituicoes'] as $instituicao) {
            $instituicoes[$instituicao['idInstituicao']] = array('tipoVinculo' => $instituicao['tipoVinculo']);
        }
        $iniciativa->instituicoes()->sync($instituicoes);

        $iniciativa->dimensoes()->sync($request['dimensoes']);
        $iniciativa->servicos()->sync($request['servicos']);

        return $this->show($iniciativa->idIniciativa);
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