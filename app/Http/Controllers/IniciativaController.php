<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SisMid\Models\Endereco;
use SisMid\Models\Iniciativa;

class IniciativaController extends Controller
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

        return view('iniciativas.create', compact('uf','localidades','localizacoes','naturezasJuridicas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $endereco = Endereco::create($request['endereco']);
        $iniciativa = $endereco->iniciativa()->create($request->all());

        foreach($request['telefones'] as $telefone) {
            $iniciativa->telefones()->create($telefone);
        }

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
                    'uf' => 51, /*ADICIONAR A UF*/
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
                'telefones' => [],
                'instituicoes' => []
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

        return view('iniciativas.edit', compact('uf','localidades','localizacoes','naturezasJuridicas'));
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
        $iniciativa = Iniciativa::findOrFail($request['idIniciativa']);

        $iniciativa->endereco()->update($request['endereco']);
        $iniciativa->update($request->all());


        foreach($request['telefones'] as $telefone) {
            if($telefone['idTelefone'] == null)
                $iniciativa->telefones()->create($telefone);
        }

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
