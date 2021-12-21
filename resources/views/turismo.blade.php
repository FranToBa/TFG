@extends('layouts.app')

@section('content')

<div class="container">
  <h1 class="mt-3">Lugares de interés</h1>
  <div class="p-3">
      <p>
        En esta sección se puede consultar los lugares mas importantes de nuestro pueblo.<br />
        Le ofrecemos un mapa intertactivo para ver donde se encuentran estos lugares.
      </p>

      <div id="select-location">
        <select name="location" id="location">

          <option selected="true" value="-1">Selecciona uno...</option>
          <option value="38.04471567827674, -4.170924514961609">Ayuntamiento</option>
          <option value="38.04502032151474, -4.170849870587616">Iglesia</option>
          <option value="38.05422097155744, -4.191384862601222">Balneario</option>
          <option value="38.042933328176574, -4.1685109842758665">Paseo de la Libertad</option>
          <option value="38.0423080635287, -4.164391111199549">Campo de futbol</option>
          <option value="38.050699997535574, -4.169629372632981">Polideportivo</option>

        </select>
      </div>
      <div id="map"> </div>


  </div>
</div>


@endsection
