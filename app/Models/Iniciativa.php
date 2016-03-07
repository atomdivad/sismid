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
        return $this->belongsToMany('SisMid\Models\Telefone', 'iniciativa_telefones', 'iniciativa_id', 'telefone_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dimensoes()
    {
        return $this->belongsToMany('SisMid\Models\Dimensao', 'iniciativa_dimensoes', 'iniciativa_id', 'dimensao_id');
    }

    /**
     * @return $this
     */
    public function instituicoes()
    {
        return $this->belongsToMany('SisMid\Models\Instituicao', 'iniciativa_instituicoes', 'iniciativa_id', 'instituicao_id')
            ->withPivot('tipoVinculo');
    }
}
