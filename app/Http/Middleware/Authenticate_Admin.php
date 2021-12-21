<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate_Admin
{
    /*
    |--------------------------------------------------------------------------
    | Middleware de Administrador
    |--------------------------------------------------------------------------
    |
    | Comprueba que hay un usuario identificado y que es de tipo 'administrador'.
    |
    */

    /**
     * Maneja una solicitud entrante.
     * Si cumple los requisitos, avanza.
     * Si no, redirige a la página de inicio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->tipo == "administrador") {
            return $next($request);
        }

        return redirect('/');
    }
}
