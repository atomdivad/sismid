<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Endereco;
use SisMid\Models\Instituicao;


class InstituicaoController extends Controller
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
        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $localidades = DB::table('localidades')->orderBy('localidade')->lists('localidade','idLocalidade');
        $localizacoes = DB::table('localizacoes')->orderBy('localizacao')->lists('localizacao','idLocalizacao');
        $naturezasJuridicas = DB::table('naturezasJuridicas')->orderBy('naturezaJuridica')->lists('naturezaJuridica','idNatureza');

        return view('instituicoes.create', compact('uf','localidades','localizacoes','naturezasJuridicas'));
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
            'endereco.cep' => 'required',
            'endereco.logradouro' => 'required',
            'endereco.bairro' => 'required',
            'endereco.cidade_id' => 'required',
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

        return view('instituicoes.edit', compact('uf','localidades','localizacoes','naturezasJuridicas'));
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
            'endereco.cep' => 'required',
            'endereco.logradouro' => 'required',
            'endereco.bairro' => 'required',
            'endereco.cidade_id' => 'required',
        ]);

        $instituicao = Instituicao::findOrFail($request['idInstituicao']);

        $instituicao->endereco()->update($request['endereco']);
        $instituicao->update($request->all());


        foreach($request['telefones'] as $telefone) {
            if($telefone['idTelefone'] == null)
                $instituicao->telefones()->create($telefone);
        }

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
