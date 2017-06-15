<?php

namespace App\App\Entities;

use Variable;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, UserStamps;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password','perfil_id','persona_id','primera_vez','estado'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function ciclo()
    {
        return $this->belongsTo(Ciclo::class);
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    protected function setPasswordAttribute($value)
    {
        if( ! empty($value) )
        {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function getDescripcionEstadoAttribute()
    {
        return Variable::getEstadoGeneral($this->estado);
    }
}
