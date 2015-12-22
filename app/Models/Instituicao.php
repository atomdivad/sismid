<?php

namespace SisMid\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->belongsToMany('SisMid\Models\Telefone', 'instituicao_telefones', 'idInstituicao', 'idTelefone');
    }

    public function iniciativa()
    {
        return $this->belongsToMany('SisMid\Models\Iniciativa', 'iniciativa_instituicoes', 'iniciativa_id', 'instituicao_id')
            ->withPivot('tipoVinculo');
    }
}