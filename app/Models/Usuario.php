<?php

namespace SisMid\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Artesaos\Defender\Traits\HasDefender;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laracasts\Presenter\PresentableTrait;

class Usuario extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasDefender, PresentableTrait;

    /**
     * The class presenter for model user.
     *
     * @var string
     */
    protected $presenter = 'SisMid\Presenters\UsuarioPresenter';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * The primary key of table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'idUsuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'sobrenome', 'email', 'password', 'iniciativa_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at'];

    public function iniciativa()
    {
        return $this->belongsTo('SisMid\Models\Iniciativa');
    }

    public function instituicao()
    {
        return $this->hasMany('SisMid\Models\Instituicao');
    }
}
