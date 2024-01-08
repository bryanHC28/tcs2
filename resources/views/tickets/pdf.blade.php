<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>REPORTE SEMANAL</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}" media="all" />

  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{asset('img/sumapp.png')}}">
      </div>
      <h1>REPORTE SEMANAL</h1>
      <div id="company" class="clearfix">

      </div>
      <div id="project">
        <div><span>Sucursal:</span> {{auth()->user()->sucursal->sucursal}}</div>
        <div><span>Nombre:</span> {{auth()->user()->complete_name}}</div>
        <div><span>Email:</span> <a href="{{auth()->user()->correo}}">{{auth()->user()->correo}}</a></div>
        <div><span>Fecha:</span> {{$fechaActual}}</div>
      </div>
    </header>
    <main>
        <h1>ESTADISTICAS</h1>

        <div class="row">
            <figure class="highcharts-figure col-lg-6 col-md-6">
                <div id="aceptado"></div>
            </figure>
        </div>



        @php

$date_now = date('d-m-Y');
$date_past = strtotime('-8 day', strtotime($date_now));
$date_past = date('d-m-Y', $date_past);
        if(count($resultado)==0){
        $Cerrado=[0,"Cerrado"];
        }else{
        $Cerrado=[$resultado[0]->conteo,$resultado[0]->estatus];
        }

        if(count($Abierto)==0){
        $abiertos=[0,"Abierto"];
        }else{
        $abiertos=[$Abierto[0]->conteo,$Abierto[0]->estatus];
        }


        if(count($Ejecutado)==0){
        $ejec=[0,"Ejecutado"];
        }else{
        $ejec=[$Ejecutado[0]->conteo,$Ejecutado[0]->estatus];
        }

        if(count($vencidos)==0){
        $vencido=[0,"Vencido"];
        }else{
        $vencido=[$vencidos[0]->conteo,"Vencidos"];
        }
       // $ejecutados=[$Ejecutado[0]->conteo,$Ejecutado[0]->estatus];


             $var2="https://quickchart.io/chart?c={type:'bar',data:{labels:['".$Cerrado[1]."','".$abiertos[1]."','".$ejec[1]."','".$vencido[1]."'],datasets:[{label:'Estados',data:[".$Cerrado[0].",".$abiertos[0].",".$ejec[0].",".$vencido[0]."]}]}}";
        @endphp


   <h3>Rango: {{$date_past}} / {{$date_now}}   <h5  style="color: rgb(112, 17, 17)">#Nota: Tickets abiertos, cerrados, vencidos, ejecutados de la semana anterior</h5></h3>

        <img width="550px" src="{{$var2}}">
    <h1>Tickets creados</h1>
      <table>
        <thead>
          <tr>
            <th class="service">FOLIO</th>
            <th class="desc">DESCRIPCION</th>
            <th>ESTADO</th>
            <th>AREA</th>
            <th>RESPONSABLE</th>
            <th>FECHA</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($status->abiertos as $abiertos )
            <tr>
                <td class="service">{{$abiertos->id}}</td>
                <td class="desc">{{$abiertos->accion}}</td>
                <td class="unit">{{$abiertos->estatus}}</td>
                <td class="unit">{{$abiertos->area}}</td>
                <td class="qty">{{$abiertos->realizo}}</td>
                <td class="total">{{$abiertos->created_at}}</td>
            </tr>

            @endforeach


        </tbody>
      </table>
      <h1>Tickets ejecutados</h1>
      <table>
        <thead>
          <tr>
            <th class="service">FOLIO</th>
            <th class="desc">DESCRIPCION</th>
            <th>ESTADO</th>
            <th>AREA</th>
            <th>RESPONSABLE</th>
            <th>FECHA</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($status->ejecutado as $ejecutado )
            <tr>
                <td class="service">{{$ejecutado->id}}</td>
                <td class="desc">{{$ejecutado->accion}}</td>
                <td class="unit">{{$ejecutado->estatus}}</td>
                <td class="unit">{{$ejecutado->area}}</td>
                <td class="qty">{{$ejecutado->realizo}}</td>
                <td class="total">{{$ejecutado->fecha_tecnico}}</td>
            </tr>

            @endforeach


        </tbody>
      </table>

      <h1>Tickets cerrados</h1>
      <table>
        <thead>
          <tr>
            <th class="service">FOLIO</th>
            <th class="desc">DESCRIPCION</th>
            <th>ESTADO</th>
            <th>AREA</th>
            <th>RESPONSABLE</th>
            <th>FECHA</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($status->cerrados as $cerrados )
            <tr>
                <td class="service">{{$cerrados->id}}</td>
                <td class="desc">{{$cerrados->accion}}</td>
                <td class="unit">{{$cerrados->estatus}}</td>
                <td class="unit">{{$cerrados->area}}</td>
                <td class="qty">{{$cerrados->realizo}}</td>
                <td class="total">{{$cerrados->close_at}}</td>
            </tr>

            @endforeach


        </tbody>
      </table>

      <h1>Tickets vencidos</h1>
      <table>
        <thead>
          <tr>
            <th class="service">FOLIO</th>
            <th class="desc">DESCRIPCION</th>
            <th>ESTADO</th>
            <th>AREA</th>
            <th>RESPONSABLE</th>
            <th>FECHA</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($status->vencidos as $vencidos )
            <tr>
                <td class="service">{{$vencidos->id}}</td>
                <td class="desc">{{$vencidos->accion}}</td>
                <td class="unit">{{$vencidos->estatus}}</td>
                <td class="unit">{{$vencidos->area}}</td>
                <td class="qty">{{$vencidos->realizo}}</td>
                <td class="total">{{$vencidos->fecha_estimada}}</td>
            </tr>

            @endforeach


        </tbody>
      </table>

    </main>
    <footer>

    </footer>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="https://code.highcharts.com/modules/tilemap.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/sunburst.js"></script>
    <script src="https://code.highcharts.com/modules/stock.js"></script>
    <script>





    </script>
  </body>
</html>
