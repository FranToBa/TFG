<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Noticia extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Modelo Noticia
    |--------------------------------------------------------------------------
    |
    | Modelo que relaciona las noticias con su autor y los comentarios
    |
    */

    protected $table = 'noticias';

    public function comentarios()
    {
        return $this->hasMany('App\Comentario');
    }

    public function autor()
    {
        return $this->belongsTo('App\User', 'id_autor');
    }
}
