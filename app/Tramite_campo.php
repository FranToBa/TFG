<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tramite_campo extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Modelo Tramite_campo
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona los campos con su trámite.
    |
    */

    protected $table = 'tramites_campos';

    public function notificacion()
    {
        return $this->hasMany('App\Tramite_instancia');
    }
}
