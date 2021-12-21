<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <meta name="generator" content="Jekyll v4.1.1">
    <meta name="author" content="Francisco Javier Torres Barea">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/ayun.png') }}" />
    <title>Ayuntamiento de Marmolejo</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.2/dist/leaflet.css" />


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-primary barra-nav-superior">
            <div class="container barra-nav-superior">
                <a class="navbar-brand" href="{{ url('/') }}">
                  <img src="{{ asset('images/ayun.png') }}" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
                    Ayuntamiento de Marmolejo
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                      <li class="nav-item active">

                              </li>
                              <!-- Menu de actualidad-->
                              <li class="nav-item dropdown active">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Actualidad
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="{{ route('noticias') }}">Últimas noticias</a>
                                  <a class="dropdown-item" href="{{ route('eventos') }}">Calendario de eventos</a>

                                </div>
                              </li>

                              <li class="nav-item active">
                                <a class="nav-link" href="{{ route('turismo') }}"> Turismo </a>
                              </li>

                              @guest
                              @else
                              <div class="ml-3 mr-3" style="border-left: 1px solid black"></div>
                              <li class="nav-item active">
                                <a class="nav-link" href=" {{route('tramites') }}"> Trámites </a>
                              </li>
                              @endguest

                              @if(Auth::user() and Auth::user()->tipo == "administrador" )
                              <div class="ml-3 mr-3" style="border-left: 1px solid black"></div>
                              <li class="nav-item dropdown active mr-5">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Administración
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <h8 class="ml-3"><strong>Administrador</strong></h8>
                                  <a class="dropdown-item" href="{{ route('admin.usuarios') }}">Gestión de usuarios</a>
                                  <a class="dropdown-item" href="{{ route('admin.quejas') }}">Gestión de quejas / sugerencias</a>
                                  <a class="dropdown-item" href="{{ route('admin.tramites') }}">Gestión de trámites</a>
                                  <a class="dropdown-item" href="{{ route('admin.configTramites') }}">Configuración de trámites</a>
                                  <hr />
                                  <h8 class="ml-3"><strong>Colaborador</strong></h8>
                                  <a class="dropdown-item" href="{{ route('colab.nuevaNoticia') }}">Nueva noticia</a>
                                  <a class="dropdown-item" href="{{ route('colab.nuevoEvento') }}">Nuevo evento</a>
                                  <a class="dropdown-item" href="{{ route('noticias') }}">Gestión de noticias</a>
                                  <a class="dropdown-item" href="{{ route('eventos') }}">Gestión de eventos</a>

                                </div>
                              </li>
                              @endif

                              @if(Auth::user() and Auth::user()->tipo == "colaborador" )
                              <div class="ml-3 mr-3" style="border-left: 1px solid black"></div>
                              <li class="nav-item dropdown active mr-5">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Colaborador
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="{{ route('colab.nuevaNoticia') }}">Nueva noticia</a>
                                  <a class="dropdown-item" href="{{ route('colab.nuevoEvento') }}">Nuevo evento</a>
                                  <a class="dropdown-item" href="{{ route('noticias') }}">Gestión de noticias</a>
                                  <a class="dropdown-item" href="{{ route('eventos') }}">Gestión de eventos</a>

                                </div>
                              </li>
                              @endif

                    </ul>


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest

                            <button id="boton_inicio" class="btn btn-outline-warning btn-rounded waves-effect" onclick="location.href='{{ route('login') }}'" >{{ __('Iniciar sesión') }}</button>

                            @if (Route::has('register'))
                                <button class="btn btn-outline-warning btn-rounded waves-effect mr-3 ml-3" onclick="location.href='{{ route('register') }}'" >{{ __('Registro') }}</button>
                            @endif
                        @else

                              @if(Auth::user()->foto)
                              <li class="nav-item dropdown">
                                <div class="foto_div_menu">
                                  <img src="{{ route('user.foto', ['filename'=>Auth::user()->foto]) }}" class="foto_perfil_menu"/>
                                </div>
                              </li>
                              @endif



                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  @if(Auth::user()->tipo == 'administrador')
                                    <span><i class="fas fa-users-cog"></i></span>
                                  @elseif(Auth::user()->tipo == 'colaborador')
                                    <span><i class="fas fa-pen-square"></i></span>
                                  @endif
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="{{ route('mistramites') }}">
                                      Mis trámites
                                  </a>
                                  <a class="dropdown-item" href="{{ route('misnotificaciones') }}">
                                      Mis notificaciones
                                  </a>
                                  <hr />
                                  <a class="dropdown-item" href="{{ route('config') }}">
                                      Configuración de perfil
                                  </a>
                                  <hr />
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest


                    </ul>
                    <button class="switch ml-3" id="switch">
                      <span><i class="fas fa-sun"></i></span>
                      <span><i class="fas fa-moon"></i></span>
                    </button>
                </div>
            </div>
        </nav>

        <main class="main">
          <div class="cajaPrincipal">
            @yield('content')
          </div>
          <div class="container-fluid ml-4 ">
            <div class="row">
              <!-- Menu lateral-->
              <nav id="sidebarMenu" class="d-md-block sidebar collapse pb-3">
                <div id="quejas" class="sidebar-sticky p-3 fondo-claro ">
                  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-2 mb-3 border-bottom border-secondary">
                   <h6  class="sidebar-heading d-flex justify-content-between align-items-center px-2 mt-4 mb-3 text-muted" >
                    <span>Quejas y sugerencias</span>
                   </h6>
                 </div>
                 <ul class="nav flex-column">
                   <li class="nav-item"  style="text-align: center;">
                     @if(session('mensaje_queja'))
                       <div class="alert alert-success mt-3" style="font-size: 70%;">
                           {{session('mensaje_queja')}}
                       </div>
                     @endif
                      <form action="{{ route('queja.guardar') }}" method='POST'>
                        @csrf
                        <textarea cols="16" name="queja" style="text-align: center;" placeholder="Introduzca su queja o sugerencia"></textarea>
                        <button type="submit" class="btn-outline-info mt-2">Enviar</button>
                      </form>
                   </li>
                 </ul>
               </div>

               <div id="enlaces" class="sidebar-sticky p-3 mt-4 fondo-claro">
                 <h3 class="border-bottom border-secondary text-muted">Enlaces de interés</h3>
                <ul class="nav flex-column">
                  <li class="nav-item m-3"><a href="https://www.sspa.juntadeandalucia.es/servicioandaluzdesalud/clicsalud/" target="_blank"><img src="{{ asset('images/cita_medico.png') }}" alt="Cita medico" width="250" /></a></li>
                  <li class="nav-item m-3"><a href="https://ws054.juntadeandalucia.es/eureka2/eureka-demandantes/busquedaOfertas.do;j%20%20sessionid=8EC8969F93CDE4191D757FC7993304CB.tcnodo12-6eka" target="_blank"><img src="{{ asset('images/oficina_empleo.png') }}" alt="Oficina empleo" width="250" /></a></li>
                  <li class="nav-item m-3"><a href="https://www.andaluciaemprende.es/" target="_blank"><img src="{{ asset('images/andalucia_emprende.png') }}" alt="Andalucia emprende" width="250" /></a></li>
                </ul>
              </div>
               <div id="numeros" class="sidebar-sticky p-3 mt-4 fondo-claro">
                <ul class="nav flex-column">
                  <li class="nav-item"><img src="{{ asset('images/numeros.png') }}" alt="Numeros urgencias" width="300" /></li>
                </ul>
              </div>


              </nav>
            </div>
          </div>

        </main>
    </div>

