<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Queja;
use App\Notificacion;

class QuejasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Quejas Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador es el encargado de insertar nuevas quejas.
    |
    */

    /**
     * Realiza una nueva queja con los datos pasados por param.
     * Si la queja es de un usuario identificado, manda notificación
     *
     * @param Request $request información de formulario
     * @return route back
    */
    public function guardarQueja(Request $request)
    {
        $queja = new Queja;
        $queja->queja = $request->input('queja');
        //Si usuario identificado, crear notifiación
        if (\Auth::user()) {
            $queja->id_usuario=\Auth::user()->id;
            $notificacion = new Notificacion;
            $notificacion->id_usuario = \Auth::user()->id;
            $notificacion->tipo = "Queja/Sugerencia";
            $notificacion->descripcion = $request->input('queja');
            $notificacion->respuesta = "Queja enviada.";
            $notificacion->save();
        }
        $queja->save();
        return redirect()->back()
                         ->with(['mensaje_queja'=>"Queja enviada con éxito"]);
    }
}
