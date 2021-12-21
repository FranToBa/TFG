<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Modelo Asistencia
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona la asistencia con usuarios y eventos.
    |
    */

    protected $table = 'asistencia';

    public function evento()
    {
        return $this->belongsTo('App\Evento', 'evento_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }
}
