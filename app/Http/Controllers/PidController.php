<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Endereco;
use SisMid\Models\Pid;

class PidController extends Controller
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

        return view('pids.create', compact('uf'));
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
            'url' => 'required|url',
            'cep' => 'required',
            'logradouro' => 'required|min:3',
            'numero' => 'required',
            'complemento' => '',
            'bairro' => 'required',
            'cidade_id' => 'required|numeric',
            'uf' => 'required|numeric',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $request['localidade_id'] = 1;
        $request['localizacao_id'] = 1;

        $endereco = Endereco::create($request->all());
        $endereco->pid()->create($request->all());

        return redirect(route('home'))->with([
            'flash_type_message' => 'alert-success',
            'flash_message' => 'Informações cadastradas com sucesso!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
