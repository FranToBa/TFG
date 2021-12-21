<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queja extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Modelo Queja
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona las quejas con los usuarios,
    |
    */

    protected $table = 'quejas';

    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }
}
