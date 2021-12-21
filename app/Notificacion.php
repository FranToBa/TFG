<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Modelo Notificación
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona las notificaciones con los usuarios.
    |
    */

    protected $table = 'notificaciones';

    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }
}
