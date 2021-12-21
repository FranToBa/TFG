<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Modelo Tramite
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona los tramites con su usuario
    | y las instancias de sus campos.
    |
    */

    /**
     * Tabla de nuestra base de datos correspondiente a este controlador.
    */
    protected $table = 'tramites';

    /**
     * Relación entre un trámite y el usuario que lo realiza.
    */
    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }

    /**
     * Relación entre un trámite y las instancias de sus campos.
    */
    public function tramites_instancias()
    {
        return $this->hasMany('App\Tramite_instancia');
    }
}
