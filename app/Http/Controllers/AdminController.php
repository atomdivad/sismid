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
