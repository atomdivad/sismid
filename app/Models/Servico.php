<?php

namespace SisMid\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'servicos';

    protected $primaryKey = 'idServico';

    protected $fillable = [
        'servico'
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function iniciativa()
    {
        return $this->belongsToMany('SisMid\Models\Iniciativa', 'iniciativa_servicos', 'idIniciativa', 'idServico');
    }
}
