@extends('layouts.app')

@section('content')

<div class="container">

  <h1 class="mt-3">Acceso a trámites</h1>
  @if(session('mensaje'))
    <div class="alert alert-success mt-3">
        {{session('mensaje')}}
    </div>
  @endif
  <div class="mt-5 " style="text-align: center;">
    <p >En esta sección usted puede solicitar la realización de un trámite.</p>
    <div class="card p-5 m-5 fondo-claro">
    <form method="POST" action="{{ route('tramite') }}">
      @csrf
      <select name="formularios" class="mr-3">
        @foreach($formularios as $formulario)
          <option value="{{$formulario->tipo}}">{{$formulario->tipo}}</option>
        @endforeach
      </select>
      <button type="submit" class="btn-info">Solicitar formulario</button>
    </form>
      </div>
  </div>

</div>

@endsection
