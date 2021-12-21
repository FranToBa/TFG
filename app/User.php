<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /*
    |--------------------------------------------------------------------------
    | Modelo User
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona los usuarios con sus tramites, notificaciones,
    | comentarios, asistencias y noticias.
    |
    */

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'apellidos', 'telefono', 'tipo', 'dni','direccion','foto'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function comentarios()
    {
        return $this->hasMany('App\Comentario');
    }

    public function noticias()
    {
        return $this->hasMany('App\Noticia');
    }

    public function tramites()
    {
        return $this->hasMany('App\Tramite');
    }

    public function notificaciones()
    {
        return $this->hasMany('App\Notificacion');
    }

    public function asistencia()
    {
        return $this->hasMany('App\Asistencia');
    }
}
