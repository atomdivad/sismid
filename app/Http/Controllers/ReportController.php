<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Khill\Lavacharts\Lavacharts;
use Illuminate\Support\Facades\DB;
use SisMid\Models\Dimensao;
use SisMid\Models\Pid;
use SisMid\Models\Iniciativa;
use SisMid\Models\Servico;

class ReportController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexPid()
    {
        if(!Cache::has('uf'))
            Cache::forever('uf', DB::table('uf')->orderBy('uf')->lists('uf','idUf'));
        $uf = Cache::get('uf');

        $pidStatus = $this->reportPidStatus();
        $pidTipo = $this->reportPidTipo();
        $pidIniciativa = $this->reportPidIniciativa();
        $pidInstituicao = $this->reportPidInstituicao();
        $pidLocalizcao = $this->reportPidLocalizacao();
        $pidLocalidade = $this->reportPidLocalidade();
        $pidServico = $this->reportPidServico();

        return view('relatorios.pid', compact('uf', 'pidStatus', 'pidTipo', 'pidIniciativa', 'pidInstituicao',
            'pidLocalizcao', 'pidLocalidade', 'pidServico'
        ));
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportPidStatus(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportPidStatusGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportpidStatusByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportpidStatusByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportpidStatusByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportpidStatusByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportpidStatusByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportpidStatusByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportpidStatusByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else
        {
            $dados = $this->reportPidStatusGeral();
            $graph = \Lava::BarChart('PidStatus')->setOptions(['datatable' => $dados]);
            return $graph;
        }
    }

    /**
     * @return mixed
     */
    private function reportPidStatusGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Status');
        $dados->addNumberColumn('Qtd');
        $dados->addRow(['Total', Pid::all()->count()]);
        $dados->addRow(['Ativos', Pid::where('ativo', '=', true)->count()]);
        $dados->addRow(['Inativos', Pid::where('ativo', '=', false)->count()]);
        return $dados;
    }

    /**
     * @param $uf
     * @return mixed
     */
    private function reportpidStatusByUf($uf)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Status');
        $dados->addNumberColumn('Qtd');

        $total = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->count();

        $ativos = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->where('pids.ativo', 1)
            ->count();

        $inativos = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->where('pids.ativo', 0)
            ->count();

        $dados->addRow(['Total', $total]);
        $dados->addRow(['Ativos', $ativos]);
        $dados->addRow(['Inativos', $inativos]);

        return $dados;
    }

    /**
     * @param $cidade
     * @return mixed
     */
    private function reportpidStatusByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Status');
        $dados->addNumberColumn('Qtd');

        $total = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->where('enderecos.cidade_id', $cidade)
            ->count();

        $ativos = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->where('enderecos.cidade_id', $cidade)
            ->where('pids.ativo', 1)
            ->count();

        $inativos = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->where('enderecos.cidade_id', $cidade)
            ->where('pids.ativo', 0)
            ->count();

        $dados->addRow(['Total', $total]);
        $dados->addRow(['Ativos', $ativos]);
        $dados->addRow(['Inativos', $inativos]);

        return $dados;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportPidTipo(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportPidTipoGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportPidTipoByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportPidTipoByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportPidTipoByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportPidTipoByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportPidTipoByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportPidTipoByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportPidTipoByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else {
            $dados = $this->reportPidTipoGeral();
            $graph = \Lava::PieChart('PidTipos')
                ->setOptions([
                    'datatable' => $dados,
                    'is3D' => true,
                    'slices' => [
                        \Lava::Slice(['offset' => 0.1]),
                        \Lava::Slice(['offset' => 0.1]),
                    ]
                ]);

            return $graph;
        }
    }

    /**
     * @return mixed
     */
    private function reportPidTipoGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Tipos')
            ->addNumberColumn('Qtd');

        $tipos = DB::table('pidTipos')->get();
        foreach ($tipos as $tp) {
            $dados->addRow([$tp->tipo, Pid::where('tipo_id', '=', $tp->idTipo)->count()]);
        }
        $aux = Pid::where('tipo_id', '=', null)->count();
        if ($aux > 0)
            $dados->addRow(['Não Informado', $aux]);
        return $dados;
    }

    /**
     * @param $uf
     * @return mixed
     */
    private function reportPidTipoByUf($uf)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Tipos')
            ->addNumberColumn('Qtd');

        $tipos = DB::table('pidTipos')->get();
        foreach ($tipos as $tp) {
            $qt = DB::table('pids')
                ->where('pids.tipo_id', $tp->idTipo)
                ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
                ->join('cidades', 'cidades.idCidade', '=', 'enderecos.cidade_id')
                ->whereIn('cidades.uf_id', $uf)
                ->count();

            $dados->addRow([$tp->tipo, $qt]);
        }
        $aux = DB::table('pids')
            ->where('pids.tipo_id', null)
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->join('cidades', 'cidades.idCidade', '=', 'enderecos.cidade_id')
            ->whereIn('cidades.uf_id', $uf)
            ->count();
        if ($aux > 0)
            $dados->addRow(['Não Informado', $aux]);
        return $dados;
    }

    /**
     * @param $cidade
     * @return mixed
     */
    private function reportPidTipoByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Tipos')
            ->addNumberColumn('Qtd');

        $tipos = DB::table('pidTipos')->get();
        foreach ($tipos as $tp) {
            $qt = DB::table('pids')
                ->where('pids.tipo_id', $tp->idTipo)
                ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
                ->where('enderecos.cidade_id', $cidade)
                ->count();

            $dados->addRow([$tp->tipo, $qt]);
        }
        $aux = DB::table('pids')
            ->where('pids.tipo_id', null)
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->count();
        if ($aux > 0)
            $dados->addRow(['Não Informado', $aux]);
        return $dados;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportPidIniciativa(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportPidIniciativaGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportPidIniciativaByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportPidIniciativaByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportPidIniciativaByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportPidIniciativaByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportPidIniciativaByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportPidIniciativaByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportPidIniciativaByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else {
            $dados = $this->reportPidIniciativaGeral();
            $graph = \Lava::PieChart('PidIniciativa')
                ->setOptions([
                    'datatable' => $dados,
                    'is3D' => true,
                    'slices' => [
                        \Lava::Slice(['offset' => 0.1]),
                    ]
                ]);

            return $graph;
        }
    }

    /**
     * @return mixed
     */
    private function reportPidIniciativaGeral()
    {
        $pids = Pid::has('iniciativas')->count();
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Pids')
            ->addNumberColumn('Qtd');

        $dados ->addRow(['Com Iniciativas', $pids]);
        $dados ->addRow(['Sem Iniciativas', Pid::has('iniciativas', '=', 0)->count()]);
        return $dados;
    }

    /**
     * @param $uf
     * @return mixed
     */
    private function reportPidIniciativaByUf($uf)
    {
        $com = DB::table('pids')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->join('cidades','enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->whereRaw('pids.idPid IN (SELECT pid_id FROM pid_iniciativas)')
            ->get();


        $sem = DB::table('pids')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->join('cidades','enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->whereRaw('pids.idPid NOT IN (SELECT pid_id FROM pid_iniciativas)')
            ->get();

        $dados = \Lava::DataTable();
        $dados->addStringColumn('Pids')
            ->addNumberColumn('Qtd');

        $dados ->addRow(['Com Iniciativas', count($com)]);
        $dados ->addRow(['Sem Iniciativas', count($sem)]);
        return $dados;
    }

    /**
     * @param $cidade
     * @return mixed
     */
    private function reportPidIniciativaByCidade($cidade)
    {
        $com = DB::table('pids')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('pids.idPid IN (SELECT pid_id FROM pid_iniciativas)')
            ->get();


        $sem = DB::table('pids')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('pids.idPid NOT IN (SELECT pid_id FROM pid_iniciativas)')
            ->get();

        $dados = \Lava::DataTable();
        $dados->addStringColumn('Pids')
            ->addNumberColumn('Qtd');

        $dados ->addRow(['Com Iniciativas', count($com)]);
        $dados ->addRow(['Sem Iniciativas', count($sem)]);
        return $dados;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportPidInstituicao(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportPidInstituicaoGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportPidInstituicaoByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportPidInstituicaoByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportPidInstituicaoByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportPidInstituicaoByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportPidInstituicaoByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportPidInstituicaoByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportPidInstituicaoByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else {
            $dados = $this->reportPidInstituicaoGeral();
            $graph = \Lava::ColumnChart('PidInstituicao')
                ->setOptions([
                    'datatable' => $dados,
                    'legend' => \Lava::Legend([
                        'position' => 'top'
                    ])
                ]);
            return $graph;
        }
    }

    /**
     * @return mixed
     */
    private function reportPidInstituicaoGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Instituição')
            ->addNumberColumn('Total');

        $ci = Pid::has('instituicoes')->count();
        $si = Pid::has('instituicoes', '=', 0)->count();

        $dados->addRow(['Possuem Mantenedores', $ci]);
        $dados->addRow(['Não Possuem Mantenedores', $si]);
        return $dados;
    }

    /**
     * @param $uf
     * @return mixed
     */
    private function reportPidInstituicaoByUf($uf)
    {
        $com = DB::table('pids')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->join('cidades','enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->whereRaw('pids.idPid IN (SELECT pid_id FROM pid_instituicoes)')
            ->get();


        $sem = DB::table('pids')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->join('cidades','enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->whereRaw('pids.idPid NOT IN (SELECT pid_id FROM pid_instituicoes)')
            ->get();

        $dados = \Lava::DataTable();
        $dados->addStringColumn('Instituição')
            ->addNumberColumn('Total');

        $dados->addRow(['C/ Instituições', count($com)]);
        $dados->addRow(['S/ Instituições', count($sem)]);
        return $dados;
    }

    /**
     * @param $cidade
     * @return mixed
     */
    private function reportPidInstituicaoByCidade($cidade)
    {
        $com = DB::table('pids')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('pids.idPid IN (SELECT pid_id FROM pid_instituicoes)')
            ->get();


        $sem = DB::table('pids')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'pids.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('pids.idPid NOT IN (SELECT pid_id FROM pid_instituicoes)')
            ->get();

        $dados = \Lava::DataTable();
        $dados->addStringColumn('Instituição')
            ->addNumberColumn('Total');

        $dados->addRow(['C/ Instituições', count($com)]);
        $dados->addRow(['S/ Instituições', count($sem)]);
        return $dados;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportPidLocalizacao(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportPidLocalizacaoGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportPidLocalizacaoByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportPidLocalizacaoByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportPidLocalizacaoByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportPidLocalizacaoByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportPidLocalizacaoByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportPidLocalizacaoByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportPidLocalizacaoByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else {
            $dados = $this->reportPidLocalizacaoGeral();
            $graph = \Lava::PieChart('PidLocalizcao')
                ->setOptions([
                    'datatable' => $dados,
                    'is3D' => true
                ]);

            return $graph;
        }
    }

    /**
     * @return mixed
     */
    private function reportPidLocalizacaoGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localização')
            ->addNumberColumn('Qtd');

        $localizacoes = DB::table('localizacoes')->get();
        foreach($localizacoes as $lc) {
            $qt = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
                ->where('enderecos.localizacao_id', $lc->idLocalizacao)
                ->count();

            $dados->addRow([$lc->localizacao, $qt]);
        }
        $qt = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
            ->where('enderecos.localizacao_id', null)
            ->count();
        if($qt > 0)
            $dados->addRow(["Não Informado", $qt]);
        return $dados;
    }

    /**
     * @param $uf
     * @return mixed
     */
    private function reportPidLocalizacaoByUf($uf)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localização')
            ->addNumberColumn('Qtd');

        $localizacoes = DB::table('localizacoes')->get();
        foreach($localizacoes as $lc) {
            $qt = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->whereIn('cidades.uf_id', $uf)
                ->where('enderecos.localizacao_id', $lc->idLocalizacao)
                ->count();

            $dados->addRow([$lc->localizacao, $qt]);
        }
        $qt = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->where('enderecos.localizacao_id', null)
            ->count();
        if($qt > 0)
            $dados->addRow(["Não Informado", $qt]);
        return $dados;
    }

    /**
     * @param $cidade
     * @return mixed
     */
    private function reportPidLocalizacaoByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localização')
            ->addNumberColumn('Qtd');

        $localizacoes = DB::table('localizacoes')->get();
        foreach($localizacoes as $lc) {
            $qt = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->where('cidades.idCidade', $cidade)
                ->where('enderecos.localizacao_id', $lc->idLocalizacao)
                ->count();

            $dados->addRow([$lc->localizacao, $qt]);
        }
        $qt = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->where('cidades.idCidade', $cidade)
            ->where('enderecos.localizacao_id', null)
            ->count();
        if($qt > 0)
            $dados->addRow(["Não Informado", $qt]);
        return $dados;
    }
/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportPidLocalidade(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportPidLocalidadeGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportPidLocalidadeByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportPidLocalidadeByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportPidLocalidadeByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportPidLocalidadeByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportPidLocalidadeByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportPidLocalidadeByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportPidLocalidadeByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else {
            $dados = $this->reportPidLocalidadeGeral();
            $graph = \Lava::PieChart('PidLocalidade')
                ->setOptions([
                    'datatable' => $dados,
                    'is3D' => true,
                    'slices' => [
                        \Lava::Slice(['offset' => 0.2])
                    ]
                ]);

            return $graph;
        }
    }

    /**
     * @return mixed
     */
    private function reportPidLocalidadeGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localidade')
            ->addNumberColumn('Qtd');

        $localizacoes = DB::table('localidades')->get();
        foreach($localizacoes as $lc) {
            $qt = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
                ->where('enderecos.localidade_id', $lc->idLocalidade)
                ->count();

            $dados->addRow([$lc->localidade, $qt]);
        }
        $qt = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
            ->where('enderecos.localidade_id', null)
            ->count();
        if($qt > 0)
            $dados->addRow(["Não Informado", $qt]);
        return $dados;
    }

    /**
     * @param $uf
     * @return mixed
     */
    private function reportPidLocalidadeByUf($uf)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localidade')
            ->addNumberColumn('Qtd');

        $localizacoes = DB::table('localidades')->get();
        foreach($localizacoes as $lc) {
            $qt = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->whereIn('cidades.uf_id', $uf)
                ->where('enderecos.localidade_id', $lc->idLocalidade)
                ->count();

            $dados->addRow([$lc->localidade, $qt]);
        }
        $qt = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->where('enderecos.localidade_id', null)
            ->count();
        if($qt > 0)
            $dados->addRow(["Não Informado", $qt]);
        return $dados;
    }

    /**
     * @param $cidade
     * @return mixed
     */
    private function reportPidLocalidadeByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localidade')
            ->addNumberColumn('Qtd');

        $localizacoes = DB::table('localidades')->get();
        foreach($localizacoes as $lc) {
            $qt = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->where('cidades.idCidade', $cidade)
                ->where('enderecos.localidade_id', $lc->idLocalidade)
                ->count();

            $dados->addRow([$lc->localidade, $qt]);
        }
        $qt = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=','enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->where('cidades.idCidade', $cidade)
            ->where('enderecos.localidade_id', null)
            ->count();
        if($qt > 0)
            $dados->addRow(["Não Informado", $qt]);
        return $dados;
    }
    /*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportPidServico(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportPidServicoGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportPidServicoByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportPidServicoByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportPidServicoByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportPidServicoByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportPidServicoByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportPidServicoByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportPidServicoByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else
        {
            $dados = $this->reportPidServicoGeral();
            $graph = \Lava::PieChart('PidServico')
                ->setOptions([
                    'datatable' => $dados,
                    'is3D' => true
                ]);
            return $graph;
        }
    }

    private function reportPidServicoGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Serviços')
            ->addNumberColumn('Qtd');

        $servicos = Servico::all();
        foreach($servicos as $sv) {
            $qt = Pid::whereHas('servicos', function($query) use ($sv){
                $query->where('idServico', $sv->idServico);
            })->count();

            $dados->addRow([$sv->servico, $qt]);
        }
        $dados->addRow(['Nenhum', Pid::has('servicos', '=', 0)->count()]);
        return $dados;
    }

    private function reportPidServicoByUf($uf)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Serviços')
            ->addNumberColumn('Qtd');

        $servicos = Servico::all();
        foreach($servicos as $sv) {
            $qt = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->whereIn('cidades.uf_id', $uf)
                ->whereRaw('pids.idPid IN (SELECT pid_id FROM pid_servicos WHERE servico_id ='.$sv->idServico.' )')
                ->count();

            $dados->addRow([$sv->servico, $qt]);
        }

        $qt = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->whereRaw('pids.idPid NOT IN (SELECT pid_id FROM pid_servicos)')
            ->count();
        $dados->addRow(['Nenhum', $qt]);
        return $dados;
    }

    private function reportPidServicoByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Serviços')
            ->addNumberColumn('Qtd');

        $servicos = Servico::all();
        foreach($servicos as $sv) {
            $qt = DB::table('pids')
                ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
                ->where('enderecos.cidade_id', $cidade)
                ->whereRaw('pids.idPid IN (SELECT pid_id FROM pid_servicos WHERE servico_id ='.$sv->idServico.' )')
                ->count();

            $dados->addRow([$sv->servico, $qt]);
        }

        $qt = DB::table('pids')
            ->join('enderecos', 'pids.endereco_id', '=', 'enderecos.idEndereco')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('pids.idPid NOT IN (SELECT pid_id FROM pid_servicos)')
            ->count();
        $dados->addRow(['Nenhum', $qt]);

        return $dados;
    }

/*---------------------------------------------------------------------------------------------------------------------*/

    /*FUNOÇÕES PARA INICIATIVAS*/

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexIniciativa()
    {
        if(!Cache::has('uf'))
            Cache::forever('uf', DB::table('uf')->orderBy('uf')->lists('uf','idUf'));
        $uf = Cache::get('uf');

        $iniciativaTipo = $this->reportIniciativaTipo();
        $iniciativaCategoria = $this->reportInicativaCategoria();
        $iniciativaLocalizacao = $this->reportIniciativaLocalizacao();
        $iniciativaDimensao = $this->reportIniciativaDimensao();
        $iniciativaInstituicao = $this->reportIniciativaInstituicao();

        return view('relatorios.iniciativa', compact('uf', 'iniciativaTipo', 'iniciativaCategoria',
            'iniciativaLocalizacao', 'iniciativaDimensao', 'iniciativaServico', 'iniciativaInstituicao'
        ));
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportIniciativaTipo(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportInicativaTipoGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportIniciativaTipoByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportIniciativaTipoByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportIniciativaTipoByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportIniciativaTipoByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportIniciativaTipoByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportIniciativaTipoByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportIniciativaTipoByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else {
            $dados = $this->reportInicativaTipoGeral();
            $graph = \Lava::BarChart('IniciativaTipos')
                ->setOptions([
                    'datatable' => $dados
                ]);

            return $graph;
        }
    }
    private function reportInicativaTipoGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Tipos')
            ->addNumberColumn('Qtd');
        $dados->addRow(['Total Iniciativas', Iniciativa::all()->count()]);

        $tipos = DB::table('iniciativaTipos')->get();
        foreach ($tipos as $tp) {
            $dados->addRow([$tp->tipo, Iniciativa::where('tipo_id', '=', $tp->idTipo)->count()]);
        }
        $aux = Iniciativa::where('tipo_id', '=', null)->count();
        if ($aux > 0)
            $dados->addRow(['Não Informado', $aux]);
        return $dados;
    }
    private function reportIniciativaTipoByUf($uf)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Tipos')
            ->addNumberColumn('Qtd');
        $qt = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->join('cidades', 'cidades.idCidade', '=', 'enderecos.cidade_id')
            ->whereIn('cidades.uf_id', $uf)
            ->count();
        $dados->addRow(['Total Iniciativas', $qt]);

        $tipos = DB::table('iniciativaTipos')->get();
        foreach ($tipos as $tp) {
            $qt = DB::table('iniciativas')
                ->where('iniciativas.tipo_id', $tp->idTipo)
                ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
                ->join('cidades', 'cidades.idCidade', '=', 'enderecos.cidade_id')
                ->whereIn('cidades.uf_id', $uf)
                ->count();

            $dados->addRow([$tp->tipo, $qt]);
        }
        $aux = DB::table('iniciativas')
            ->where('iniciativas.tipo_id', null)
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->join('cidades', 'cidades.idCidade', '=', 'enderecos.cidade_id')
            ->whereIn('cidades.uf_id', $uf)
            ->count();
        if ($aux > 0)
            $dados->addRow(['Não Informado', $aux]);
        return $dados;
    }
    private function reportIniciativaTipoByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Tipos')
            ->addNumberColumn('Qtd');

        $qt = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->count();
        $dados->addRow(['Total Iniciativas', $qt]);

        $tipos = DB::table('iniciativaTipos')->get();
        foreach ($tipos as $tp) {
            $qt = DB::table('iniciativas')
                ->where('iniciativas.tipo_id', $tp->idTipo)
                ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
                ->where('enderecos.cidade_id', $cidade)
                ->count();

            $dados->addRow([$tp->tipo, $qt]);
        }
        $aux = DB::table('iniciativas')
            ->where('iniciativas.tipo_id', null)
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->count();
        if ($aux > 0)
            $dados->addRow(['Não Informado', $aux]);
        return $dados;
    }
