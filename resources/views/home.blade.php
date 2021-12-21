@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="mt-3">¡Bienvenido al Ayuntamiento de Marmolejo!</h1>
  <div class="p-3">
      <p>Este es el portal web dedicado para el ciudadano de nuestro pueblo. Desde aquí podrás realizar diversas gestiones online. Además podrás mantenerte informado sobre la actualidad de nuestro pueblo y de los eventos próximos.</p>
      <p>También puede conocer los lugares más emblematicos de nuestro pueblo.</p>
      <div style="text-align: center" class="mt-5">
        <p><strong>¡GRACIAS POR VISITAR NUESTRA WEB!</strong></p>
        <img src="https://www.turismomarmolejo.com/wp-content/uploads/2017/08/4263663.jpg" width="500px" />
      </div>
  </div>

  <div class="container mt-5 pb-3 fondo-claro cuadros-entrada" >
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-2 mb-3 border-bottom border-secondary">
      <h6  class="sidebar-heading d-flex justify-content-between align-items-center px-2 mt-4 mb-3 text-muted" >
        <a class="nav-link" href="{{ route('noticias') }}"><span>Últimas noticias</span></a>
      </h6>
    </div>
    <div class="row">
      @foreach($noticias as $noticia)
      <div class="col-sm m-2 p-0  elementos-portada" style="text-align:center;min-height: 200px" >
        <a href="{{ route('noticia.ver', ['id'=>$noticia->id]) }}"><h3 class="bg-info p-2 ">{{ $noticia->titulo }}</h3>
        <div class="p-2" >
          <img src="{{ route('noticia.foto', ['filename'=>$noticia->foto]) }}" height="150" style="max-width: 300px;"/>
          <p class="m-2">Autor: {{ $noticia->autor->name }} {{$noticia->autor->apellidos}}</p>
        </div>
        </a>
      </div>
      @endforeach

    </div>
  </div>

  <div class="container mt-5 pb-3 fondo-claro cuadros-entrada">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-2 mb-3 border-bottom border-secondary">
      <h6  class="sidebar-heading d-flex justify-content-between align-items-center px-2 mt-4 mb-3 text-muted" >
        <a class="nav-link" href="{{ route('eventos') }}"><span>Próximos eventos</span></a>
      </h6>
    </div>
    <div class="row">
      @foreach($eventos as $evento)
      <div class="col-sm m-2  p-0 elementos-portada" style="text-align:center;min-height: 200px" >
        <a href="{{ route('evento.ver', ['id'=>$evento->id]) }}"><h3 class="bg-success p-2 ">{{ $evento->titulo }}</h3>
        <div class="p-2" >

          <img src="{{ route('evento.foto', ['filename'=>$evento->foto]) }}" height="150" style="max-width: 300px;" />
          <p class="m-2">Fecha: {{ $evento->fecha }}</p>
        </div>
        </a>
      </div>
      @endforeach

    </div>
  </div>
</div>
@endsection
