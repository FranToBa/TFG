@if($quejas->count()<"1")
  <div class="alert alert-warning" role="alert">
  Búsqueda sin resultados
  </div>
@endif

@foreach($quejas as $queja)
  <li class="list-group-item list-group-item-primary mt-1">
    <ul class="list-group list-group-horizontal" id="lista">
      <li class="list-group-item list-group-item-primary" style="min-width: 700px;">
              @if($queja->usuario)
                <div><label><b>Usuario: </b></label> {{ $queja->usuario->name }} {{ $queja->usuario->apellidos }}</div>
              @else
                <div><label><b>Usuario: </b></label> Anónimo</div>
              @endif
              <div><label><b>Queja / sugerencia: </b></label> {{ $queja->queja }}</div>
            </li>
            <li>
                @if(!$queja->contestada and $queja->usuario)
                  <form action="{{route('admin.contestarQueja')}}" method="POST">
                    @csrf
                    <textarea name="respuesta" placeholder="Inserte la respuesta de la queja" class="ml-3 mb-1"></textarea>
                    <input type="hidden" name="id_queja" value="{{$queja->id}}" />
                    <button type="submit" class="btn btn-outline-success ml-3 mb-3" data-toggle="modal" data-target="#myModal" style="display:block;">Contestar queja</button>
                  </form>
                @elseif(!$queja->usuario)
                        <p class="ml-3 mb-1">
                          No se puede responder a usuario anónimo
                        </p>
                @elseif($queja->contestada)
                        <p class="ml-3 mb-1">
                          Respuesta enviada
                        </p>
                @endif
                <button type="button" class="btn btn-danger ml-3 mb-1" data-toggle="modal" data-target="#myModal{{$queja->id}}">Borrar queja</button>
                  <!-- Modal -->
                  <div class="modal fade" id="myModal{{$queja->id}}" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Eliminar queja</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <p>¿Está seguro de que desea eliminar la queja seleccionada?</strong></p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
                          <a href=" {{ route('admin.borrarQueja',[$queja->id]) }} ) }}"><button class="btn btn-outline-danger m-2">Borrar queja</button></a>
                        </div>
                      </div>
                    </div>
                  </div>


            </li>
      </ul>
  </li>
@endforeach
