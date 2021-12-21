@extends('layouts.app')

@section('content')

<div class="container">
  @if(session('mensaje_borrar'))
    <div class="alert alert-success mt-3">
        {{session('mensaje_borrar')}}
    </div>
  @endif

  <h1 class="mt-3">Próximos eventos
    @if(Auth::user() and (Auth::user()->tipo == 'colaborador' or Auth::user()->tipo == 'administrador'))
      <a href="{{ route('colab.nuevoEvento') }}"><button type="button" style="float:right"class="btn btn-default"><img src="{{ asset('images/insertar.png') }}" width="40px"/></button></a>
    @endif
</h1>
  <div class="row">
    @foreach($eventos as $evento)
    <div class="col-sm-6 p-0" style="text-align:center;" >
      <div class="ml-5 mr-5 ">
      <a href="{{ route('evento.ver', ['id'=>$evento->id]) }}" class="link-dark"><h3 class="bg-success p-2 mt-5 ">{{ $evento->titulo }}</h3>
      <div class="imagenes-lista p-2 fondo-claro" style="min-height: 250px; "  >
        <img src="{{ route('evento.foto', ['filename'=>$evento->foto]) }}" height="200px"/>
        <p class="m-2">Fecha: {{ $evento->fecha }}</p>
      </div>
      </a>
      </div>
      @if(Auth::user() and (Auth::user()->tipo == 'colaborador' or Auth::user()->tipo == 'administrador'))
        <a href=" {{ route('colab.editarEvento',[$evento->id]) }}"><button class="btn btn-outline-success m-2">Editar evento</button></a>
        <button type="button" class="btn btn-outline-danger m-2" data-toggle="modal" data-target="#myModal">Borrar evento</button>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Eliminar evento</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>¿Está seguro de que desea eliminar el evento: <strong>{{$evento->titulo}}?</strong></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
                <a href=" {{ route('colab.borrarEvento',[$evento->id]) }}"><button class="btn btn-outline-danger m-2">Borrar evento</button></a>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
    @endforeach

  </div>

  <div style="display:flex;justify-content: center;" class="mt-5">
    {{$eventos->links()}}
  </div>
</div>

@endsection
