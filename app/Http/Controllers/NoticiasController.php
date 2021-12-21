<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Noticia;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Comentario;

class NoticiasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Noticias Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador es el encargado de controlar las funciones
    | de vista, inserción, modificación y borrado de noticias
    |
    */

    /**
     * Obtiene las noticias paginadas y las devuelve a la vista de noticias
     *
     * @return view 'noticias.noticias_index'
    */
    public function index()
    {
        $noticias = Noticia::orderby('id', 'desc')->paginate(4);
        return view('noticias.noticias_index')
               ->with('noticias', $noticias);
    }

    /**
     * Obtiene de disco la imagen asociada al nombre pasado por param.
     *
     * @param String $filename nombre de la imagen a buscar
     * @return Response $foto devuelve la imagen con código 200.
    */
    public function getImage($filename)
    {
        $foto = Storage::disk('noticias')->get($filename);
        return new Response($foto, 200);
    }

    /**
     * Busca el evento asociado al identificador pasado por param.
     * Obtiene los comentarios de la noticia
     * y los devuelve junto a la noticia a la vista.
     *
     * @param String $id identificador de noticia
     * @return view 'noticias.noticias_ver'
    */
    public function vernoticia($id)
    {
        $noticia = Noticia::find($id);
        $comentarios = Comentario::orderby('id', 'desc')->where('noticia_id', $id)->paginate(3);
        return view('noticias.noticias_ver')
               ->with('noticia', $noticia)
               ->with('comentarios', $comentarios);
    }
    
}
