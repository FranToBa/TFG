<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Rules\PhoneNumber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Tramite;
use App\Notificacion;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Controller
    |--------------------------------------------------------------------------
    |
    | Este controlador es el encargado de controlar las funciones
    | que puede realizar un usuario identificado.
    |
    */

    /**
     * Devuelve la vista de configuración de perfil de usuario.
     *
     * @return view 'user.config'
    */
    public function config()
    {
        return view('user.config');
    }

    /**
     * Valida los nuevos datos del usuario y lo actualiza.
     * Si se ha introducido foto se almacena en disco.
     *
     * @param Request $request información de formulario
     * @return route 'config'
    */
    public function update(Request $request)
    {
        $user = \Auth::user();
        $id = $user->id;
        // Validación de datos de usuario
        $validate = $this->validate($request,
         ['name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
          'dni' => ['required', 'string','min:8', 'max:10','unique:users,dni,'.$id,'regex:/^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKET]$/i'],
          'apellidos' => ['required', 'string', 'max:255'],
          'direccion' => ['required','string', 'max:255'],
          'telefono' => ['required', new PhoneNumber]
         ]);
         // Actualización de datos
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->dni = $request->input('dni');
        $user->apellidos = $request->input('apellidos');
        $user->direccion = $request->input('direccion');
        $user->telefono = $request->input('telefono');
        //Subida de imagen
        $foto = $request->file('foto');
        if ($foto) {
            // Nombre unico
            $foto_path = time().$foto->getClientOriginalName();
            //Guardarlo en la carpeta Users
            Storage::disk('users')->put($foto_path, File::get($foto));
            $user->foto = $foto_path;
        }
        $user->update();
        return redirect()->route('config')
                         ->with(['message'=>'Usuario actualizado']);
    }

    /**
     * Obtiene de disco la imagen asociada al nombre pasado por param.
     *
     * @param String $filename nombre de la imagen a buscar
     * @return Response $foto devuelve la imagen con código 200.
    */
    public function getImage($filename)
    {
        $foto = Storage::disk('users')->get($filename);
        return new Response($foto, 200);
    }

    /**
     * Valida la nueva contraseña y la actualiza.
     * Encripta dicha contraseña para guardarla en bd.
     *
     * @param Request $request información de formulario
     * @return route 'config'
    */
    public function updatePassword(Request $request)
    {
        $user = \Auth::user();
        // Validación de nueva contraseña
        $validate = $this->validate($request,
         ['password' => ['required', 'string', 'min:8', 'confirmed']]);
        // Encriptación y actualización de contraseña
        $user->password = Hash::make($request->input('password'));
        $user->update();
        return redirect()->route('config')
                         ->with(['message'=>'Contraseña actualizada']);
    }

    /**
     * Obtiene os trámites asociados al usuario con sesión iniciada
     * a través de su identificador y los devuelve a la vista de Mis trámites.
     *
     * @return view 'user.mistramites'
    */
    public function misTramites()
    {
        $tramites = Tramite::where('id_usuario', \Auth::user()->id)->orderby('id', 'desc')->paginate(3);
        return view('user.mistramites')
               ->with('tramites', $tramites);
    }

    /**
     * Obtiene el documento asociado al nombre pasado por param.
     *
     * @param String $filename nombre del documento
     * @return Response $documento devuelve el documento del disco
    */
    public function getTramite($filename)
    {
        return response(Storage::disk('tramites')->get($filename), 200)
               ->header(
                  'Content-Type',
                  Storage::disk('tramites')
                  ->mimeType($filename)
               );
    }

    /**
     * Obtiene las notificaciones asociadas al usuario con sesión iniciada a
     * través de su identificador y las devuelve a la vista Mis notificaciones.
     *
     * @return view 'user.misnotificaciones'
    */
    public function misNotificaciones()
    {
        $notificaciones = Notificacion::where('id_usuario', \Auth::user()->id)->orderby('id', 'desc')->paginate(5);
        return view('user.misnotificaciones')
               ->with('notificaciones', $notificaciones);
    }

}
