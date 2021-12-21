@if($tramites->count()<"1")
  <div class="alert alert-warning" role="alert">
  Búsqueda sin resultados
  </div>
@endif

@foreach($tramites as $tramite)
  <li class="list-group-item list-group-item-primary mt-3">
    <h3 style="text-decoration: underline;">{{$tramite->tipo}}</h3>
    <span style="display:block;"><b>Estado: </b>{{$tramite->estado}}</span>
    @if($tramite->estado != "Pendiente")
      <span><b>Respuesta: </b>{{$tramite->respuesta}}</span>
    @endif
    <ul class="list-group list-group-horizontal mt-2" id="lista">
              <li class="list-group-item list-group-item-primary" style="min-width: 700px;">
                <div><label><b>Nombre del solicitante: </b></label> {{$tramite->usuario->name}} {{$tramite->usuario->apellidos}}</div>
                <div><label><b>DNI: </b></label> {{$tramite->usuario->dni}}</div>
                <div><label><b>Email: </b></label> {{$tramite->usuario->email}}</div>
                <div><label><b>Teléfono: </b></label> {{$tramite->usuario->telefono}}</div>
            </li>
            @if($tramite->estado == "Pendiente")
            <li style="text-align:center">
              <form method="POST" action=" {{route('admin.contestarTramite')}}">
                @csrf
                <textarea name="respuesta" placeholder="Inserte la respuesta del trámite" class="mb-3"></textarea>
                <input type="hidden" value="{{$tramite->id}}" name="tramite_id"/>
                <input type='submit' name="aceptar" value='Aceptar trámite' class='btn btn-success m-2' />
                <input type='submit' name="rechazar" value='Rechazar trámite' class='btn btn-danger m-2' />
              </form>
            </li>
            @endif
      </ul>
    <ul class="list-group list-group-horizontal mt-4" id="lista">
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
