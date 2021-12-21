@extends('layouts.app')

@section('content')

<div class="container">

  <h1 class="mt-3">Configuración de trámites
    <a href="{{ route('admin.nuevoTramite') }}"><button type="button" style="float:right"class="btn btn-default"><img src="{{ asset('images/insertar.png') }}" width="40px"/></button></a>
  </h1>

  @if(session('mensaje'))
    <div class="alert alert-success mt-3">
        {{session('mensaje')}}
    </div>
  @endif

  <div id="configuracion_tramites">


    @foreach($tipos as $tipo)
    <li class="list-group-item list-group-item-primary mt-3">
    <h3>{{$tipo->tipo}}</h3>


    <form method="POST" action="{{ route('admin.actualizarTramite') }}" >
      @csrf
      <input type="hidden" value="{{$tipo->tipo}}" name="tipo_tramite" />
      <div class="table-responsive">
        <table class="table table-bordered" id="dynamic_field">

        <tr><td>

       <div class="form-group row">
              <label for="titulo" class="ml-3 mt-1">Nombre del trámite: </label>
              <div class="col-md-8">
                  <input id="titulo" type="text" class="form-control" name="titulo" value="{{ $tipo->tipo }}" required>
              </div>
          </div></td>  </tr>

          @foreach($campos as $campo)
            @if($campo->tipo == $tipo->tipo)
              <tr><td><input type="text" name="{{$campo->id}}" value="{{$campo->nombre_campo}}" class="form-control name_list" /></td>
                  <td> <button type="button" data-toggle="modal" data-target="#myModal{{$campo->id}}"><img src="{{ asset('images/borrar.png') }}" width="20px"/></button></td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="myModal{{$campo->id}}" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Borrar campo</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                        <p>¿Está seguro de que desea eliminar el campo <strong>{{$campo->nombre_campo}}</strong> del trámite <strong>{{$tipo->tipo}}</strong>?</strong></p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
                        <input type="button" class="btn btn-success m-2" onclick="location=`{{route('admin.borrarCampo',[$campo->id])}}`" value="Eliminar campo" />
                      </div>
                    </div>
                  </div>
                </div>

            @endif
          @endforeach

          <tr>
            <td><input type="text" name="name[]" placeholder="Ingrese nombre del campo" class="form-control name_list" /></td>
            <td><button type="button" name="add" id="add" class="btn btn-success">Agregar Más</button></td>
          </tr>
        </table>
      </div>

      <button type="submit" class="btn btn-primary mt-4">Actualizar trámite</button>

     </form>
     @endforeach
</div>

</div>


 @endsection
