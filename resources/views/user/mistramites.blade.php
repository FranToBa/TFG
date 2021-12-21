
@extends('layouts.app')

@section('content')

<div class="container">
  <h1 class="mt-3" >Mis trámites</h1>
  <ul class="list-group">
    @foreach($tramites as $tramite)
      <li class="list-group-item list-group-item-primary mt-3">
        <h3 style="text-decoration: underline;">{{$tramite->tipo}}</h3>
        <span style="display:block;"><b>Estado: </b>{{$tramite->estado}}</span>
        @if($tramite->estado != "Pendiente")
          <span><b>Respuesta: </b>{{$tramite->respuesta}}</span>
        @endif
        <ul class="list-group list-group-horizontal mt-2" id="lista">
                  <li class="list-group-item list-group-item-primary" style="min-width: 700px;">
                    @foreach($tramite->tramites_instancias as $instancia)
                      @if($instancia->campo->nombre_campo != "Documentación")
                      <div><label><b>{{$instancia->campo->nombre_campo}}: </b></label> {{ $instancia->valor }}</div>
                      @else
                        <div><label><b>{{$instancia->campo->nombre_campo}}: </b></label>
                          <a href="{{ route('tramite.pdf', ['filename'=>$instancia->valor]) }}" class="btn-descargar" target="_blank">
                          {{ $instancia->valor }}  <i class="fas fa-download"></i>
                          </a></div>
                      @endif

                  @endforeach

                </li>
          </ul>
      </li>
    @endforeach
  </ul>
  <div style="display:flex;justify-content: center;" class="mt-5">
    {{$tramites->links()}}
  </div>

</div>

@endsection
