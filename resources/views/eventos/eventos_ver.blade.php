@extends('layouts.app')

@section('content')

<div class="container">
  @if(session('mensaje_crear'))
    <div class="alert alert-success mt-3">
        {{session('mensaje_crear')}}
    </div>
  @endif
  <h1 class="mt-5">{{$evento->titulo}}
    @if(Auth::user() and (Auth::user()->tipo == 'colaborador' or Auth::user()->tipo == 'administrador'))

    <button type="button" class="btn btn-default" style="float:right" data-toggle="modal" data-target="#myModal"><img src="{{ asset('images/borrar.png') }}" width="40px"/></button>
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content" style="font-size: 50%;">
            <div class="modal-header">
              <h5 class="modal-title">Eliminar evento</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <p>¿Está seguro de que desea eliminar el evento: <strong>{{$evento->titulo}}</strong>?</strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
              <a href=" {{ route('colab.borrarEvento',[$evento->id]) }}"><button class="btn btn-outline-danger m-2">Borrar evento</button></a>
            </div>
          </div>
        </div>
      </div>
        <a href="{{ route('colab.editarEvento',[$evento->id]) }}"><button type="button" style="float:right"class="btn btn-default"><img src="{{ asset('images/editar.png') }}" width="40px"/></button></a>

  @endif
  </h1>
  <div class="mb-5 ml-3">
    <h5><u>Fecha: {{ $evento->fecha }}</u></h5>
  </div>
  <div class="m-3" >
    <p>{!! $evento->descripcion !!}</p>
  </div>

  <div class="card mt-5">
    @if(session('mensaje'))
      <div class="alert alert-success m-1 mt-3">
          {{session('mensaje')}}
      </div>
    @endif
    <div class="container p-3 fondo-claro" style="display: flex;">
      <h3 class="mr-3">Participantes: {{$num_asistentes}}/{{$evento->aforo}}</h3>

      @guest
        <p class="mt-1">Debe iniciar sesión para confirmar su asistencia al evento.</p>
      @elseif($asistente)
          <div><p>¡Usted ya ha confirmado su asistencia al evento!</p>
            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#myModal1">Eliminar asistencia</button>
              <!-- Modal -->
              <div class="modal fade" id="myModal1" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Eliminar asistencia</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <p>¿Está seguro de que desea eliminar la asistencia al evento: <strong>{{$evento->titulo}}</strong>?</strong></p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
                      <a href="{{ route('asistencia.eliminar', [$evento->id,Auth::user()->id]) }}"><button class="btn btn-outline-danger m-2">Eliminar asistencia</button></a>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      @elseif($aforo_max)
        <p class="mt-1">Lo siento, el aforo al evento se ha completado.</p>
      @else
        <form method="POST" action=" {{ route('asistencia.anadir') }}">
          @csrf
          <input type="hidden" name="id_usuario" value="{{ Auth::user()->id }}" />
          <input type="hidden" name="id_evento" value="{{ $evento->id }}" />
          <button type="submit" class="btn btn-outline-success">Confirmar asistencia</button>
        </form>
      @endif


    </div>
  </div>


  <div class="boton_abajo">
      <a href="{{ route('eventos') }}"><button type="button" class="btn btn-outline-primary">Volver a EVENTOS</button></a>
  </div>

</div>


@endsection
