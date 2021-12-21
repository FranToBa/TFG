<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Modelo Evento
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona los eventos con la asistencia.
    |
    */

    protected $table = 'eventos';

    public function asistencia()
    {
        return $this->hasMany('App\Asistencia');
    }
}
