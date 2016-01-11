<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Endereco;
use SisMid\Models\Instituicao;
use SisMid\Models\Telefone;


class InstituicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(strlen($request['nome']) > 0 ) {
            if ($request['uf'] != 0) {
                if($request['cidade_id']) {
                    //nome + cidade
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('instituicoes.nome', 'like', "%$request[nome]%")
                        ->where('cidades.idCidade', '=', $request['cidade_id'])
                        ->get();
                }
                else {
                    //nome + uf
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('instituicoes.nome', 'like', "%$request[nome]%")
                        ->where('uf.idUf', '=', $request['uf'])
                        ->get();
                }
            }
            else {
                //nome
                $instituicoes = DB::table('instituicoes')
                    ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('instituicoes.*', 'cidades.nomeCidade', 'uf.uf')
                    ->where('instituicoes.nome', 'like', "%$request[nome]%")
                    ->get();
            }
        }
        else {
            if ($request['uf'] != 0) {
                if($request['cidade_id']) {
                    // cidade
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('cidades.idCidade', '=', $request['cidade_id'])
                        ->get();
                }
                else {
                    //uf
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.*', 'cidades.nomeCidade', 'uf.uf')
                        ->where('uf.idUf', '=', $request['uf'])
                        ->get();
                }
            }
            else {
                //tddos
                $instituicoes = DB::table('instituicoes')
                    ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('instituicoes.*', 'cidades.nomeCidade', 'uf.uf')
                    ->get();
            }
        }

        $ufs = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        return view('instituicoes.index', compact('instituicoes', 'ufs'));
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

        return view('instituicoes.create', compact('uf','localidades','localizacoes','naturezasJuridicas', 'telefoneTipos'));
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
            'nome' => 'required',
            'email' => 'required',
            'url' => 'url',
            'endereco.logradouro' => 'required|min:3|max:150',
            'endereco.bairro' => 'required|min:3|max:150',
            'endereco.uf' => 'required',
            'endereco.cidade_id' => 'required|exists:cidades,idCidade',
            'endereco.localidade_id'=> 'exists:localidades,idLocalidade',
            'endereco.localizacao_id'=> 'exists:localizacoes,idLocalizacao',
        ]);

        $endereco = Endereco::create($request['endereco']);
        $instituicao = $endereco->instituicao()->create($request->all());

        foreach($request['telefones'] as $telefone) {
            $instituicao->telefones()->create($telefone);
        }

        return $this->show($instituicao->idInstituicao);
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
            $instituicao = Instituicao::findOrFail($id);

            return  [
                'idInstituicao' => $instituicao->idInstituicao,
                'nome' => $instituicao->nome,
                'email' => $instituicao->email,
                'url' => $instituicao->url,
                'naturezaJuridica_id' => $instituicao->naturezaJuridica_id,
                'endereco' => [
                    'cep' => $instituicao->endereco->cep,
                    'logradouro' => $instituicao->endereco->logradouro,
                    'numero' => $instituicao->endereco->numero,
                    'complemento' => $instituicao->endereco->complemento,
                    'bairro' => $instituicao->endereco->bairro,
                    'uf' => 51,
                    'cidade_id' => $instituicao->endereco->cidade_id,
                    'latitude' => $instituicao->endereco->latitude,
                    'longitude' => $instituicao->endereco->longitude,
                    'localidade_id' => $instituicao->endereco->localidade_id,
                    'localizacao_id' => $instituicao->endereco->localizacao_id
                ],
                'telefones' => $instituicao->telefones
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
        $naturezasJuridicas = DB::table('naturezasJuridicas')->orderBy('naturezaJuridica')->lists('naturezaJuridica','idNatureza');
        $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');

        return view('instituicoes.edit', compact('uf','localidades','localizacoes','naturezasJuridicas', 'telefoneTipos'));
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
            'nome' => 'required',
            'email' => 'required',
            'url' => 'url',
            'endereco.logradouro' => 'required|min:3|max:150',
            'endereco.bairro' => 'required|min:3|max:150',
            'endereco.uf' => 'required',
            'endereco.cidade_id' => 'required|exists:cidades,idCidade',
            'endereco.localidade_id'=> 'exists:localidades,idLocalidade',
            'endereco.localizacao_id'=> 'exists:localizacoes,idLocalizacao',
        ]);

        $instituicao = Instituicao::findOrFail($request['idInstituicao']);

        $instituicao->endereco()->update($request['endereco']);
        $instituicao->update($request->all());


        $telefones = [];
        foreach($request['telefones'] as $telefone) {
            if($telefone['idTelefone'] == null) {
                $tel = $instituicao->telefones()->create($telefone);
                $telefones[] = $tel->idTelefone;
            }
            else {
                $tel = Telefone::find($telefone['idTelefone']);
                $tel->update($telefone);
                $telefones[] = $tel->idTelefone;
            }
        }
        $instituicao->telefones()->sync($telefones);

        return $this->show($instituicao->idInstituicao);
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
