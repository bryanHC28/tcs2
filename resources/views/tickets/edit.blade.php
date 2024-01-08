@extends('adminlte::page')

@section('plugins.Sweetalert2', false)
    


@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Ticket</h1>
@stop

@section('content')


<div class="card">
    <div class="card-body">
        <form action="{{ route('tickets.update', $tickets[0]->id) }}" method="post" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="empresa" value="{{$empresa}}">
          <div class="form-row">
            <div class="form-group col-md-2">
              
                <label for="exampleFormControlSelect1">Sucursal</label>
                <input class="form-control" name="{{$tickets[0]->sucursal}}" value="{{$tickets[0]->sucursal}}" disabled>
            </div>
            
           
          </div>
         
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="exampleFormControlSelect1">Area</label>
              <input class="form-control" name="area" value="{{$tickets[0]->area}}" id="exampleFormControlSelect1" disabled>
                
            </div>
            <div class="form-group col-md-4">
                <label for="exampleFormControlSelect1">Categoría</label>
                <input class="form-control " value="{{$tickets[0]->categoria}}" name="categoria" disabled>
                
            </div>
            <div class="form-group col-md-4">
                <label for="exampleFormControlSelect1">Subcategoría</label>
                <input class="form-control" value="{{$tickets[0]->subcategoria}}" name="subcategoria" disabled>
                
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="exampleFormControlTextarea1">Descripción</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" name="descripcion" rows="3">{{$tickets[0]->ticket_descripcion}}</textarea>
            </div>
            <div class="form-group col-md-6">
              <label for="exampleFormControlTextarea1">Observaciones</label>
              <textarea class="form-control" id="exampleFormControlTextarea1" name="observaciones" rows="3">{{$tickets[0]->observaciones}}</textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-2">
                <label for="costo">Costo</label>
                <input type="text" class="form-control" value="{{$tickets[0]->costo}}" name="costo" >
              </div>
              <div class="form-group col-md-2">
                <label for="exampleFormControlSelect1">Estatus</label>
                <select class="form-control" name="estatus" id="exampleFormControlSelect1">
                  <option value="{{$tickets[0]->estatus}}"  selected>{{$tickets[0]->estatus}}</option>
                  @if($tipoUsuario == 'administrador')
                  
                  <option value="En proceso">En proceso</option>
                   <option value="Cerrado">Cerrado</option>
                   <option value="Cierra Final">Cierre final</option>
                   @endif
                   @if($tipoUsuario == 'ejecutor')
                   <option value="En proceso">En proceso</option>
                    <option value="Cerrado">Cerrado</option>
                    @endif
                   @if($tipoUsuario == 'usuario')
                  
                    @endif
                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleFormControlTextarea1">Evidencia de solución</label>
                <input class="form-control" type="file" name="evidenciaFinal">
                <input class="form-control" type="hidden" name="evidenciaFinal2" value="{{$tickets[0]->evidenciaFinal}}">
              </div>
          </div>  
          <div class="form-row">
            <div class="form-group col-md-4">
           <label for="">Evidencia de falla</label>
           @if($tickets[0]->ticket_sumapp != null)
            <img src="https://fotos.sumapp.cloud/Sumapp/MadisonGrill/{{$tickets[0]->evidenciaInicial}}" alt="">
           @else
            <img src="https://fotostickets.sumapp.cloud/Gastronomicaholdings/{{$tickets[0]->evidenciaInicial}}" alt="">
           @endif 
          </div>  
            <div class="form-group col-md-4">
           <label for="">Evidencia de solución</label>
            <img src="https://fotostickets.sumapp.cloud/Gastronomicaholdings/{{$tickets[0]->evidenciaFinal}}" alt="">
            
          </div>  
           
          </div>
          <div class="form-group">
            <input class="btn btn-success" type="submit" value="Actualizar">
          </div>
          </form>
    </div>
</div>


@stop

@section('css')

    <link rel="stylesheet" href="/css/admin_custom.css">
   
    <link href="{{asset('vendor/tabulador/css/tabulator.min.css')}}" rel="stylesheet">
    <style>
      img{
  text-align: center;
  width: 300px;
}
    </style>
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
  


    </script>
@stop