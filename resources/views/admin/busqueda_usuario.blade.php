
@if($usuarios->count()<"1")
  <div class="alert alert-warning" role="alert">
  Búsqueda sin resultados
  </div>
@endif

@foreach($usuarios as $usuario)
  <li class="list-group-item list-group-item-primary mt-1">
    <ul class="list-group list-group-horizontal" id="lista">
            <li class="list-group-item list-group-item-primary" id="lista"><img src="{{ route('user.foto', ['filename'=>$usuario->foto]) }}" width="100px" height="100px" /></li>
            <li class="list-group-item list-group-item-primary" style="min-width: 700px;">
              <div><label><b>Nombre: </b></label> {{ $usuario->name }} {{ $usuario->apellidos }}</div>
              <div><label><b>DNI: </b></label> {{ $usuario->dni }}</div>
              <div><label><b>Email: </b></label> {{ $usuario->email }}</div>
              <div><label><b>Dirección: </b></label> {{ $usuario->direccion }}</div>
              <div><label><b>Teléfono: </b></label> {{ $usuario->telefono }}</div>
              <div><label><b>Tipo de usuario: </b></label> {{ $usuario->tipo }}</div>
            </li>
            <li>
              <!-- No permitir borrarse asi mismo ni cambiarse de tipo para no dejar la web sin admins -->
              @if($usuario->id != Auth::user()->id)
                <!-- Ofrecer el cambio de tipo -->
                @if($usuario->tipo != 'administrador')
                    <button type="button" class="btn btn-outline-success m-2" data-toggle="modal" data-target="#myModal{{$usuario->id}}">Convertir a admin</button>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal{{$usuario->id}}" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Convertir a admin</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body">
                            <p>¿Está seguro de que desea convertir en admin el usuario: <strong>{{$usuario->name}} {{$usuario->apellidos}}</strong>?</strong></p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
                            <a href="{{ route('admin.convertirUsuario',[$usuario->id, 'administrador']) }}"><button class="btn btn-success m-2">Convertir a admin</button></a>
                          </div>
                        </div>
                      </div>
                    </div>



                @endif
                @if($usuario->tipo != 'colaborador')
                  <button type="button" class="btn btn-outline-success m-2" data-toggle="modal" data-target="#myModal1{{$usuario->id}}">Convertir a colaborador</button>
                  <!-- Modal -->
                  <div class="modal fade" id="myModal1{{$usuario->id}}" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Convertir a colaborador</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <p>¿Está seguro de que desea convertir en colaborador el usuario: <strong>{{$usuario->name}} {{$usuario->apellidos}}</strong>?</strong></p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
                          <a href="{{ route('admin.convertirUsuario',[$usuario->id, 'colaborador']) }}"><button class="btn btn-success m-2">Convertir a colaborador</button></a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
                @if($usuario->tipo != 'usuario')
                  <button type="button" class="btn btn-outline-success m-2" data-toggle="modal" data-target="#myModal2{{$usuario->id}}">Convertir a usuario</button>
                  <!-- Modal -->
                  <div class="modal fade" id="myModal2{{$usuario->id}}" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Convertir a usuario</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <p>¿Está seguro de que desea convertir en usuario a: <strong>{{$usuario->name}} {{$usuario->apellidos}}</strong>?</strong></p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
                          <a href="{{ route('admin.convertirUsuario',[$usuario->id, 'usuario']) }}"><button class="btn btn-success m-2">Convertir a usuario</button></a>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif

                <button type="button" class="btn btn-danger m-2 mt-4" data-toggle="modal" data-target="#myModal3{{$usuario->id}}">Borrar usuario</button>
                  <!-- Modal -->
                  <div class="modal fade" id="myModal3{{$usuario->id}}" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Eliminar usuario</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                          <p>¿Está seguro de que desea eliminar el usuario: <strong>{{$usuario->name}} {{$usuario->apellidos}}</strong>?</strong></p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-success" data-dismiss="modal">Cancelar</button>
                          <a href=" {{ route('admin.borrarUsuario',[$usuario->id]) }} ) }}"><button class="btn btn-outline-danger m-2">Borrar usuario</button></a>
                        </div>
                      </div>
                    </div>
                  </div>


              @endif
            </li>
      </ul>
  </li>

@endforeach
