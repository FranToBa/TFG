<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Evento;
use App\Asistencia;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EventosController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Eventos Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador es el encargado de controlar las funciones
    | de vista, inserción, modificación y borrado de eventos.
    |
    */

    /**
     * Obtiene los eventos paginados y los devuelve a la vista de eventos.
     *
     * @return view 'eventos.eventos_index'
    */
    public function index()
    {
        $eventos = Evento::orderby('fecha', 'desc')->paginate(4);
        return view('eventos.eventos_index')
               ->with('eventos', $eventos);
    }

    /**
     * Obtiene de disco la imagen asociada al nombre pasado por param.
     *
     * @param String $filename nombre de la imagen a buscar
     * @return Response $foto devuelve la imagen con código 200.
    */
    public function getImage($filename)
    {
        $foto = Storage::disk('eventos')->get($filename);
        return new Response($foto, 200);
    }

    /**
     * Busca el evento asociado al identificador pasado por param.
     * Comprueba si el usuario actual ya ha registrado su asistencia y el aforo.
     * Devuelve la vista con el evento y los datos de asistencia.
     *
     * @param String $id identificador de evento
     * @return view 'eventos.eventos_ver'
    */
    public function verEvento($id)
    {
        $evento = Evento::find($id);
        // Comprobamos si hay asistencia del usuario actual a este evento
        $asistente=false;
        if (\Auth::user() && Asistencia::where('evento_id', $id)->where('id_usuario', \Auth::user()->id)->first()) {
            $asistente = true;
        }
        //Comprobamos el aforo
        $num_asistentes = Asistencia::where('evento_id', $id)->count();
        $aforo_maximo=true;
        if ($evento->aforo >$num_asistentes) {
            $aforo_maximo=false;
        }
        return view('eventos.eventos_ver')
               ->with('evento', $evento)
               ->with('num_asistentes', $num_asistentes)
               ->with('aforo_max', $aforo_maximo)
               ->with('asistente', $asistente);
    }

}
