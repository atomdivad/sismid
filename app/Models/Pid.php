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
        'tipo_id',
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
        return $this->belongsToMany('SisMid\Models\Telefone', 'pid_telefones', 'pid_id', 'telefone_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function instituicoes()
    {
        return $this->belongsToMany('SisMid\Models\Instituicao', 'pid_instituicoes', 'pid_id', 'instituicao_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function iniciativas()
    {
        return $this->belongsToMany('SisMid\Models\Iniciativa', 'pid_iniciativas', 'pid_id', 'iniciativa_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fotos()
    {
        return$this->hasMany('SisMid\Models\Foto');
    }
}
