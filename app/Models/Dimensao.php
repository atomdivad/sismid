<?php

namespace SisMid\Models;

use Illuminate\Database\Eloquent\Model;

class Dimensao extends Model
{
    protected $table = 'dimensoes';

    protected $primaryKey = 'idDimensao';

    protected $fillable = [
        'dimensao'
    ];

    public $timestamps = false;

    public function iniciativa()
    {
        return $this->belongsToMany('SisMid\Models\Iniciativa', 'iniciativa_dimensoes', 'idIniciativa', 'idDimesao');
    }
}
