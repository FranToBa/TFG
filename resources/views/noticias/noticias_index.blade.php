@extends('layouts.app')

@section('content')

<div class="container">

  @if(session('mensaje_borrar'))
    <div class="alert alert-success mt-3">
        {{session('mensaje_borrar')}}
    </div>
  @endif

  <h1 class="mt-3">Últimas noticias
    @if(Auth::user() and (Auth::user()->tipo == 'colaborador' or Auth::user()->tipo == 'administrador'))
    <a href="{{ route('colab.nuevaNoticia') }}"><button type="button" style="float:right"class="btn btn-default"><img src="{{ asset('images/insertar.png') }}" width="40px"/></button></a>
    @endif
  </h1>
  <div class="row">
    @foreach($noticias as $noticia)
    <div class="col-sm-6 p-0" style="text-align:center;" >
      <div class="ml-5 mr-5">
      <a href="{{ route('noticia.ver', ['id'=>$noticia->id]) }}"><h3 class="bg-info p-2 mt-5  ">{{ $noticia->titulo }}</h3>
      <div class="imagenes-lista p-2 fondo-claro" style="min-height: 250px; "  >
        <img src="{{ route('noticia.foto', ['filename'=>$noticia->foto]) }}" height="200px"  />
        <p class="m-2">Autor: {{ $noticia->autor->name }} {{$noticia->autor->apellidos}}</p>
      </div>
      </a>
    </div>
    @if(Auth::user() and (Auth::user()->tipo == 'colaborador' or Auth::user()->tipo == 'administrador'))
      <a href=" {{ route('colab.editarNoticia',[$noticia->id]) }}"><button class="btn btn-outline-info m-2">Editar noticia</button></a>

      <button type="button" class="btn btn-outline-danger m-2" data-toggle="modal" data-target="#myModal">Borrar noticia</button>

      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Eliminar noticia</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <p>¿Está seguro de que desea eliminar la noticia: <strong>{{$noticia->titulo}}?</strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
              <a href=" {{ route('colab.borrarNoticia',[$noticia->id]) }}"><button class="btn btn-outline-danger m-2">Borrar noticia</button></a>
            </div>
          </div>

        </div>
      </div>


    @endif
    </div>
    @endforeach

  </div>

  <div style="display:flex;justify-content: center;" class="mt-5">
    {{$noticias->links()}}
  </div>
</div>

@endsection
