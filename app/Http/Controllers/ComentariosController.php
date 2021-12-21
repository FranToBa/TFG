<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comentario;

class ComentariosController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Comentarios Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador es el encargado de controlar las funciones
    | asociadas a los comentarios de los usuarios en las noticias.
    |
    */

    /**
     * Crea una nueva comentario con los datos pasados como argumento.
     * Si el comentario es de un usuario, se guarda su identificador.
     *
     * @param Request $request información de formulario
     * @return route 'noticia.ver/{id_noticia}'
    */
    public function guardarComentario(Request $request)
    {
        $comentario = new Comentario;
        $comentario->noticia_id = $request->input('noticia_id');
        $comentario->comentario = $request->input('comentario');
        if (\Auth::user()) {
            $comentario->id_usuario=\Auth::user()->id;
        }
        $comentario->save();
        return redirect()->route('noticia.ver', [$request->input('noticia_id')])
                         ->with(['mensaje'=>"Comentario insertado"]);
    }

    /**
     * Busca el comentario por su identificador y lo borra.
     *
     * @param String $id identificador de noticia
     * @return route 'noticia.ver/{id_noticia}'
    */
    public function borrarComentario($id)
    {
        $comentario = Comentario::find($id);
        $id_noticia = $comentario->noticia->id;
        $comentario->delete();
        return redirect()->route('noticia.ver', [$id_noticia])
                         ->with(['mensaje'=>"Comentario borrado"]);
    }
}
