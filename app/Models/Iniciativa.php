<?php

namespace SisMid\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Iniciativa extends Model
{
    use SoftDeletes;

    protected $table = 'iniciativas';

    protected $primaryKey = 'idIniciativa';

    protected $fillable = [
        'tipo_id',
        'nome',
        'sigla',
        'endereco_id',
        'naturezaJuridica_id',
        'email',
        'url',
        'objetivo',
        'informacaoComplementar',
        'categoria_id',
        'fonte'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = ['idIniciativa'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function endereco()
    {
        return $this->belongsTo('SisMid\Models\Endereco');
    }


    /**
     * Relacionamento many to many
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function telefones()
    {
        return $this->belongsToMany('SisMid\Models\Telefone', 'inicativa_telefones', 'iniciativa_id', 'telfone_id');
    }

    public function servicos()
    {
        return $this->belongsToMany('SisMid\Models\Servico', 'iniciativa_servicos', 'iniciativa_id', 'servico_id');
    }

    public function dimensoes()
    {
        return $this->belongsToMany('SisMid\Models\Dimensao', 'iniciativa_dimensoes', 'iniciativa_id', 'dimensao_id');
    }
}
