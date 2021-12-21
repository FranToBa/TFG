@extends('layouts.app')

@section('content')

<div class="container">
  <h1 class="mt-3" >Mis notificaciones</h1>
  <ul class="list-group">
    @foreach($notificaciones as $notificacion)
      <li class="list-group-item list-group-item-primary mt-3">
        <span style="display:block;"><b>Tipo: </b>{{$notificacion->tipo}}</span>
        <span style="display:block;"><b>Descripción: </b>{{$notificacion->descripcion}}</span>
        <span style="display:block;"><b>Fecha: </b>{{$notificacion->created_at}}</span><br />
        <span style="display:block;"><b>Mensaje: </b>{{$notificacion->respuesta}}</span>
        </li>
        @endforeach
  </ul>
  <div style="display:flex;justify-content: center;" class="mt-5">
    {{$notificaciones->links()}}
  </div>
</div>

@endsection