</body>
<footer class="bg-primary">

  <div>© 2021 Ayuntamiento de Marmolejo</div>
  <div class="barra"> | </div>
  <div>Francisco Javier Torres Barea</div>
  <div class="barra"> | </div>
  <div class="redes">
    <div class="red"> <a href="mailto:info@ayuntamientodemarmolejo.es" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Gmail_icon_%282020%29.svg/1200px-Gmail_icon_%282020%29.svg.png" alt="Logo correo" width="30" /></a> </div>
    <div class="red"><a href="https://twitter.com/aytodemarmolejo" target="_blank"><img src="https://cdn.cms-twdigitalassets.com/content/dam/help-twitter/twitter_logo_blue.png.twimg.768.png" alt="Logo twitter" width="30" height="25" /></a></div>
    <div class="red"><a href="https://www.facebook.com/aytomarmolejo/" target="_blank"><img src="https://www.facebook.com/images/fb_icon_325x325.png" alt="Logo Facebook" width="" height="25" /></a></div>
  </div>


</footer>


</body>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
<script src="{{ asset('js/mapa.js') }}"></script>
<script src="{{ asset('js/agregar_campos.js') }}"></script>
<script src="{{ asset('js/modo_noche.js') }}"></script>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'summary-ckeditor', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form'
});
</script>
<div class="snap">
  <script class="snap" src="https://account.snatchbot.me/script.js"></script><script>window.sntchChat.Init(183740)</script>
</div>


</html>
