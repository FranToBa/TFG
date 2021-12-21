<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Noticia;
use App\Evento;
use App\Tramite_campo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $noticias = Noticia::orderby('id','DESC')->take(3)->get();
        $eventos = Evento::orderby('fecha','DESC')->take(3)->get();
        $formularios = Tramite_campo::select('tipo')->distinct()->get();

        return view('home')
                ->with('eventos',$eventos)
                ->with('noticias',$noticias)
                ->with('formularios',$formularios);
    }
}
