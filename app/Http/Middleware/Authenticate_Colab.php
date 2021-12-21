<?php

namespace App\Http\Middleware;

use Closure;


class Authenticate_Colab
{
  /*
  |--------------------------------------------------------------------------
  | Middleware de Colaborador
  |--------------------------------------------------------------------------
  |
  | Comprueba que hay un usuario identificado y que es de tipo 'colaborador'.
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
      if (auth()->check() && (auth()->user()->tipo == "administrador" or auth()->user()->tipo == "colaborador"))
          return $next($request);

        return redirect('/');
    }
}
