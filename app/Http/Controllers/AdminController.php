<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use SisMid\Http\Requests;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Usuario;
use Artesaos\Defender\Facades\Defender;

class AdminController extends Controller
{

    public function indexEmail()
    {
        $dados = DB::table('sismid_dados')->select('sismid_dados.*')->where('id', '=', '1')->get();
        //dd($dados);
        return view("admin.email.index", compact('dados'));

    }

    public function editEmail($id)
    {
        $email = DB::table('sismid_dados')->select('id', 'email')->where('id', '=', $id)->get();
        return view("admin.email.edit", compact('email'));
    }

    public function updateEmail(Request $request, $id)
    {
        $this->validate($request, [
            "email" => "required|min:5"
        ]);
        DB::table('sismid_dados')->where('id', '=', $id)->update(['email' => $request['email']]);
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
        $dados = DB::table('sismid_dados')->select('id', 'telefone', 'endereco')->where('id', '=', $id)->get();
        return view("admin.endContato.editTelefone", compact('dados'));
    }

    public function editEndContato($id)
    {
        $dados = DB::table('sismid_dados')->select('id', 'telefone', 'endereco')->where('id', '=', $id)->get();
        return view("admin.endContato.editEndereco", compact('dados'));
    }

    public function updateEndContato(Request $request, $id)
    {
        $this->validate($request, [
            "endereco" => "required|min:5"
        ]);
        DB::table('sismid_dados')->where('id', '=', $id)->update(['endereco' => $request['endereco']]);
        return redirect(route("admin.endContato.index"))->with([
            'flash_type_message' => 'alert-success',
            'flash_message' => 'Endereço atualizado com sucesso'
        ]);
    }

    public function updateEndContatoTel(Request $request, $id)
    {
        $this->validate($request, [
            "telefone" => "required|min:8"
        ]);
        DB::table('sismid_dados')->where('id', '=', $id)->update(['telefone' => $request['telefone'],
            'telefone' => $request['telefone']]);
        return redirect(route("admin.endContato.index"))->with([
            'flash_type_message' => 'alert-success',
            'flash_message' => 'Telefone atualizado com sucesso'
        ]);
    }

    public function indexInfoEquipe()
    {
        $dados = DB::table('sismid_dados')->select('sismid_dados.*')->where('id', '=', '1')->get();
        //dd($dados);
        return view("admin.infoEquipe.index", compact('dados'));
    }

    public function editInfoEquipe($id)
    {
        $dados = DB::table('sismid_dados')->select('id', 'info_equipe')->where('id', '=', $id)->get();
        return view("admin.infoEquipe.editInfoEquipe", compact('dados'));
    }

    public function updateInfoEquipe(Request $request, $id)
    {
        $this->validate($request, [
            "info_equipe" => "required|min:8"
        ]);
        DB::table('sismid_dados')->where('id', '=', $id)->update(['info_equipe' => $request['info_equipe'],
            'info_equipe' => $request['info_equipe']]);
        return redirect(route("admin.infoEquipe.index"))->with([
            'flash_type_message' => 'alert-success',
            'flash_message' => 'Informações atualizadas com sucesso'
        ]);
    }

    public function indexGerenciaAdmin(Request $request)
    {
        if (strlen($request['nome']) > 0) {
            $gestores = DB::table('usuarios')
                ->join('role_user', 'role_user.user_id', '=', 'usuarios.idUsuario')
                ->select('usuarios.idUsuario', 'usuarios.nome', 'usuarios.sobrenome', 'usuarios.email')
                ->where('role_user.role_id', '=', 1)
                ->where('usuarios.idUsuario', '!=', 1)
                ->where('usuarios.nome', 'like', "%$request[nome]%")
                ->paginate(10);
            return view("admin.gerencia.index", compact('gestores'));
        } else {
            $gestores = DB::table('usuarios')
                ->join('role_user', 'role_user.user_id', '=', 'usuarios.idUsuario')
                ->select('usuarios.idUsuario', 'usuarios.nome', 'usuarios.sobrenome', 'usuarios.email')
                ->where('role_user.role_id', '=', 1)
                ->where('usuarios.idUsuario', '!=', 1)
                ->paginate(10);
            return view("admin.gerencia.index", compact('gestores'));
        }


    }

    public function createGerenciaAdmin()
    {

        return view("admin.gerencia.create");

    }

    public function storeGerenciaAdmin(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required|max:255',
            'sobrenome' => 'required|max:255',
            'email' => 'required|email|max:255'
        ]);

        $user = Usuario::create([
            'nome' => $request['nome'],
            'sobrenome' => $request['sobrenome'],
            'email' => $request['email'],
            'password' => bcrypt('admin') //mudar
        ]);

        $role = Defender::findRole('admin');
        $user->attachRole($role);
        return redirect(route("admin.gerencia.index"))->with([
            'flash_type_message' => 'alert-success',
            'flash_message' => 'Administrador cadastrado com sucesso'
        ]);
    }

    public function editGerenciaAdmin($id)
    {
        $dados = DB::table('usuarios')->select('idUsuario', 'nome', 'sobrenome', 'email')->where('idUsuario', '=', $id)->get();
        return view("admin.gerencia.edit", compact('dados'));
    }

    public function updateGerenciaAdmin(Request $request, $id)
    {
        if ($id != 1) {
            $this->validate($request, [
                'nome' => 'required|max:255',
                'sobrenome' => 'required|max:255',
                'email' => 'required|email|max:255'
            ]);
            DB::table('usuarios')->where('idUsuario', '=', $id)->update(['nome' => $request['nome'],
                'sobrenome' => $request['sobrenome'],
                'email' => $request['email']
            ]);
            return redirect(route("admin.gerencia.index"))->with([
                'flash_type_message' => 'alert-success',
                'flash_message' => 'Administrador atualizado com sucesso'
            ]);
        } else {
            return redirect(route("admin.gerencia.index"))->with([
                'flash_type_message' => 'alert-success',
                'flash_message' => 'Impossível alterar o super úsuario'
            ]);
        }
    }

    public function destroy($id)
    {
        //
    }
}
