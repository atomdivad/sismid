<?php

namespace SisMid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisMid\Http\Requests;
use SisMid\Http\Controllers\Controller;
use SisMid\Models\Instituicao;

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

    public function getInstituicoes(Request $request)
    {
        $nome = $request['nome'];
        $uf = $request['uf'];
        $cidade = $request['cidade_id'];

        //return [$nome, $uf, $cidade];
        $instituicoes = [];

        if($nome != '') {
            if($uf != 0) {
                if($cidade != 0) {
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('instituicoes.nome', 'like', "%$nome%")
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();
                }
                else {
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('instituicoes.nome', 'like', "%$nome%")
                        ->where('uf.idUf', '=', $uf)
                        ->get();
                }
            }
            else {
                $instituicoes = DB::table('instituicoes')
                    ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->where('instituicoes.nome', 'like', "%$nome%")
                    ->get();
            }
        }
        else {
            if($uf != 0) {
                if($cidade != 0) {
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();
                }
                else {
                    $instituicoes = DB::table('instituicoes')
                        ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('uf.idUf', '=', $uf)
                        ->get();
                }
            }
            else {
                $instituicoes = DB::table('instituicoes')
                    ->join('enderecos', 'instituicoes.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('instituicoes.idInstituicao','instituicoes.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->get();
            }
        }

        return $instituicoes;
    }

    public function getIniciativas(Request $request)
    {
        $nome = $request['nome'];
        $uf = $request['uf'];
        $cidade = $request['cidade_id'];

        $iniciativas = [];

        if($nome != '') {
            if($uf != 0) {
                if($cidade != 0) {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('iniciativas.nome', 'like', "%$nome%")
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();
                }
                else {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('iniciativas.nome', 'like', "%$nome%")
                        ->where('uf.idUf', '=', $uf)
                        ->get();
                }
            }
            else {
                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->where('iniciativas.nome', 'like', "%$nome%")
                    ->get();
            }
        }
        else {
            if($uf != 0) {
                if($cidade != 0) {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('cidades.idCidade', '=', $cidade)
                        ->get();
                }
                else {
                    $iniciativas = DB::table('iniciativas')
                        ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                        ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                        ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                        ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                        ->where('uf.idUf', '=', $uf)
                        ->get();
                }
            }
            else {
                $iniciativas = DB::table('iniciativas')
                    ->join('enderecos', 'iniciativas.endereco_id', '=', 'enderecos.idEndereco')
                    ->join('cidades', 'enderecos.cidade_id', '=', 'cidades.idCidade')
                    ->join('uf', 'cidades.uf_id', '=', 'uf.idUf')
                    ->select('iniciativas.idIniciativa','iniciativas.nome', 'cidades.nomeCidade', 'uf.uf')
                    ->get();
            }
        }

        return $iniciativas;
    }
}
