<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tramite_instancia extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Modelo Tramite_instancia
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona las instancias con su campo y su trámite.
    |
    */

    protected $table = 'tramites_instancias';

    public function tramite()
    {
        return $this->belongsTo('App\Tramite', 'id_tramite');
    }

    public function campo()
    {
        return $this->belongsTo('App\Tramite_campo', 'id_campo');
    }
}
