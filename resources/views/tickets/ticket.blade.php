<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: 65mm 157mm; /* Tamaño A4 en milímetros */
            margin: 0;
        }
   
p {
    font: bold 60% monospace;
    text-align: center; /* Centrar contenido horizontalmente */
    line-height: 95%;
}
 
#encabezado {
  width: 150px;
  height: 120px;
   
  margin: 0;  /* Centrar horizontalmente */
  text-align: center; 
}
#encabezado2 {
  width: 80px;
  height: 50px;
   
  margin: 0;  /* Centrar horizontalmente */
  text-align: center; 
}
.contenedor {
  text-align: center; /* Centrar contenido horizontalmente */
  height: 100px;
 
}
    </style>
</head>
<body>
    <div class="contenedor">
        @if(auth()->user()->id_empresa== 39)
<img id="encabezado" src="{{ asset('img/monalisa.png') }}">
@elseif(auth()->user()->id_empresa== 33)
<img id="encabezado2" src="{{ asset('img/proy9.jpg') }}">
@elseif(auth()->user()->id_empresa== 27)
<img id="encabezado" src="{{ asset('img/pilot.png') }}">
@elseif(auth()->user()->id_empresa== 10)
<img id="encabezado" src="{{ asset('img/accor.png') }}">
@else
<h1>[WorkPlay]</h1>
@endif
<h6>--------------------------------------------------------------</h6>
    </div>
      <br>
      <br>
   
      <h5 style="text-align: center">{{ trans('messages.ubicacion') }}</h5>
        <p>{{ trans('messages.tcs_folio') }}: #<?= $id ?>
        <br>
        {{ trans('messages.edo') }}: <?= $estatus ?>
        <br>
        {{ trans('messages.branch') }}: <?= $sucursal ?>
         <br>
         Area: <?= $area ?? '[NA]'  ?>
         <br>
         Subarea: <?= $subarea ?? '[NA]' ?>
         </p>
         <div class="contenedor">
<h6>--------------------------------------------------------------</h6>
<h5 style="text-align: center">{{ trans('messages.descripcion') }}</h5>
<p>{{ trans('messages.autor') }}: <?= $autor ?? '[NA]' ?>
<br>
{{ trans('messages.responsable') }}: <?= $responsable ?? '[NA]' ?>
<br>
{{ trans('messages.fecha_estimada') }}: <?= $fecha_estimada ?? '[NA]' ?>
 <br>
 @if(auth()->user()->id_empresa== 27 || auth()->user()->id_empresa== 10|| auth()->user()->id_empresa== 44)
 {{ trans('messages.descripcion') }}: <?= $descripcion ?? '[NA]'  ?>
 @else
 {{ trans('messages.accion') }}: <?= $accion ?? '[NA]'  ?>
 @endif
 @if(auth()->user()->id_empresa== 10)
 <br>
 Habitacion: #<?= $habitacion ?? '[NA]'  ?>
 @endif
 
 <br>
{{ trans('messages.observaciones') }}: <?= $observaciones ?? '[NA]' ?>
 <br>
 {{ trans('messages.prioridad') }}: <?= $prioridad ?? '[NA]'  ?>
 <br>
 {{ trans('messages.categoria') }}: <?= $categoria ?? '[NA]' ?>
 </p>
 <h6>--------------------------------------------------------------</h6>

 <h6>{{ trans('messages.app') }}</h6>
</div>
</body>
</html>
