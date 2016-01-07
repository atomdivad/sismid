<?php

namespace SisMid\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'fotos';

    protected $primaryKey = 'idFoto';

    protected $fillable = [
        'nome',
        'arquivo',
    ];

    protected $guarded = [
        'idFoto',
        'pid_id',
    ];

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pid()
    {

        return $this->belongsTo('SisMid\Models\Pid');
    }
}
