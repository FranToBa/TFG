
@extends('layouts.app')

@section('content')

<div class="container">
  <h1 class="mt-3">Gestión de quejas / sugerencias</h1>

  <ul class="list-group">
    @if(session('mensaje'))
      <div class="alert alert-success mt-3">
          {{session('mensaje')}}
      </div>
    @endif
<div class=" align-items-center pt-1 pb-2 m-3 border-bottom">
    <label class="mr-2">Estado: </label><select name="texto_q" id="texto_q">
      <option value="todas" selected>Todas</option>
      <option value="1">Contestada</option>
      <option value="0">Sin contestar</option>
    </select>
</div>

    <div id="resultados_quejas">
      @include('admin.busqueda_queja')
    </div>

  </ul>
</div>

<script>
  window.addEventListener('load',function(){

    document.getElementById("texto_q").addEventListener("change", () => {
            fetch(`/admin/quejas/filtro?texto_q=${document.getElementById("texto_q").value}`,{ method:'get' })
            .then(response  =>  response.text() )
            .then(html      =>  {   document.getElementById("resultados_quejas").innerHTML = html  })
          })

        });

</script>

@endsection
