<?php

namespace SisMid\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $table = 'enderecos';

    protected $primaryKey = 'idEndereco';

    protected $fillable = [
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade_id',
        'latitude',
        'longitude',
        'localidade_id',
        'localizacao_id'
    ];

    protected $guarded = ['idEndereco'];

    protected $dates = ['created_at', 'updated_at'];

    public function pid()
    {
        return $this->hasOne('SisMid\Models\Pid');
    }

    public function instituicao()
    {
        return $this->hasOne('SisMid\Models\Instituicao');
    }

    public function iniciativa()
    {
        return $this->hasOne('SisMid\Models\Iniciativa');
    }
}
