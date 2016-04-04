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
        'telefoneTipo_id'
    ];

    protected $guarded = ['idTelefone'];

    public $timestamps = false;

    protected $hidden = ['pivot'];


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
        return $this->belongsToMany('SisMid\Models\Pid', 'pid_telefones', 'pid_id', 'telefone_id');
    }


}
