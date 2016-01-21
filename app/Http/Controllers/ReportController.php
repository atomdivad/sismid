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

        return view('relatorios.pid', compact('uf', 'pidStatus', 'pidTipo', 'pidIniciativa', 'pidInstituicao',
            'pidLocalizcao', 'pidLocalidade'
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

        $dados->addRow(['C/ Instituições', $ci]);
        $dados->addRow(['S/ Instituições', $si]);
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

    /*FUNOÇÕES PARA INICIATIVAS*/

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexIniciativa()
    {
        if(!Cache::has('uf'))
            Cache::forever('uf', DB::table('uf')->orderBy('uf')->lists('uf','idUf'));
        $uf = Cache::get('uf');

        $iniciativaTipo = $this->reportInicativaTipo();
        $iniciativaCategoria = $this->reportInicativaCategoria();
        $iniciativaNatureza = $this->reportInicativaNatureza();
        $iniciativaLocalizacao = $this->reportIniciativaLocalizacao();
        $iniciativaDimensao = $this->reportIniciativaDimensao();
        $iniciativaServico = $this->reportIniciativaServico();
        $iniciativaInstituicao = $this->reportIniciativaInstituicao();

        return view('relatorios.iniciativa', compact('uf', 'iniciativaTipo', 'iniciativaCategoria', 'iniciativaNatureza',
            'iniciativaLocalizacao', 'iniciativaDimensao', 'iniciativaServico', 'iniciativaInstituicao'
        ));
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    private function reportInicativaTipo()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Tipos')
            ->addNumberColumn('Qtd');
        $dados->addRow(['Total Iniciativas', Iniciativa::all()->count()]);

        $tipos = DB::table('iniciativaTipos')->get();
        foreach($tipos as $tp) {
            $dados ->addRow([$tp->tipo, Iniciativa::where('tipo_id', '=', $tp->idTipo)->count()]);
        }
        $aux = Iniciativa::where('tipo_id', '=', null)->count();
        if($aux > 0)
            $dados->addRow(['Não Informado', $aux]);

        $graph = \Lava::BarChart('InicativaTipos')
            ->setOptions([
                'datatable' => $dados
            ]);

        return $graph;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    private function reportInicativaCategoria()
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

        $graph = \Lava::PieChart('InicativaCategorias')
            ->setOptions([
                'datatable' => $dados,
                'is3D' => true,
                'slices' => [
                    \Lava::Slice(['offset' => 0.2]),
                    \Lava::Slice(['offset' => 0.2]),
                ]
            ]);

        return $graph;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    private function reportInicativaNatureza()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Natureza Jurídica')
            ->addNumberColumn('Qtd');

        $naturezas = DB::table('naturezasJuridicas')->get();
        foreach($naturezas as $nt) {
            $dados->addRow([$nt->naturezaJuridica, Iniciativa::where('naturezaJuridica_id', '=', $nt->idNatureza)->count()]);
        }
        $aux = Iniciativa::where('naturezaJuridica_id', '=', null)->count();
        if($aux > 0)
            $dados->addRow(['Não Informado', $aux]);

        $graph = \Lava::PieChart('InicativaNaturezas')
            ->setOptions([
                'datatable' => $dados,
                'is3D' => true,
                'slices' => [
                    \Lava::Slice(['offset' => 0.2]),
                    \Lava::Slice(['offset' => 0.2]),
                ]
            ]);

        return $graph;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    private function reportIniciativaLocalizacao()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Localização')
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

        $graph = \Lava::PieChart('IniciativaLocalizcao')
            ->setOptions([
                'datatable' => $dados,
                'is3D' => true,
                'slices' => [
                    \Lava::Slice(['offset' => 0.2])
                ]
            ]);

        return $graph;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    private function reportIniciativaDimensao()
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

        $graph = \Lava::PieChart('IniciativaDimensao')
            ->setOptions([
                'datatable' => $dados,
                'is3D' => true,
            ]);

        return $graph;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    private function reportIniciativaServico()
    {
        $dados = \Lava::DataTable();
        $dados->addStringColumn('Serviços')
            ->addNumberColumn('Qtd');

        $servicos = Servico::all();
        foreach($servicos as $sv) {
            $qt = Iniciativa::whereHas('servicos', function($query) use ($sv){
                $query->where('idServico', $sv->idServico);
            })->count();

            $dados->addRow([$sv->servico, $qt]);
        }
        $dados->addRow(['Nenhum', Iniciativa::has('servicos', '=', 0)->count()]);

        $graph = \Lava::PieChart('IniciativaServico')
            ->setOptions([
                'datatable' => $dados,
                'is3D' => true
            ]);

        return $graph;
    }

/*---------------------------------------------------------------------------------------------------------------------*/
    /**
     * @return mixed
     */
    private function reportIniciativaInstituicao()
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
