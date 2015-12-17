<?php

namespace SisMid\Models;

use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
    use SoftDeletes;

    protected $table = 'instituicoes';

    protected $primaryKey = 'idInstituicao';

    protected $fillable = [
        'nome',
        'endereco_id',
        'naturezaJuridica_id',
        'email',
        'url'
    ];

    protected $guarded = [
        'idInstituicao',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


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
        return $this->belongsToMany('SisMid\Gestao\Telefone', 'instituicao_telefones', 'idInstituicao', 'idTelefone');
    }
}