/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */

    public function reportInicativaCategoria(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportInicativaCategoriaGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportInicativaCategoriaByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportInicativaCategoriaByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportInicativaCategoriaByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportInicativaCategoriaByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportInicativaCategoriaByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportInicativaCategoriaByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportInicativaCategoriaByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else {
            $dados = $this->reportInicativaCategoriaGeral();

            $graph = \Lava::PieChart('IniciativaCategorias')
                ->setOptions([
                    'datatable' => $dados,
                    'is3D' => true,
                    'slices' => [
                        \Lava::Slice(['offset' => 0.2]),
                        \Lava::Slice(['offset' => 0.2]),
                    ]
                ]);
           // return $dados;
            return $graph;
        }
    }
    private function reportInicativaCategoriaGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Categorias')
            ->addNumberColumn('Qtd');

        $categorias = DB::table('iniciativaCategorias')->get();
        foreach($categorias as $ct) {
            $dados ->addRow([$ct->categoria, Iniciativa::where('categoria_id', '=', $ct->idCategoria)->count()]);
        }
        $aux = Iniciativa::where('categoria_id', '=', null)->count();
        if($aux > 0)
            $dados->addRow(['Não Informado', $aux]);
        return $dados;
    }
    private function reportInicativaCategoriaByUf($uf)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Categorias')
            ->addNumberColumn('Qtd');

        $categorias = DB::table('iniciativaCategorias')->get();
        foreach($categorias as $ct) {
            $qt = DB::table('iniciativas')
                ->where('iniciativas.categoria_id', $ct->idCategoria)
                ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
                ->join('cidades', 'cidades.idCidade', '=', 'enderecos.cidade_id')
                ->whereIn('cidades.uf_id', $uf)
                ->count();

            $dados->addRow([$ct->categoria, $qt]);
        }
        $aux = DB::table('iniciativas')
            ->where('iniciativas.categoria_id', null)
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->join('cidades', 'cidades.idCidade', '=', 'enderecos.cidade_id')
            ->whereIn('cidades.uf_id', $uf)
            ->count();
        if ($aux > 0)
            $dados->addRow(['Não Informado', $aux]);
        return $dados;
    }
    private function reportInicativaCategoriaByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Categoria')
            ->addNumberColumn('Qtd');

        $categorias = DB::table('iniciativaCategorias')->get();
        foreach($categorias as $ct) {
            $qt = DB::table('iniciativas')
                ->where('iniciativas.categoria_id', $ct->idCategoria)
                ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
                ->where('enderecos.cidade_id', $cidade)
                ->count();

            $dados->addRow([$ct->categoria, $qt]);
        }
        $aux = DB::table('iniciativas')
            ->where('iniciativas.categoria_id', null)
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->count();
        if ($aux > 0)
            $dados->addRow(['Não Informado', $aux]);
        return $dados;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportIniciativaLocalizacao(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportIniciativaLocalizacaoGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportIniciativaLocalizacaoByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportIniciativaLocalizacaoByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportIniciativaLocalizacaoByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportIniciativaLocalizacaoByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportIniciativaLocalizacaoByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportIniciativaLocalizacaoByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportIniciativaLocalizacaoByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else {
            $dados = $this->reportIniciativaLocalizacaoGeral();

            $graph = \Lava::PieChart('IniciativaLocalizacao')
                ->setOptions([
                    'datatable' => $dados,
                    'is3D' => true,
                    'slices' => [
                        \Lava::Slice(['offset' => 0.2])
                    ]
                ]);

            return $graph;
        }
    }
    private function reportIniciativaLocalizacaoGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localizacao')
            ->addNumberColumn('Qtd');

        $localizacoes = DB::table('localizacoes')->get();
        foreach($localizacoes as $lc) {
            $qt = DB::table('iniciativas')
                ->join('enderecos', 'iniciativas.endereco_id', '=','enderecos.idEndereco')
                ->where('enderecos.localizacao_id', $lc->idLocalizacao)
                ->count();

            $dados->addRow([$lc->localizacao, $qt]);
        }
        $qt = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=','enderecos.idEndereco')
            ->where('enderecos.localizacao_id', null)
            ->count();
        if($qt > 0)
            $dados->addRow(['Não Informado', $qt]);

        return $dados;
    }
    private function reportIniciativaLocalizacaoByUf($uf)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localizacao')
            ->addNumberColumn('Qtd');

        $localizacoes = DB::table('localizacoes')->get();
        foreach($localizacoes as $lc) {
            $qt = DB::table('iniciativas')
                ->join('enderecos', 'iniciativas.endereco_id', '=','enderecos.idEndereco')
                ->where('enderecos.localizacao_id', $lc->idLocalizacao)
                ->join('cidades', 'cidades.idCidade', '=', 'enderecos.cidade_id')
                ->whereIn('cidades.uf_id', $uf)
                ->count();

            $dados->addRow([$lc->localizacao, $qt]);
        }
        $aux = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=','enderecos.idEndereco')
            ->where('enderecos.localizacao_id', null)
            ->join('cidades', 'cidades.idCidade', '=', 'enderecos.cidade_id')
            ->whereIn('cidades.uf_id', $uf)
            ->count();
        if($aux > 0)
            $dados->addRow(['Não Informado', $aux]);

        return $dados;
    }
    private function reportIniciativaLocalizacaoByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localizacao')
            ->addNumberColumn('Qtd');

        $localizacoes = DB::table('localizacoes')->get();
        foreach($localizacoes as $lc) {
            $qt = DB::table('iniciativas')
                ->join('enderecos', 'iniciativas.endereco_id', '=','enderecos.idEndereco')
                ->where('enderecos.localizacao_id', $lc->idLocalizacao)
                ->where('enderecos.cidade_id', $cidade)
                ->count();

            $dados->addRow([$lc->localizacao, $qt]);
        }
        $aux = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=','enderecos.idEndereco')
            ->where('enderecos.localizacao_id', null)
            ->where('enderecos.cidade_id', $cidade)
            ->count();
        if($aux > 0)
            $dados->addRow(['Não Informado', $aux]);

        return $dados;
    }
