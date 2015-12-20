<?php

namespace SisMid\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pid extends Model
{
    use SoftDeletes;

    protected $table = 'pids';

    protected $primaryKey = 'idPid';

    protected $fillable = [
        'nome',
        'email',
        'url',
        'endereco_id'
    ];

    protected $guarded = [
        'idPid',
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
        return $this->belongsToMany('SisMid\Models\Telefone', 'pid_telefones', 'idPid', 'idTelefone');
    }
}
