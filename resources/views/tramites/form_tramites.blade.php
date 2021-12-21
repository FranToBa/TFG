
@extends('layouts.app')

@section('content')

<div class="container">
  <h1 class="mt-3">{{$tipo}}</h1>
  <div class="card m-5 p.1">
      <h4 class="fondo-claro">Datos del solicitante</h4>
      <ul>
        <li><b>Nombre: </b>{{Auth::user()->name}} {{Auth::user()->apellidos}}</li>
        <li><b>DNI: </b>{{Auth::user()->dni}}</li>
        <li><b>Email: </b>{{Auth::user()->email}}</li>
        <li><b>Teléfono: </b>{{Auth::user()->telefono}}</li>
      </ul>

  </div>
  <div class="card m-5 p-5">
    <form method="POST" action="{{ route('tramite.enviar') }} " enctype="multipart/form-data">
      @csrf
      @foreach($campos as $campo)
      @if($campo->nombre_campo != "Documentación")
      <div class="form-group row">
        <label class="col-sm-3 col-form-label">{{$campo->nombre_campo}}: </label>
          <div><textarea name="{{$campo->id}}" rows="1" cols="50" required></textarea></div>
          </div>
        @endif
       @endforeach
       <div class="form-group row">
        <label class="col-sm-3 col-form-label">Documentación:<br /> (si es necesario) </label>
          <div><input type="file" name="documento"></div>
       </div>

       <input type="hidden" value="{{$tipo}}" name="tipo" />
      <button type="submit" class="btn btn-primary mt-4">Enviar trámite</button>

     </form>
   </div>
</div>


@endsection
