<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Modelo Comentario
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona los comentarios con usuarios y noticias.
    |
    */

    protected $table = 'comentarios';

    public function noticia()
    {
        return $this->belongsTo('App\Noticia', 'noticia_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\User', 'id_usuario');
    }
}
