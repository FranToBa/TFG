<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asistencia;

class AsistenciaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Asistencia Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador es el encargado de controlar las funciones
    | asociadas a la asistencia de los usuarios a los eventos.
    |
    */

    /**
    * Crea una nueva asistencia con los datos pasados como argumento.
     *
     * @param Request $request información de formulario
     * @return route 'evento.ver/{id_evento}'
    */
    public function anadirAsistencia(Request $request)
    {
        $asistencia = new Asistencia;
        $asistencia->evento_id = $request->input('id_evento');
        $asistencia->id_usuario = $request->input('id_usuario');
        $asistencia->save();
        return redirect()->route('evento.ver', [$request->input('id_evento')])
                         ->with(['mensaje'=>"Asistencia confirmada"]);
    }

    /**
     * Obtiene la asistencia por el identificador de evento y usuario y la borra.
     *
     * @param String $id_evento identificador de evento
     * @param String $id_usuario identificador de usuario
     * @return route 'evento.ver/{id_evento}'
    */
    public function borrarAsistencia($id_evento, $id_usuario)
    {
        $asistencia = Asistencia::where('evento_id', $id_evento)->where('id_usuario', $id_usuario)->first();
        $asistencia->delete();
        return redirect()->route('evento.ver', [$id_evento])
                         ->with(['mensaje'=>"Asistencia eliminada"]);
    }
}
