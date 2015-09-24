<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Retorna as cidades de uma UF
     *
     * @param $idUf
     */
    public function getCidades($idUf)
    {
        $cidades = DB::table('cidades')
            ->where('uf_id', '=', $idUf)
            ->orderBy('nomeCidade')
            ->get();

        return $cidades;
    }
}
