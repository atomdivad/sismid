<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use SisMid\Http\Requests;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexEmail()
    {
        $dados = DB::table('sismid_dados')->select('sismid_dados.*')->where('id', '=', '1')->get();
        //dd($dados);
        return view("admin.email.index", compact('dados'));

    }
    public function editEmail($id)
    {
        $email = DB::table('sismid_dados')->select('id','email')->where('id', '=', $id)->get();
        return view("admin.email.edit",compact('email'));
        //$ufs = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        //return view('iniciativas.index', compact('iniciativas', 'ufs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmail(Request $request, $id)
    {
        $this->validate($request,[
            "email"=>"required|min:5"
        ]);
        DB::table('sismid_dados')->where('id', '=', $id)->update(['email'=> $request['email']]);
        return redirect(route("admin.email.index"))->with([
            'flash_type_message' => 'alert-success',
            'flash_message' => 'E-mail atualizado com sucesso'
        ]);
    }

    //////////////// Endereço e Telefone /////////////////////

    public function indexEndContato()
    {
        $dados = DB::table('sismid_dados')->select('sismid_dados.*')->where('id', '=', '1')->get();
        //dd($dados);
        return view("admin.endContato.index", compact('dados'));

    }
    public function editEndContatoTel($id)
    {
        $dados = DB::table('sismid_dados')->select('id','telefone','endereco')->where('id', '=', $id)->get();
        return view("admin.endContato.editTelefone",compact('dados'));
    }
    public function editEndContato($id)
    {
        $dados = DB::table('sismid_dados')->select('id','telefone','endereco')->where('id', '=', $id)->get();
        return view("admin.endContato.editEndereco",compact('dados'));
    }

    public function updateEndContato(Request $request, $id)
    {
        $this->validate($request,[
            "endereco"=>"required|min:5"
        ]);
        DB::table('sismid_dados')->where('id', '=', $id)->update(['endereco'=> $request['endereco']]);
        return redirect(route("admin.endContato.index"))->with([
            'flash_type_message' => 'alert-success',
            'flash_message' => 'Endereço atualizado com sucesso'
        ]);
    }

    public function updateEndContatoTel(Request $request, $id)
    {
        $this->validate($request,[
            "telefone"=>"required|min:8"
        ]);
        DB::table('sismid_dados')->where('id', '=', $id)->update(['telefone'=> $request['telefone'],
            'telefone'=> $request['telefone']]);
        return redirect(route("admin.endContato.index"))->with([
            'flash_type_message' => 'alert-success',
            'flash_message' => 'Telefone atualizado com sucesso'
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
