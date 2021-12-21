<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tramite;
use App\Tramite_campo;
use App\Tramite_instancia;
use App\Notificacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TramitesController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Tramites Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador es el encargado de controlar las funcionas asociadas
    | a los trámites realizados por usuarios identificados.
    |
    */

    /**
     * Obtiene los diferentes tipos de formularios
     * y los devuelve a la vista de elección de trámite.
     *
     * @return view 'tramites.tramites_index'
    */
    public function elegirForm()
    {
        $formularios = Tramite_campo::select('tipo')->distinct()->get();
        return view('tramites.tramites_index')
               ->with('formularios', $formularios);
    }

    /**
     * Obtiene los campos del formulario
     * y los devuelve a la vista encargada de presentarlos.
     *
     * @param Request $request información de formulario
     * @return view 'tramites.form_tramites'
    */
    public function presentarForm(Request $request)
    {
        $campos = Tramite_campo::where('tipo', $request->input('formularios'))->get();
        return view('tramites.form_tramites')
               ->with('tipo', $request->input('formularios'))
               ->with('campos', $campos);
    }

    /**
     * Crea un nuevo tramite con los datos y el tipo pasado por param.
     * Obtiene los campos de ese tipo de formulario y crea las instancias
     * asociadas a estos campos con los datos pasados por param.
     * Se envía una notifiación al usuario sobre el trámite.
     *
     * @param Request $request información de formulario
     * @return route 'tramites'
    */
    public function guardarTramite(Request $request)
    {
        //Creación de trámite
        $tramite = new Tramite;
        $tramite->id_usuario = \Auth::user()->id;
        $tramite->tipo = $request->input('tipo');
        $tramite->save();
        //Obtención de los campos del formulario
        $campos= Tramite_campo::where('tipo', $request->input('tipo'))->get();
        //Para cada campo, asignamos el valor pasado en el formulario
        foreach ($campos as $campo) {
            if ($campo->nombre_campo != "Documentación") {
                $campoInstancia = new Tramite_instancia;
                $campoInstancia->tramite_id = $tramite->id;
                $campoInstancia->id_campo = $campo->id;
                $campoInstancia->valor = $request->input($campo->id);
                $campoInstancia->save();
            /* Si el campo es el de documentación y se ha insertado documento,
            se guarda el documento en disco y se crea una instancia asociada. */
            } else {
                if ($request->hasFile("documento")) {
                    $file=$request->file("documento");
                    $nombre = "pdf_".time().".".$file->guessExtension();
                    if ($file->guessExtension()=="pdf") {
                        Storage::disk('tramites')->put($nombre, File::get($file));
                        $campoInstancia = new Tramite_instancia;
                        $campoInstancia->tramite_id = $tramite->id;
                        $campoInstancia->id_campo = $campo->id;
                        $campoInstancia->valor = $nombre;
                        $campoInstancia->save();
                    }
                }
            }
        }
        //Creación de notificación asociada al nuevo trámite.
        $notificacion = new Notificacion;
        $notificacion->id_usuario = $tramite->id_usuario;
        $notificacion->tipo = "Trámite";
        $notificacion->descripcion = $tramite->tipo;
        $notificacion->respuesta = "Trámite registrado. Puede consultar su estado en la sección de sus trámites.";
        $notificacion->save();
        return redirect()->route('tramites')
                         ->with(['mensaje'=>"Trámite enviado con éxito"]);
    }
}
