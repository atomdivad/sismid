<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Usuario;
use SisMid\Models\Iniciativa;

class IniciativaGestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(strlen($request['nome']) > 0) {
            if($request['iniciativa'][0] != 0) {
                $gestores = DB::table('usuarios')
                    ->join('role_user', 'role_user.user_id', '=', 'usuarios.idUsuario')
                    ->join('iniciativas', 'iniciativas.idIniciativa', '=', 'usuarios.iniciativa_id')
                    ->select('usuarios.idUsuario','usuarios.nome', 'usuarios.sobrenome', 'usuarios.email', 'iniciativas.nome as nomeIniciativa')
                    ->where('usuarios.nome', 'like', "%$request[nome]%")
                    ->where('role_user.role_id', '=', 2)
                    ->whereIn('iniciativas.idIniciativa', $request['iniciativa'])
                    ->paginate(10);
            }
            else {
                $gestores = DB::table('usuarios')
                    ->join('role_user', 'role_user.user_id', '=', 'usuarios.idUsuario')
                    ->join('iniciativas', 'iniciativas.idIniciativa', '=', 'usuarios.iniciativa_id')
                    ->select('usuarios.idUsuario','usuarios.nome', 'usuarios.sobrenome', 'usuarios.email', 'iniciativas.nome as nomeIniciativa')
                    ->where('usuarios.nome', 'like', "%$request[nome]%")
                    ->where('role_user.role_id', '=', 2)
                    ->paginate(10);
            }
        }
        else {
            if($request['iniciativa'][0] != 0) {
                $gestores = DB::table('usuarios')
                    ->join('role_user', 'role_user.user_id', '=', 'usuarios.idUsuario')
                    ->join('iniciativas', 'iniciativas.idIniciativa', '=', 'usuarios.iniciativa_id')
                    ->select('usuarios.idUsuario','usuarios.nome', 'usuarios.sobrenome', 'usuarios.email', 'iniciativas.nome as nomeIniciativa')
                    ->where('role_user.role_id', '=', 2)
                    ->whereIn('iniciativas.idIniciativa', $request['iniciativa'])
                    ->paginate(10);
            }
            else {
                $gestores = DB::table('usuarios')
                    ->join('role_user', 'role_user.user_id', '=', 'usuarios.idUsuario')
                    ->join('iniciativas', 'iniciativas.idIniciativa', '=', 'usuarios.iniciativa_id')
                    ->select('usuarios.idUsuario','usuarios.nome', 'usuarios.sobrenome', 'usuarios.email', 'iniciativas.nome as nomeIniciativa')
                    ->where('role_user.role_id', '=', 2)
                    ->paginate(10);
            }
        }

        $ufs = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $iniciativas = Iniciativa::all()->lists('nome', 'idIniciativa');
        $selected = isset($request['iniciativa'])? $request['iniciativa'] : array(0);
        return view('iniciativas.gestores.index', compact('gestores', 'ufs', 'iniciativas', 'selected'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');

        return view('iniciativas.gestores.create', compact('uf'));
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
            'sobrenome' => 'required|min:3|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'iniciativa_id' => 'required|exists:iniciativas,idIniciativa',
        ]);

        $request['password'] =  bcrypt(str_random(10));
        $usuario = Usuario::create($request->all());

        /*Role 2 => Usuario Gestor*/
        $usuario->syncRoles([2]);

        return $this->show($usuario->idUsuario);
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

            $usuario = Usuario::findOrFail($id);

            $cidade = DB::table('cidades')->select('nomeCidade', 'uf_id')->where('idCidade', '=', $usuario->iniciativa->endereco->cidade_id)->first();
            $uf = DB::table('uf')->select('uf')->where('idUf', '=', $cidade->uf_id)->first();


            return [
                'idUsuario' => $usuario->idUsuario,
                'nome' => $usuario->nome,
                'sobrenome' => $usuario->sobrenome,
                'email' => $usuario->email,
                'iniciativa' => [
                    array(
                        'idIniciativa' => $usuario->iniciativa->idIniciativa,
                        'nome' => $usuario->iniciativa->nome,
                        'nomeCidade' => $cidade->nomeCidade,
                        'uf' => $uf->uf
                    )
                ]
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

        return view('iniciativas.gestores.edit', compact('uf'));
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
            'nome' => 'required|min:3|max:255',
            'sobrenome' => 'required|min:3|max:255',
            'email' => 'required|email|unique:usuarios,email,'.$request['idUsuario'].',idUsuario',
            'iniciativa_id' => 'required|exists:iniciativas,idIniciativa',
        ]);

        $usuario = Usuario::findOrFail($request['idUsuario']);

        $usuario->update($request->all());

        return $this->show($usuario->idUsuario);
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
