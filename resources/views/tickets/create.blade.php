@extends('adminlte::page')

@section('plugins.Sweetalert2', false)
    


@section('title', 'Dashboard')

@section('content_header')
    <h1>Abrir Ticket</h1>
@stop

@section('content')
 @if($tipoUsuario == 'ejecutor')
 <div class="alert alert-danger" role="alert">
  No tienes acceso a esta página
</div>
 @else

<div class="card">
    <div class="card-body">
        <form action="{{ url('tickets') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="empresa" value="{{$empresa}}"> 
          <div class="form-row">
            <div class="form-group cold-md-2">
                <label for="exampleFormControlSelect1">Sucursal</label>
                <select class="form-control btn-sucursal"  name="sucursal" id="">
                  <option value="" disabled selected>Seleccione</option>
                @foreach ($sucursales as $sucursal)
               
                    <option value="{{$sucursal->sucursal}}">{{$sucursal->sucursal}}</option>
                @endforeach
             
              </select>
            </div>
           
              <div class="form-group col-md-5">
                <label for="exampleFormControlSelect1">Area</label>
                <div id="area-div">
                  <select class="form-control" name="area" id="exampleFormControlSelect1">
                    <option value="" disabled selected>Seleccione</option>
                      @foreach ($areas as $area)
                      <option value="{{$area->area_descripcion}}">{{$area->area_descripcion}}</option>
                      @endforeach
                  </select>
                </div>
              </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
                <label for="exampleFormControlSelect1">Categoría</label>
                <select class="form-control btn-categoria" name="categoria">
                   <option value="" disabled selected>Seleccione</option>
                   @foreach ($categorias as $categoria)
                       <option value="{{$categoria->id}}">{{$categoria->categoria_descripcion}}</option>
                   @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
              <label for="exampleFormControlSelect1">Subcategoría</label>
              <div id="subcategoria-div">
               
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="exampleFormControlTextarea1">Descripción</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" name="descripcion" rows="3"></textarea>
            </div>
            <div class="form-group col-md-6">
              <label for="exampleFormControlTextarea1">Observaciones</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" name="observaciones" rows="3"></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="exampleFormControlTextarea1">Evidencia</label>
              <input class="form-control" type="file" name="evidencia">
            </div>
          </div>
            <div class="form-group">
              <input class="btn btn-success" type="submit" value="Aceptar">
            </div>

          </form>
    </div>
</div>
@endif

@stop

@section('css')

    <link rel="stylesheet" href="/css/admin_custom.css">
   
    <link href="{{asset('vendor/tabulador/css/tabulator.min.css')}}" rel="stylesheet">
    
@stop

@section('js')
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
  $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

$(".btn-categoria").change(function(e){

  

e.preventDefault();

var cat = $("select[name=categoria]").val();


console.log(cat);

$.ajax({
   type:'POST',
   url:"{{ route('subcategoria.post') }}",
   data:{cat:cat, _token: '{{csrf_token()}}'},
   success: function (response) {
        $('#subcategoria-div').html(response);
    },
});

});

$(".btn-sucursal").change(function(e){

  

e.preventDefault();

var sucursal = $("select[name=sucursal]").val();


console.log(sucursal)

$.ajax({
   type:'POST',
   url:"{{ route('area.post') }}",
   data:{sucursal:sucursal, _token: '{{csrf_token()}}'},
   success: function (response) {
        $('#area-div').html(response);
    },
});

});
  


    </script>
@stop