/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportIniciativaDimensao(Request $request = null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportIniciativaDimensaoGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportIniciativaDimensaoByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportIniciativaDimensaoByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportIniciativaDimensaoByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportIniciativaDimensaoByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportIniciativaDimensaoByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportIniciativaDimensaoByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportIniciativaDimensaoByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else
        {
            $dados = $this->reportIniciativaDimensaoGeral();
            $graph = \Lava::PieChart('IniciativaDimensao')->setOptions(['datatable' => $dados, 'is3D' => true]);
            return $graph;
        }
    }

    private function reportIniciativaDimensaoGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Dimensões')
            ->addNumberColumn('Qtd');

        $dimensoes = Dimensao::all();
        foreach($dimensoes as $dm) {
            $qt = Iniciativa::whereHas('dimensoes', function($query) use ($dm){
                $query->where('idDimensao', $dm->idDimensao);
            })->count();

            $dados->addRow([$dm->dimensao, $qt]);
        }
        $dados->addRow(['Nenhum', Iniciativa::has('dimensoes', '=', 0)->count()]);
        return $dados;
    }

    private function reportIniciativaDimensaoByUf($uf)
    {

        $dados = \Lava::DataTable();
        $dados->addStringColumn('Dimensões')
            ->addNumberColumn('Qtd');

        $dimensoes = Dimensao::all();
        foreach($dimensoes as $dm) {
            $qt = DB::table('iniciativas')
                ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                ->whereIn('cidades.uf_id', $uf)
                ->whereRaw('iniciativas.idIniciativa IN (SELECT iniciativa_id FROM iniciativa_dimensoes WHERE dimensao_id ='.$dm->idDimensao.' )')
                ->count();

            $dados->addRow([$dm->dimensao, $qt]);
        }
        $qt = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
            ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->whereRaw('iniciativas.idIniciativa NOT IN (SELECT iniciativa_id FROM iniciativa_dimensoes)')
            ->count();
        $dados->addRow(['Nenhum', $qt]);
        return $dados;
    }

    private function reportIniciativaDimensaoByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Dimensões')
            ->addNumberColumn('Qtd');

        $dimensoes = Dimensao::all();
        foreach($dimensoes as $dm) {
            $qt = DB::table('iniciativas')
                ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                ->where('enderecos.cidade_id', $cidade)
                ->whereRaw('iniciativas.idIniciativa IN (SELECT iniciativa_id FROM iniciativa_dimensoes WHERE dimensao_id ='.$dm->idDimensao.' )')
                ->count();

            $dados->addRow([$dm->dimensao, $qt]);
        }

        $qt = DB::table('iniciativas')
            ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('iniciativas.idIniciativa NOT IN (SELECT iniciativa_id FROM iniciativa_dimensoes)')
            ->count();
        $dados->addRow(['Nenhum', $qt]);

        return $dados;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    public function reportIniciativaInstituicao(Request $request= null)
    {
        if($request != null) {
            switch($request['type']) {
                case 'geral':
                    return $this->reportIniciativaInstituicaoGeral()->toJson();
                    break;

                case 'regiao':
                    switch($request['regiao']) {
                        case 1:
                            return $this->reportIniciativaInstituicaoByUf([50, 51, 52, 53])->toJson();
                            break;

                        case 2:
                            return $this->reportIniciativaInstituicaoByUf([11, 12, 13, 14, 15, 16, 17])->toJson();
                            break;

                        case 3:
                            return $this->reportIniciativaInstituicaoByUf([21, 22, 23, 24, 25, 26, 27, 28, 29])->toJson();
                            break;

                        case 4:
                            return $this->reportIniciativaInstituicaoByUf([41, 42, 43])->toJson();
                            break;

                        case 5:
                            return $this->reportIniciativaInstituicaoByUf([31, 32, 33, 35])->toJson();
                            break;
                    }
                    break;

                case 'estado':
                    if($request['cidade'] != '') {
                        return $this->reportIniciativaInstituicaoByCidade($request['cidade'])->toJson();
                    }
                    else {
                        return $this->reportIniciativaInstituicaoByUf([$request['uf']])->toJson();
                    }
                    break;
            }
        }
        else
        {
            $dados = $this->reportIniciativaInstituicaoGeral();
            $graph = \Lava::ColumnChart('IniciativaInstituicao')
                ->setOptions([
                    'datatable' => $dados,
                    'legend' => \Lava::Legend([
                        'position' => 'top'
                    ])
                ]);
            return $graph;
        }
    }

    private function reportIniciativaInstituicaoGeral()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Instituição')
            ->addNumberColumn('Total')
            ->addNumberColumn('Apoiadoras')
            ->addNumberColumn('Mantenedoras');

        $ci = Iniciativa::has('instituicoes')->count();
        $si = Iniciativa::has('instituicoes', '=', 0)->count();
        $ip = Iniciativa::whereHas('instituicoes', function($query) {
            $query->where('tipoVinculo', 1);
        })->count();

        $im = Iniciativa::whereHas('instituicoes', function($query) {
            $query->where('tipoVinculo', 2);
        })->count();

        $dados->addRow(['C/ Instituições', $ci, $ip, $im]);
        $dados->addRow(['S/ Instituições', $si]);

        return $dados;
    }

    private function reportIniciativaInstituicaoByUf($uf)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Instituição')
            ->addNumberColumn('Total')
            ->addNumberColumn('Apoiadoras')
            ->addNumberColumn('Mantenedoras');

        //com
        $ci = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->join('cidades','enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereRaw('iniciativas.idIniciativa IN (SELECT iniciativa_id FROM iniciativa_instituicoes)')
            ->whereIn('cidades.uf_id', $uf)
            ->get();

        //sem
        $si = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->join('cidades','enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->whereRaw('iniciativas.idIniciativa NOT IN (SELECT iniciativa_id FROM iniciativa_instituicoes)')
            ->get();

        //apoiador
        $ip = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->join('cidades','enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->whereRaw('iniciativas.idIniciativa IN (SELECT iniciativa_id FROM iniciativa_instituicoes WHERE tipoVinculo = 1)')
            ->get();

        //mantenedor
        $im = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->join('cidades','enderecos.cidade_id', '=', 'cidades.idCidade')
            ->whereIn('cidades.uf_id', $uf)
            ->whereRaw('iniciativas.idIniciativa IN (SELECT iniciativa_id FROM iniciativa_instituicoes WHERE tipoVinculo = 2)')
            ->get();

        $dados->addRow(['C/ Instituições', count($ci), count($ip), count($im)]);
        $dados->addRow(['S/ Instituições', count($si)]);

        return $dados;
    }

    private function reportIniciativaInstituicaoByCidade($cidade)
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Instituição')
            ->addNumberColumn('Total')
            ->addNumberColumn('Apoiadoras')
            ->addNumberColumn('Mantenedoras');

        //com
        $ci = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('iniciativas.idIniciativa IN (SELECT iniciativa_id FROM iniciativa_instituicoes)')
            ->get();

        //sem
        $si = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('iniciativas.idIniciativa NOT IN (SELECT iniciativa_id FROM iniciativa_instituicoes)')
            ->get();

        //apoiador
        $ip = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('iniciativas.idIniciativa IN (SELECT iniciativa_id FROM iniciativa_instituicoes WHERE tipoVinculo = 1)')
            ->get();

        //mantenedor
        $im = DB::table('iniciativas')
            ->join('enderecos', 'enderecos.idEndereco', '=', 'iniciativas.endereco_id')
            ->where('enderecos.cidade_id', $cidade)
            ->whereRaw('iniciativas.idIniciativa IN (SELECT iniciativa_id FROM iniciativa_instituicoes WHERE tipoVinculo = 2)')
            ->get();

        $dados->addRow(['C/ Instituições', count($ci), count($ip), count($im)]);
        $dados->addRow(['S/ Instituições', count($si)]);

        return $dados;
    }
}
