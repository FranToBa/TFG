<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Pagination\Paginator;
use App\Comentario;
use App\Noticia;
use App\Asistencia;
use App\Queja;
use App\Tramite;
use App\Notificacion;
use App\Tramite_campo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Admin Controller
  |--------------------------------------------------------------------------
  |
  | Este controlador es el encargado de controlar las funciones
  | que requieren permisos de administrador.
  |
  */


    /**
     * Obtener los usuarios y devolverlos a la vista de gestión de usuarios
     *
     * @return view 'admin.gestion_usuarios'
    */
    public function gestionUsuarios()
    {
        $usuarios = User::orderby('id', 'desc')->get();
        return view('admin.gestion_usuarios')
             ->with('usuarios', $usuarios);
    }

    /**
     * Filtra los usuarios a partir de la búsqueda introducida
     * y los devuelve a la vista de búsqueda de usuario.
     *
     * @param Request $request información de formulario
     * @return view 'admin.busqueda_usuario'
    */
    public function filtroUsuarios(Request $request)
    {
        //Comprobamos el tipo de usuario introducido y buscamos en bd
        if ($request->texto == "") {
            if ($request->texto_tipo=="todos") {
                $usuarios = User::orderby('id', 'desc')->get();
            } else {
                $usuarios = User::where("tipo", $request->texto_tipo)->orderby('id', 'desc')->get();
            }
            //Comprobamos el tipo de usuario introducido y el dni y buscamos en bd
        } else {
            if ($request->texto_tipo=="todos") {
                $usuarios = User::where("dni", "like", $request->texto."%")->orderby('id', 'desc')->get();
            } else {
                $usuarios = User::where("dni", "like", $request->texto."%")->where("tipo", $request->texto_tipo)->orderby('id', 'desc')->get();
            }
        }
        return view('admin.busqueda_usuario')
               ->with('usuarios', $usuarios);
    }

    /**
     * Buca el usuario con el identificador y lo borra (también su imagen)
     *
     * @param String $id identificador de usuario
     * @return route 'admin.usuarios'
    */
    public function borrarUsuario($id)
    {
        $usuario = User::find($id);
        //Borar imagen de disco
        if ($usuario->foto != 'sinfoto.png') {
            Storage::disk('users')->delete($usuario->foto);
        }
        $usuario->delete();
        return redirect()->route('admin.usuarios')
                         ->with('mensaje', 'Usuario borrado con éxito');
    }

    /**
     * Buca el usuario con el identificador y actualiza su tipo al
     * pasado como argumento.
     *
     * @param String $id identificador de usuario
     * @param String $tipo tipo de usuario
     * @return route 'admin.usuarios'
    */
    public function convertirUsuario($id, $tipo)
    {
        $usuario = User::find($id);
        $usuario->tipo=$tipo;
        $usuario->update();
        return redirect()->route('admin.usuarios')
                         ->with('mensaje', 'Usuario convertido con éxito');
        ;
    }

    /**
     * Obtiene los tramites y los diferentes campos para pasarlos a
     * la vista de gestión de trámites
     *
     * @return view 'admin.gestion_tramites'
    */
    public function gestionTramites()
    {
        $tramites = Tramite::orderby('id', 'desc')->get();
        $tipos_tramites = Tramite_campo::select('tipo')->distinct()->get();
        return view('admin.gestion_tramites')
               ->with('tramites', $tramites)
               ->with('tipos_tramites', $tipos_tramites);
    }

    /**
     * Filtra los trámites en función del tipo y el estado pasado como argumentos.
     *
     * @param Request $request información de formulario
     * @return view 'admin.busqueda_tramite'
    */
    public function filtroTramites(Request $request)
    {
        //Buscamos por tipo
        if ($request->texto_t_estado == "todos") {
            if ($request->texto_t_tipo == "todos") {
                $tramites = Tramite::orderby('id', 'desc')->get();
            } else {
                $tramites = Tramite::where('tipo', $request->texto_t_tipo)->orderby('id', 'desc')->get();
            }
            //Buscamps por estado o por tipo y estado
        } else {
            if ($request->texto_t_tipo == "todos") {
                $tramites = Tramite::where('estado', $request->texto_t_estado)->orderby('id', 'desc')->get();
            } else {
                $tramites = Tramite::where('estado', $request->texto_t_estado)->where('tipo', $request->texto_t_tipo)->orderby('id', 'desc')->get();
            }
        }
        return view('admin.busqueda_tramite')
               ->with('tramites', $tramites);
    }

    /**
     * Busca el tramite por su argumento, actualizando su estado,
     * añadiendo una respuesta y creando la notificación asociada.
     *
     * @param Request $request información de formulario
     * @return view 'admin.tramites'
    */
    public function contestarTramites(Request $request)
    {
        //Buscamos y actualizamos el tramite
        $tramite = Tramite::find($request->input('tramite_id'));
        if ($request->input('aceptar')) {
            $tramite->estado = "Aceptado";
        } else {
            $tramite->estado = "Rechazado";
        }
        $tramite->respuesta = $request->input('respuesta');
        $tramite->update();
        //Creamos la notificación
        $notificacion = new Notificacion;
        $notificacion->id_usuario = $tramite->id_usuario;
        $notificacion->tipo = "Trámite";
        $notificacion->descripcion = $tramite->tipo;
        $notificacion->respuesta = "Su trámite se ha ".$tramite->estado.". Puede consultarlo en la zona de sus trámites.";
        $notificacion->save();
        return redirect()->route('admin.tramites')
                         ->with('mensaje', "Respuesta enviada con éxito");
    }

    /**
     * Devuelve la vista de nuevo tramite
     *
     * @return view 'admin.nuevo_tramite'
    */
    public function nuevoTramite()
    {
        return view('admin.nuevo_tramite')
               ->with('mensaje', "");
    }

    /**
     * Inserta un nuevo tramite a partir de los campos pasados.
     *
     * @param Request $request información de formulario
     * @return view 'admin.configTramites'
    */
    public function insertarTramite(Request $request)
    {
        //Si los campos son correctos, añadimos los campos del tramite
        if ($request->input('name')[0] != null && $request->input('tipo')!= null) {
            foreach ($request->input('name') as $campo) {
                if ($campo != null) {
                    $nuevo_campo = new Tramite_campo;
                    $nuevo_campo->tipo = $request->input('tipo');
                    $nuevo_campo->nombre_campo = $campo;
                    $nuevo_campo->save();
                }
            }
            $nuevo_campo = new Tramite_campo;
            $nuevo_campo->tipo = $request->input('tipo');
            $nuevo_campo->nombre_campo = "Documentación";
            $nuevo_campo->save();
            return redirect()->route('admin.configTramites')
                       ->with('mensaje', "Trámite insertado con éxito");
        // Si no son correctos los campos se indica
        } else {
            return view('admin.nuevo_tramite')
                   ->with('mensaje', "Campos insuficientes");
        }
    }

    /**
     * Obtiene las quejas y las devuelve a la vista de gestión de quejas
     *
     * @return view 'admin.gestion_quejas'
    */
    public function gestionQuejas()
    {
        $quejas = Queja::orderby('id', 'desc')->get();
        return view('admin.gestion_quejas')
               ->with('quejas', $quejas);
    }

    /**
     * Filtra las quejas a partir del estado pasado como argumento.
     *
     * @param Request $request información de formulario
     * @return view 'admin.busqueda_queja'
     */
    public function filtroQuejas(Request $request)
    {
        if ($request->texto_q == "todas") {
            $quejas = Queja::orderby('id', 'desc')->get();
        } else {
            $quejas = Queja::where("contestada", $request->texto_q)->orderby('id', 'desc')->get();
        }
        return view('admin.busqueda_queja')
               ->with('quejas', $quejas);
    }

    /**
     * Obtiene la queja con el identificador y actualiza su estado
     * Si la queja corresponde a un usuario identificado, se crea notificación.
     *
     * @param Request $request información de formulario
     * @return route 'admin.quejas'
    */
    public function contestarQuejas(Request $request)
    {
        $queja = Queja::find($request->input('id_queja'));
        $queja->contestada = 1;
        $queja->update();
        //Si la queja corresponde a un usuario identificado, crear notifiación
        if ($queja->usuario) {
            $notificacion = new Notificacion;
            $notificacion->id_usuario = $queja->id_usuario;
            $notificacion->tipo = "Queja/Sugerencia";
            $notificacion->descripcion = $queja->queja;
            $notificacion->respuesta = $request->input('respuesta');
            $notificacion->save();
        }
        return redirect()->route('admin.quejas')
                         ->with('mensaje', "Respuesta enviada con éxito");
    }

    /**
     * Obtiene la queja con el identificador y la borra.
     *
     * @param String $id identificador de queja
     * @return route 'admin.quejas'
    */
    public function borrarqueja($id)
    {
        $queja = Queja::find($id);
        $queja->delete();
        return redirect()->route('admin.quejas')
                         ->with('mensaje', 'Queja borrada con éxito');
    }

    /**
     * Obtiene los tipo de tramites y sus diferentes campos.
     *
     * @return view 'admin.configuracion_tramites'
    */
    public function configuracionTramites()
    {
        $tipo_tramites = Tramite_campo::select('tipo')->distinct()->get();
        $campos_tramites = Tramite_campo::all();
        return view('admin.configuracion_tramites')
               ->with('tipos', $tipo_tramites)
               ->with('campos', $campos_tramites);
    }

    /**
     * Obtiene los campos asociados a ese tipo de tramite y los borra,
     *
     * @param String $tipo tipo de tramite
     * @return route 'admin.configTramites'
    */
    public function borrarTramite($tipo)
    {
        $campos = Tramite_campo::where("tipo", $tipo)->get();
        foreach ($campos as $campo) {
            $campo->delete();
        }
        return redirect()->route('admin.configTramites')
                         ->with('mensaje', 'Tramite borrado con éxito');
    }

    /**
     * Obtiene los campos asociados a ese tipo de tramite, actualiza los existentes
     * e inserta los nuevos.
     *
     * @param Request $request información de formulario
     * @return route 'admin.configTramites'
    */
    public function actualizarTramite(Request $request)
    {
        $campos = Tramite_campo::where("tipo", $request->input('tipo_tramite'))->get();
        //Actualiza los campos existentes
        foreach ($campos as $campo) {
            $campo->tipo = $request->input('titulo');
            $campo->nombre_campo = $request->input($campo->id);
            $campo->update();
        }
        //Si se han introducido nuevos campos, insertarlos
        if ($request->input('name')[0]) {
            foreach ($request->input('name') as $campo) {
                if ($campo != null) {
                    $nuevo_campo = new Tramite_campo;
                    $nuevo_campo->tipo = $request->input('tipo_tramite');
                    $nuevo_campo->nombre_campo = $campo;
                    $nuevo_campo->save();
                }
            }
        }
        return redirect()->route('admin.configTramites')
                         ->with('mensaje', 'Tramite actualizado con éxito');
    }

    /**
    * Obtiene el campo por su identificador y lo borra
     *
     * @param String $id identificador de campo
     * @return route 'admin.configTramites'
    */
    public function borrarCampo($id)
    {
        $campo = Tramite_campo::find($id);
        $campo->delete();
        return redirect()->route('admin.configTramites')
                         ->with('mensaje', 'Campo borrado con éxito');
    }
}
