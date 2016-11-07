<?php

namespace SisMid\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use SisMid\Models\Pid;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pidStatus = $this->reportPidStatus();
        $review = DB::table('pid_revisao')->where('valido', 1)->count();
        return view('home', compact('pidStatus', 'review'));
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
            ->orderBy('submetido', 'desc')
            ->orderBy('pid_revisao.created_at', 'desc')
            ->take(25)
            ->get();
        return $pids;
    }

    public function reportPidStatus()
    {
        $dados = $this->reportPidStatusGeral();
        $graph = \Lava::BarChart('PidStatus')->setOptions([
            'datatable' => $dados
        ]);
        return $graph;
    }

    private function reportPidStatusGeral()
    {
        $sql = 'SELECT COUNT(idPid) AS total FROM pids WHERE (updated_at NOT BETWEEN "'.Carbon::now()->subMonth(1).'" AND "'.Carbon::now().'") AND idPid NOT IN (SELECT DISTINCT pid_id FROM pid_revisao)';
        $total = DB::select($sql)[0]->total;;

        $sql2 = 'SELECT COUNT(DISTINCT idPid) AS total FROM pids WHERE (updated_at BETWEEN "'.Carbon::now()->subMonth(1).'" AND "'.Carbon::now().'") OR idPid IN (SELECT DISTINCT pid_id FROM pid_revisao)';
        $atualizados = DB::select($sql2)[0]->total;

        $revisao = DB::select('SELECT COUNT(DISTINCT pid_id) AS total FROM pid_revisao')[0]->total;

        $dados = \Lava::DataTable();
        $dados->addStringColumn('Status');
        $dados->addNumberColumn('Qtd');
        $dados->addRow(['Não Revisados', $total]);
        $dados->addRow(['Revisados', $atualizados]);
        $dados->addRow(['Em Revisão', $revisao]);
        return $dados;
    }
}
