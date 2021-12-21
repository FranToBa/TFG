<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Noticia;
use App\Evento;
use App\Comentario;
use App\Asistencia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ColaboradorController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Colaborador Controller
  |--------------------------------------------------------------------------
  |
  | Este controlador es el encargado de controlar las funciones
  | que requieren permisos de colaborador.
  |
  */


    /**
     * Devolver la vista para insertar nueva noticia
     *
     * @return view 'colab.escribir'
    */
    public function nuevaNoticia()
    {
        return view('colab.escribir')
               ->with('ruta', 'colab.insertarNoticia')
               ->with('titulo', 'Nueva noticia');
    }

    /**
     * Valida los datos de la noticia y crea una nueva.
     * Si se ha introducido foto se almacena en disco.
     *
     * @param Request $request información de formulario
     * @return route 'noticia.ver/{noticia_id}'
    */
    public function insertarNoticia(Request $request)
    {
        //Validación de datos
        $validate = $this->validate($request,
          ['titulo' => ['required', 'string', 'max:255'],
           'foto' => ['required','file'],
           'summary-ckeditor' => ['required','string']
          ]);
        //Creamos la noticia
        $noticia = new Noticia;
        $noticia->titulo = $request->input('titulo');
        $noticia->id_autor=\Auth::user()->id;
        $foto = $request->file('foto');
        if ($foto) {
            // Nombre unico
            $foto_path = time().$foto->getClientOriginalName();
            //Guardarlo en la carpeta noticias
            Storage::disk('noticias')->put($foto_path, File::get($foto));
            $noticia->foto = $foto_path;
        }
        $noticia->descripcion = $request->input('summary-ckeditor');
        $noticia->save();
        return redirect()->route('noticia.ver', [$noticia->id])
                         ->with(['mensaje_crear'=>"Noticia creada con exito"]);
    }

    /**
     * Devuelve la noticia asociada al identificador pasado por parametros.
     *
     * @param String $id identificador de noticia
     * @return view 'colab.editar'
    */
    public function editarNoticia($id)
    {
        $noticia = Noticia::find($id);
        return view('colab.editar')
               ->with('ruta', 'colab.updateNoticia')
               ->with('titulo', 'Editar noticia')
               ->with('objeto', $noticia);
    }

    /**
     * Valida los nuevos datos de la noticia y la actualiza.
     * Si se ha introducido foto se almacena en disco.
     *
     * @param Request $request información de formulario
     * @return route 'noticia.ver/{noticia_id}'
    */
    public function updateNoticia(Request $request)
    {
        //Validación de datos
        $validate = $this->validate($request,
          ['titulo' => ['required', 'string', 'max:255'],
           'foto' => ['file'],
           'summary-ckeditor' => ['required','string'],
           'id' => ['required','string']
          ]);
        //Actualización de noticia
        $noticia = Noticia::find($request->input('id'));
        $noticia->titulo = $request->input('titulo');
        $noticia->descripcion = $request->input('summary-ckeditor');
        $foto = $request->file('foto');
        if ($foto) {
            // Nombre unico
            $foto_path = time().$foto->getClientOriginalName();
            //Guardarlo en la carpeta Users
            Storage::disk('noticias')->put($foto_path, File::get($foto));
            $noticia->foto = $foto_path;
        }
        $noticia->update();
        return redirect()->route('noticia.ver', [$request->input('id')])
                         ->with(['mensaje_crear'=>"Noticia editada con exito"]);
    }

    /**
     * Busca y borra la noticia asociada al indeficiador pasado por parámetros.
     * Elimina la foto asociada del disco.
     *
     * @param String $id identificador de noticia
     * @return route 'noticias'
    */
    public function borrarNoticia($id)
    {
        $noticia = Noticia::find($id);
        //Borar imagen de disco
        Storage::disk('noticias')->delete($noticia->foto);
        $noticia->delete();
        return redirect()->route('noticias')
                         ->with(['mensaje_borrar'=>"Noticia borrada con exito"]);
        ;
    }

    /**
     * Devuelve la vista para crear un evento
     *
     * @return view 'colab.escribir'
    */
    public function nuevoEvento()
    {
        return view('colab.escribir')
               ->with('ruta', 'colab.insertarEvento')
               ->with('titulo', 'Nuevo evento');
    }

    /**
     * Valida los datos y crea un nuevo evento
     * Si se ha subido foto se guarda en disco
     *
     * @param Request $request información de formulario
     * @return route 'evento.ver/{evento_id}'
    */
    public function insertarEvento(Request $request)
    {
        //Validación de datos
        $validate = $this->validate($request,
        ['titulo' => ['required', 'string', 'max:255'],
         'foto' => ['required','file'],
         'fecha' => ['required','date'],
         'aforo' => ['required','string'],
         'summary-ckeditor' => ['required','string']
        ]);
        //Creación de evento
        $evento = new Evento;
        $evento->titulo = $request->input('titulo');
        $evento->descripcion = $request->input('summary-ckeditor');
        $evento->fecha = $request->input('fecha');
        $evento->aforo = $request->input('aforo');
        $foto = $request->file('foto');
        //Almacenamiento de foto
        if ($foto) {
            // Nombre unico
            $foto_path = time().$foto->getClientOriginalName();
            //Guardarlo en la carpeta Users
            Storage::disk('eventos')->put($foto_path, File::get($foto));
            $evento->foto = $foto_path;
        }
        $evento->save();
        return redirect()->route('evento.ver', [$evento->id])
                         ->with(['mensaje_crear'=>"Evento creado con exito"]);
    }

    /**
     * Devuelve el evento asociado al identificador pasado por parámetros.
     *
     * @param String $id identificador de evento
     * @return view 'colab.editar'
    */
    public function editarEvento($id)
    {
        $evento = Evento::find($id);
        return view('colab.editar')
               ->with('ruta', 'colab.updateEvento')
               ->with('titulo', 'Editar evento')
               ->with('objeto', $evento);
    }

    /**
     * Valida los nuevos datos del evento y lo actualiza.
     * Si se ha introducido foto se almacena en disco.
     *
     * @param Request $request información de formulario
     * @return route 'evento.ver/{evento_id}'
    */
    public function updateEvento(Request $request)
    {
        //Validación de datos
        $validate = $this->validate($request,
        ['titulo' => ['required', 'string', 'max:255'],
         'foto' => ['file'],
         'fecha' => ['required','date'],
         'aforo' => ['required','string'],
         'summary-ckeditor' => ['required','string']
        ]);
        //Actualización de evento
        $evento = Evento::find($request->input('id'));
        $evento->titulo = $request->input('titulo');
        $evento->descripcion = $request->input('summary-ckeditor');
        $evento->fecha = $request->input('fecha');
        $evento->aforo = $request->input('aforo');
        $foto = $request->file('foto');
        //Almacenamiento de foto
        if ($foto) {
            // Nombre unico
            $foto_path = time().$foto->getClientOriginalName();
            //Guardarlo en la carpeta Users
            Storage::disk('eventos')->put($foto_path, File::get($foto));
            $evento->foto = $foto_path;
        }
        $evento->update();
        return redirect()->route('evento.ver', [$request->input('id')])
                         ->with(['mensaje_crear'=>"Evento editado con exito"]);
    }

    /**
     * Busca y borra el evento asociado al indeficiador pasado por parámetros.
     * Elimina la foto asociada del disco.
     *
     * @param String $id identificador de evento
     * @return route 'eventos'
    */
    public function borrarEvento($id)
    {
        $evento = Evento::find($id);
        Storage::disk('eventos')->delete($evento->foto);
        $evento->delete();
        return redirect()->route('eventos')
                         ->with(['mensaje_borrar'=>"Evento borrado con exito"]);
    }
}
