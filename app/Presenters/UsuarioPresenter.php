<?php

namespace SisMid\Presenters;


use SisMid\Presenters\BasePresenter;

class UsuarioPresenter extends BasePresenter
{
    public function nomeCompleto()
    {
        return $this->nome.' '.$this->sobrenome;
    }

}