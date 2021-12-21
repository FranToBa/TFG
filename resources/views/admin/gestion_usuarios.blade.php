
@extends('layouts.app')

@section('content')

<div class="container">
  <h1 class="mt-3">Gestión de usuarios</h1>

  <ul class="list-group">
    @if(session('mensaje'))
      <div class="alert alert-success mt-3">
          {{session('mensaje')}}
      </div>
    @endif

    <div class=" align-items-center pt-1 pb-2 m-3 border-bottom">
      <label class="mr-2">DNI: </label><input type="text" name="texto" id="texto" />
      <label class="mr-2 ml-5">Tipo de usuario: </label><select name="texto_tipo" id="texto_tipo">
        <option value="todos" selected>Todos</option>
        <option value="usuario">Usuario</option>
        <option value="colaborador">Colaborador</option>
        <option value="administrador">Administrador</option>
      </select>
    </div>

    <div id="resultados_usuarios">
      @include('admin.busqueda_usuario')
    </div>

  </ul>

</div>


<script>
  window.addEventListener('load',function(){

    document.getElementById("texto").addEventListener("keyup", () => {
            fetch(`/admin/usuarios/filtro?texto=${document.getElementById("texto").value}&texto_tipo=${document.getElementById("texto_tipo").value}`,{ method:'get' })
            .then(response  =>  response.text() )
            .then(html      =>  {   document.getElementById("resultados_usuarios").innerHTML = html  })
          })

          document.getElementById("texto_tipo").addEventListener("change", () => {
                  fetch(`/admin/usuarios/filtro?texto=${document.getElementById("texto").value}&texto_tipo=${document.getElementById("texto_tipo").value}`,{ method:'get' })
                  .then(response  =>  response.text() )
                  .then(html      =>  {   document.getElementById("resultados_usuarios").innerHTML = html  })
                })
      });
</script>



@endsection
