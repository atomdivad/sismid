<?php

namespace SisMid\Models;

use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    protected $table = 'telefones';

    protected $primaryKey = 'idTelefone';

    protected $fillable = [
        'telefone',
        'responsavel',
        'telefone_tipo_id'
    ];

    protected $guarded = ['idTelefone'];

    public $timestamps = false;


    /**
     * Relacionamento many to many
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function instituicao()
    {
        return $this->belongsToMany('SisMid\Gestao\Telefone', 'instituicao_telefones', 'idInstituicao', 'idTelefone');
    }


    /**
     * Relacionamento many to many
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pid()
    {
        return;
    }


}
