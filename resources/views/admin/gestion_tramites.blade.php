
@extends('layouts.app')

@section('content')

<div class="container">
  <h1 class="mt-3" >Gestión de trámites</h1>
  <ul class="list-group">
    @if(session('mensaje'))
      <div class="alert alert-success mt-3">
          {{session('mensaje')}}
      </div>
    @endif
    <div class="align-items-center pt-1 pb-2 m-3 border-bottom">
      <label class="mr-2">Estado del trámite: </label><select name="texto_t_estado" id="texto_t_estado">
        <option value="todos" selected>Todos</option>
        <option value="Pendiente">Pendientes</option>
        <option value="Aceptado">Aceptados</option>
        <option value="Rechazado">Rechazados</option>
      </select>

      <label class="mr-2 ml-5">Tipo de trámite: </label><select name="texto_t_tipo" id="texto_t_tipo">
        <option value="todos" selected>Todos</option>
        @foreach($tipos_tramites as $tipo)
          <option value="{{$tipo->tipo}}">{{$tipo->tipo}}</option>
        @endforeach
      </select>
    </div>

    <div id="resultados_tramites">
      @include('admin.busqueda_tramite')
    </div>
  </ul>

</div>

<script>
  window.addEventListener('load',function(){

    document.getElementById("texto_t_estado").addEventListener("change", () => {
            fetch(`/admin/tramites/filtro?texto_t_estado=${document.getElementById("texto_t_estado").value}&texto_t_tipo=${document.getElementById("texto_t_tipo").value}`,{ method:'get' })
            .then(response  =>  response.text() )
            .then(html      =>  {   document.getElementById("resultados_tramites").innerHTML = html  })
          })
    document.getElementById("texto_t_tipo").addEventListener("change", () => {
            fetch(`/admin/tramites/filtro?texto_t_estado=${document.getElementById("texto_t_estado").value}&texto_t_tipo=${document.getElementById("texto_t_tipo").value}`,{ method:'get' })
            .then(response  =>  response.text() )
            .then(html      =>  {   document.getElementById("resultados_tramites").innerHTML = html  })
                })


        });

</script>

@endsection
