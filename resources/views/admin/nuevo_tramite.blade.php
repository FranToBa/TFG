@extends('layouts.app')

@section('content')



<div class="container">
    <h3 class="mt-5">Crear nuevo tipo de trámite</h3>
    <hr>


    @if($mensaje)
      <div class="alert alert-danger mt-3">
          {{$mensaje}}
      </div>
    @endif

    <div class="row">
      <div class="col-12 col-md-12">
        <!-- Contenido -->
        <div class="container">
          <br />
          <div class="form-group">
            <form name="add_name" id="add_name" action="{{route('admin.insertarTramite')}}" method="POST">
              @csrf
              <div class="table-responsive">
                <table class="table table-bordered" id="dynamic_field">
                  <tr>
                    <label>Nombre del trámite: </label><input type="text" name="tipo" class="m-3" />
                  </tr>
                  <tr>
                  <td><input type="text" name="name[]" placeholder="Ingrese nombre del campo" class="form-control name_list" /></td>
                  <td><button type="button" name="add" id="add" class="btn btn-success">Agregar Más</button></td>
                  </tr>
                </table>
                <input type="submit" name="submit" id="submit" class="btn btn-info" value="Crear trámite" />
              </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>




@endsection
