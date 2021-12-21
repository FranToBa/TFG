@extends('layouts.app')

@section('content')

<div class="container">
  <div class="card mt-5 mb-3 p-3 card-noticia">
    @if(session('mensaje_crear'))
      <div class="alert alert-success mt-3">
          {{session('mensaje_crear')}}
      </div>
    @endif
  <h1 class="card-tittle mt-1">{{$noticia->titulo}}
    @if(Auth::user() and (Auth::user()->tipo == 'colaborador' or Auth::user()->tipo == 'administrador'))
    <button type="button" class="btn btn-default" style="float:right" data-toggle="modal" data-target="#myModal"><img src="{{ asset('images/borrar.png') }}" width="40px"/></button>
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content" style="font-size: 50%;"">
            <div class="modal-header">
              <h5 class="modal-title">Eliminar noticia</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <p>¿Está seguro de que desea eliminar la noticia: <strong>{{$noticia->titulo}}</strong>?</strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
              <a href=" {{ route('colab.borrarNoticia',[$noticia->id]) }} ) }}"><button class="btn btn-outline-danger m-2">Borrar noticia</button></a>
            </div>
          </div>
        </div>
      </div>

    <a href="{{ route('colab.editarNoticia',[$noticia->id]) }}"><button type="button" style="float:right"class="btn btn-default"><img src="{{ asset('images/editar.png') }}" width="40px"/></button></a>
    @endif
  </h1>
  <div class="mb-5 ml-3">
    <h5><u>Autor: {{ $noticia->autor->name }} {{ $noticia->autor->apellidos }} </u></h5>
  </div>
  <div class="card-body m-3" >
    <p>{!! $noticia->descripcion !!}
    </p>
  </div>

</div><br /><br />

  <div class='comentarios '>
  <h3>Comentarios</h3><hr />
  @if(session('mensaje'))
    <div class="alert alert-success mt-3">
        {{session('mensaje')}}
    </div>
  @endif
  <div class='enviar_comentario'>
    <form action="{{ route('comentario.guardar' )}}" method='POST'>
    @csrf
        <input type='hidden' name='noticia_id' value="{{ $noticia->id }}"  />
        <textarea class="form-control" name='comentario' placeholder='Inserte aquí su comentario' rows='2' required/></textarea><br />
        <button type="submit" class="btn btn-info">Enviar comentario</button></form>
  </div><br /><hr />
  <div class="listado_comentarios mt-3">
    @foreach($comentarios as $comentario)
    <div class="card mt-2 p-2 fondo-claro card-comentario">
      <div style="display: flex;">
      @if($comentario->usuario)
        <h5><strong>{{$comentario->usuario->name}} {{$comentario->usuario->apellidos}}</strong></h5>
      @else
        <h5><strong>Anónimo</strong></h5>
      @endif
      <span class="ml-2">       |   {{$comentario->created_at}}</span>

      <!-- Si se esta logueado, el comentario tiene autor y el autor es el usuario.    O si el usuario es admin-->
      @if((Auth::user() and $comentario->usuario and Auth::user()->id == $comentario->usuario->id) or (Auth::user() and Auth::user()->tipo == "administrador") )
        <div class="boton_borrar ml-auto">
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal1"><img src="{{ asset('images/borrar.png') }}" width="40px"/></button>

          <!-- Modal -->
          <div class="modal fade" id="myModal1" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Eliminar comentario</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <p>¿Está seguro de que desea eliminar el comentario?</strong></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
                  <a href=" {{ route('comentario.borrar', [$comentario->id] ) }}"><button class="btn btn-outline-danger m-2">Borrar comentario</button></a>
                </div>
              </div>
            </div>
          </div>
      </div>
      @endif

    </div><hr />
      <p>{{ $comentario->comentario }}</p>

    </div>
    @endforeach
    <div style="display:flex;justify-content: center;" class="mt-5">
      {{$comentarios->links()}}
    </div>

  </div>



    </div>

  <div class="boton_abajo">
      <a href="{{ route('noticias') }}"><button type="button" class="btn btn-outline-primary">Volver a NOTICIAS</button></a>
  </div>


</div>


@endsection
