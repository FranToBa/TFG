
@extends('layouts.app')

@section('content')

<div class="container">
    <h1 class="mt-3 mb-3">{{$titulo}}</h1>

    <div class="panel-body">
        <form method="POST" action="{{ route($ruta) }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group row">
              <label for="dni" class="col-md-4 col-form-label text-md-right">{{ __('Título') }}</label>

                  <div class="col-md-6">
                      <input id="titulo" type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo"  required autofocus>

                      @error('titulo')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="form-group row ">
                  <label for="foto" class="col-md-4 col-form-label text-md-right">{{ __('Foto de portada') }}</label>

                  <div class="col-xl-6 ">
                      <input id="foto" type="file" class=" @error('foto') is-invalid @enderror" name="foto" >

                      @error('foto')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
              
                  <div class="form-group row ">
                  <label for="foto" class="col-md-4 col-form-label text-md-right"></label>
                  <div class="col-xl-6 ">
                      <div id='imagePreview'> </div>
                  </div>

              </div>

              @if($titulo=='Nuevo evento')
              <div class="form-group row">
                  <label for="dni" class="col-md-4 col-form-label text-md-right">{{ __('Fecha') }}</label>

                      <div class="col-md-6">
                          <input id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha" required autofocus>

                          @error('fecha')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="dni" class="col-md-4 col-form-label text-md-right">{{ __('Aforo') }}</label>

                          <div class="col-md-6">
                              <input id="aforo" type="number" min="0" class="form-control @error('aforo') is-invalid @enderror" name="aforo" required autofocus>

                              @error('aforo')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
              @endif


          <!--  <textarea class="ckeditor" id="summary-ckeditor" name="summary-ckeditor" rows="10" cols="80"> -->
              <textarea class="form-control" id="summary-ckeditor" name="summary-ckeditor"></textarea></textarea>

            <button type="submit" class="btn-success mt-4" style="float:right;width: 200px;height: 40px;" > Publicar </button>
        </form>
    </div>
</div>

<!--Scripts para ver imagenes recien subidas -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript">
      (function(){
        function filePreview(input){
          if(input.files && input.files[0]){
            var reader = new FileReader();

            reader.onload = function(e){
              $('#imagePreview').html("<img src='"+e.target.result+"' />");
            }
            reader.readAsDataURL(input.files[0]);
          }
        }
        $('#foto').change(function(){
          filePreview(this);
        });
      })();


    </script>

@endsection
