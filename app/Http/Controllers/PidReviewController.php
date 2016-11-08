<?php

namespace SisMid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use SisMid\Models\Pid;
use SisMid\Models\Endereco;
use SisMid\Models\Iniciativa;
use SisMid\Models\Servico;
use SisMid\Models\Telefone;
use SisMid\Models\Foto;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\Response;

class PidReviewController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('revisao.pids.index');
    }

    /**
     * Exibe os dados de PID.
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

            $cidade = DB::table('cidades')->select('uf_id', 'nomeCidade')->where('idCidade', '=', $pid->endereco->cidade_id)->first();
            $uf = DB::table('uf')->select('idUf', 'uf')->where('idUf', '=', $cidade->uf_id)->first();

            return [
                'idPid' => $pid->idPid,
                'nome' => $pid->nome,
                'email' => $pid->email,
                'url' => $pid->url,
                'tipo_id' => $pid->tipo_id,
                'tipo' => DB::table('pidTipos')->select('tipo')->where('idTipo', '=', $pid->tipo_id)->first()->tipo,
                'endereco' => [
                    'cep' => $pid->endereco->cep,
                    'logradouro' => $pid->endereco->logradouro,
                    'numero' => $pid->endereco->numero,
                    'complemento' => $pid->endereco->complemento,
                    'bairro' => $pid->endereco->bairro,
                    'idUf' => $uf->idUf,
                    'uf' => $uf->uf,
                    'cidade_id' => $pid->endereco->cidade_id,
                    'cidade' => $cidade->nomeCidade,
                    'latitude' => $pid->endereco->latitude,
                    'longitude' => $pid->endereco->longitude,
                    'localidade_id' => $pid->endereco->localidade_id,
                    'localidade' => ($pid->endereco->localidade_id)? DB::table('localidades')->select('localidade')->where('idLocalidade', '=', $pid->endereco->localidade_id)->first()->localidade : null,
                    'localizacao_id' => $pid->endereco->localizacao_id,
                    'localizacao' => ($pid->endereco->localizacao_id)? DB::table('localizacoes')->select('localizacao')->where('idLocalizacao', '=', $pid->endereco->localizacao_id)->first()->localizacao : null
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
     * Formulario p/ edicao de PID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(session('email') && session('pass')) {
            $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
            $localidades = DB::table('localidades')->orderBy('localidade')->lists('localidade','idLocalidade');
            $localizacoes = DB::table('localizacoes')->orderBy('localizacao')->lists('localizacao','idLocalizacao');
            $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
            $pidTipos = DB::table('pidTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
            $servicos = Servico::all()->lists('servico', 'idServico');

            return view('revisao.pids.edit', compact('uf','localidades','localizacoes', 'telefoneTipos','pidTipos', 'servicos'));
        }

        return redirect()->route('review.pid.login');
    }

    /**
     * Cria uma copia dos dados enviados p/ a revisao.
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

        $email = $request['session_email'];
        $pass = $request['session_pass'];

        $review = DB::table('pid_revisao')
            ->where('email', $email)
            ->where('pass', $pass)
            ->where('valido', 1)
            ->where('submetido', 0)
            ->select('pid_id', 'idRevisao')
            ->get();

        if(empty($review)) {
            abort(401, 'Acesso Inválido');
        }
        else if($review[0]->pid_id != $request['idPid']) {
            abort(401, 'Acesso Inválido');
        }

        file_put_contents(storage_path().'/revisao/pid_'.$request['idPid'].'.json', json_encode($request->all()));
        DB::table('pid_revisao')->where('idRevisao', '=', $review[0]->idRevisao)->update(['submetido' => 1, 'updated_at'=> Carbon::now()]);
        return $request->all();
    }

    /**
     * Confirma os dados de um PID editado
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirm($id)
    {
        //$json =  json_decode(file_get_contents(storage_path().'/revisao/pid_'.$id.'.json'), true);

        $uf = DB::table('uf')->orderBy('uf')->lists('uf','idUf');
        $localidades = DB::table('localidades')->orderBy('localidade')->lists('localidade','idLocalidade');
        $localizacoes = DB::table('localizacoes')->orderBy('localizacao')->lists('localizacao','idLocalizacao');
        $telefoneTipos = DB::table('telefoneTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $pidTipos = DB::table('pidTipos')->orderBy('tipo')->lists('tipo', 'idTipo');
        $servicos = Servico::all()->lists('servico', 'idServico');

        return view('revisao.pids.review', compact('uf','localidades','localizacoes', 'telefoneTipos','pidTipos', 'servicos'));
    }

    /**
     * Formulario p/ revisar os dados editados
     * @param null $id
     * @return mixed
     */
    public function review($id = null)
    {
        if($id)
        {
            $filePath = storage_path().'/revisao/pid_'.$id.'.json';
            return file_exists($filePath)? json_decode(file_get_contents($filePath), true) : abort(404);
        }
    }

    /**
     * Atualiza na base os dados de um PID revisado.
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

        $email = $request['session_email'];
        $pass = $request['session_pass'];

        $review = DB::table('pid_revisao')
            ->where('email', $email)
            ->where('pass', $pass)
            ->where('valido', 1)
            ->where('submetido', 1)
            ->select('pid_id', 'idRevisao')
            ->get();

        if(empty($review)) {
            return ['error' => 'Acesso Inválido'];
        }
        else if($review[0]->pid_id != $request['idPid']) {
            return ['error' => 'Acesso Inválido'];
        }

        DB::beginTransaction();
        try {
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

            DB::table('pid_revisao')->where('idRevisao', '=', $review[0]->idRevisao)->update(['valido' => 0, 'updated_at'=> Carbon::now()]);

            DB::commit();

        }
        catch (\Exception $e) {
            DB::rollback();
            abort(400);
        }
        finally {
            unlink(storage_path().'/revisao/pid_'.$pid->idPid.'.json');
            return $this->show($pid->idPid);
        }

    }

    /**
     * Retorna lista de pids em revisao
     * @return mixed
     */
    public function lists()
    {
        $pids = DB::table('pid_revisao')
            ->join('pids', 'pids.idPid', '=', 'pid_revisao.pid_id')
            ->select('pids.*', 'pid_revisao.*')
            ->where('valido', '=', 1)
            ->orderBy('pid_revisao.created_at', 'desc')
            ->get();
        return $pids;
    }

    /**
     * @param null $id
     * @return mixed
     */
    public function remove($id = null)
    {
        if($id)
        {
            return DB::table('pid_revisao')->where('idRevisao', '=', $id)->update(['valido' => 0, 'updated_at'=> Carbon::now()]);
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function logar(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $email = $request->email;
        $pass = $request->password;
        /*buscar o pid o qual as credenciais pertencem*/
        $review = DB::table('pid_revisao')
            ->where('email', $email)
            ->where('pass', $pass)
            ->where('valido', 1)
            ->where('submetido', 0)
            ->get();

        if($review)
            return redirect()
                ->route('review.pid.edit', $review[0]->pid_id)
                ->with(['email' => $email, 'pass' => $pass] );
        else
            return redirect()->back()->withErrors('Senha de acesso Inválida! ');
    }
}
