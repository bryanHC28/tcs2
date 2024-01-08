

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $status->abiertos }}</h3>
                <p>{{ trans('messages.tickets_open') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_monalisa',['Estatus'=>'Abierto'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3  style="color: white">{{ $status->suspendido }}</h3>
                <p style="color: white">Suspendido</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_monalisa',['Estatus'=>'Suspendido'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $status->en_proceso }}</h3>
                <p>En proceso</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_monalisa',['Estatus'=>'En proceso'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $status->cerrados }}</h3>
                <p>{{ trans('messages.tickets_close') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_monalisa',['Estatus'=>'Cerrado'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $status->ejecutado }}</h3>
                <p>Ejecutado</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_monalisa',['Estatus'=>'Ejecutado'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    </div>

    <div class="row">



        <div class="col-lg-12 col-md-6">
            <div class="small-box" style="background-color:  rgb(159, 106, 228)">
                <div class="inner">
                    <h3>{{  +  $status->abiertos + $status->suspendido + $status->ejecutado + $status->cerrados + $status->en_proceso }}</h3>
                    <p>Total</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('web.dashboard.tickets.index')}}" class="small-box-footer">
                    Ver <i class="fas fa-arrow-circle-right"></i>
                </a>
         </div>
        </div>

    </div>










    <div class="row">
        <figure class="highcharts-figure col-lg-6 col-md-6">
            <div id="estado"></div>
        </figure>


        <figure  class="highcharts-figure col-lg-6 col-md-6">
            <div id="area"></div>
        </figure>
        <figure  class="highcharts-figure col-lg-12 col-md-12">
            <div id="drilldown2"></div>
        </figure>




        <figure class="highcharts-figure col-lg-6 col-md-6">
            <div id="prioridad"></div>
        </figure>

        <figure class="highcharts-figure col-lg-6 col-md-6">
            <div id="realizo"></div>
        </figure>

         <figure class="highcharts-figure col-lg-12 col-md-12">
            <div id="duracion_tcs"></div>
        </figure>

        <figure class="highcharts-figure col-lg-6 col-md-12">
            <div id="promedio"></div>
        </figure>
        </div>





        <script>


                   //Estado
                   var estado=Highcharts.chart('estado', {
                   chart: {
                   type: 'column'
                   },
                   title: {
                   text: '{{ trans('messages.tickets_state') }}'
                   },
                   subtitle: {
                   text: '{{ trans('messages.click_columns') }} {{ trans('messages.type_tickets') }}'
                   },
                   accessibility: {
                   announceNewData: {
                   enabled: true
                   }
                   },
                   xAxis: {
                   type: 'category',
                   title: {
                   text: 'Estado'
                   }
                   },
                   yAxis: {
                   title: {
                   text: 'Total'
                   }

                   },
                   legend: {
                   enabled: false
                   },
                   plotOptions: {
                   series: {
                   borderWidth: 0,
                   dataLabels: {
                   enabled: true,
                   format: '{point.y}'
                   }
                   }
                   },

                   tooltip: {
                   headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                   pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> en total<br />'
                   },

                   series: [
                   {
                   name: "{{ trans('messages.tickets_state') }}",
                   colorByPoint: true,
                   data: [
                   {
                   name: "Abiertos",
                   y: {{ $status->abiertos }},
                   drilldown: "Abiertos"
                   },
                   {
                   name: "Suspendido",
                   y: {{$status->suspendido }},
                   drilldown: "Suspendido"
                   },
                   {
                   name: "En proceso",
                   y: {{$status->en_proceso }},
                   drilldown: "En proceso"
                   },

                   {
                   name: "Ejecutados",
                   y: {{$status->ejecutado}},
                   drilldown: "Ejecutados"
                   },

                   {
                   name: "Cerrados",
                   y: {{$status->cerrados }},
                   drilldown: "Cerrados"
                   }

                   ]
                   }
                   ],
                   drilldown: {
                   series: [
                   {
                   name: "Abiertos",
                   id: "Abiertos",
                   data: [
                   [
                   "Correctivos",
                   {{$abiertos->correctivos}}
                   ],
                   [
                   "Preventivos",
                   {{$abiertos->preventivos}}
                   ],
                   [
                   "Modificaciones",
                   {{$abiertos->modificaciones}}
                   ],
                   [
                   "Mejora continua",
                   {{$abiertos->mejora_continua}}
                   ]
                   ]
                   },
                   {
                   name: "En proceso",
                   id: "En proceso",
                   data: [
                   [
                   "Correctivos",
                   {{$en_proceso->correctivos}}
                   ],
                   [
                   "Preventivos",
                   {{$en_proceso->preventivos}}
                   ],
                   [
                   "Modificaciones",
                   {{$en_proceso->modificaciones}}
                   ]
                   ]
                   },
                   {
                   name: "Cerrados",
                   id: "Cerrados",
                   data: [
                   [
                   "Correctivos",
                   {{$cerrados->correctivos}}
                   ],
                   [
                   "Preventivos",
                   {{$cerrados->preventivos}}
                   ],
                   [
                   "Modificaciones",
                   {{$cerrados->modificaciones}}
                   ]
                   ]
                   }
 

                   ]
                   }
                   });



                    

                //Area
                var area=Highcharts.chart('area', {
                   chart: {
                   type: 'column'
                   },
                   title: {
                   text: '{{ trans('messages.tickets_area') }}'
                   },

                   accessibility: {
                   announceNewData: {
                   enabled: true
                   }
                   },
                   xAxis: {
                   type: 'category',
                   title: {
                   text: 'Area'
                   }
                   },
                   yAxis: {
                   title: {
                   text: 'Total'
                   }

                   },
                   legend: {
                   enabled: false
                   },
                   plotOptions: {
                   series: {
                   borderWidth: 0,
                   dataLabels: {
                   enabled: true,
                   format: '{point.y}'
                   }
                   }
                   },

                   tooltip: {
                   headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                   pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> en total<br />'
                   },

                   series: [
                   {
                   name: "Total",
                   colorByPoint: true,
                   data: [
                   @foreach ($areas as $area)
                   {
                   name: "{{$area->area}}",
                   y: {{ $area->totalareas}},
                   },
                   @endforeach

                   ]
                   }
                   ],

                   });

 

               //drilldown2
               var estado=Highcharts.chart('drilldown2', {
                   chart: {
                   type: 'column'
                   },
                   title: {
                   text: 'Tickets por personal'
                   },
                   subtitle: {
                   text: '{{ trans('messages.click_columns') }} {{ trans('messages.type_tickets') }}'
                   },
                   accessibility: {
                   announceNewData: {
                   enabled: true
                   }
                   },
                   xAxis: {
                   type: 'category',
                   title: {
                   text: 'Personal'
                   }
                   },
                   yAxis: {
                   title: {
                   text: 'Total'
                   }

                   },
                   legend: {
                   enabled: false
                   },
                   plotOptions: {
                   series: {
                   borderWidth: 0,
                   dataLabels: {
                   enabled: true,
                   format: '{point.y}'
                   }
                   }
                   },

                   tooltip: {
                   headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                   pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> en total<br />'
                   },

                   series: [
                   {
                   name: "{{ trans('messages.tickets_state') }}",
                   colorByPoint: true,
                   data: [
                   {
                   name: "Cabos Monalisa",
                   y: {{ $personal_monalisa->Cabos_Monalisa}},
                   drilldown: "Cabos Monalisa"
                   },
                   ]
                   }
                   ],
                   drilldown: {
                   series: [




                   {
                   name: "Cabos Monalisa",
                   id: "Cabos Monalisa",
                   data: [
                       [
                   "Abiertos",
                   {{$Cabos_Monalisa->abiertos}}
                   ],
                   [
                   "En proceso",
                   {{$Cabos_Monalisa->en_proceso}}
                   ],
                   [
                   "Cerrados",
                   {{$Cabos_Monalisa->cerrado}}
                   ],
                   [
                   "Suspendido",
                   {{$Cabos_Monalisa->suspendido}}
                   ],
                   [
                   "ejecutado",
                   {{$Cabos_Monalisa->ejecutado}}
                   ],

                   ]
                   }



                   ]
                   }
                   });





                           //Prioridad

                           var prioridad= Highcharts.chart('prioridad', {
                   chart: {
                   type: 'pie'
                   },
                   title: {
                   text: '{{ trans('messages.tickets_priority') }}'
                   },
                   xAxis: {
                   type: 'category',
                   title: {
                   text: 'Prioridad'
                   }
                   },


                   tooltip: {
                   headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                   pointFormat: '<span style="color:{point.color}">{point.name}</span><br />'
                   },
                   series: [{
                   name: "Total",
                   colorByPoint: true,
                   data: [
                   @foreach ($prioridades as $prioridad)
                   {
                   name: "{{$prioridad->prioridad}} : {{ $prioridad->totalprioridad}}",
                   y: {{ $prioridad->totalprioridad}},
                   },
                   @endforeach
                   ]
                   }],
                   exporting: {
                   showTable: false,
                   csv: {
                   columnHeaderFormatter: function(item, key) {
                   if (!item || item instanceof Highcharts.Axis) {
                   return 'Equipo'
                   } else {
                   return item.name;
                   }
                   }
                   },
                   xls: {
                   columnHeaderFormatter: function(item, key) {
                   if (!item || item instanceof Highcharts.Axis) {
                   return 'Equipo'
                   } else {
                   return item.name;
                   }
                   }
                   }
                   }
                   });



                    //realizo
                    var equipo= Highcharts.chart('realizo', {
                   chart: {
                   type: 'pie'
                   },
                   title: {
                   text: 'Usuarios con tickets solucionados'
                   },
                   xAxis: {
                   type: 'category',
                   title: {
                   text: 'Realizo'
                   }
                   },


                   tooltip: {
                   headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                   pointFormat: '<span style="color:{point.color}">{point.name}</span><br />'
                   },
                   series: [{
                   name: "Total",
                   colorByPoint: true,
                   data: [
                   @foreach ($realizo as $equip)
                   {
                   name: "{{ $equip->totalrealiza}} : {{ $equip->nombre}}  ",
                   y: {{ $equip->totalrealiza}},
                   },
                   @endforeach
                   ]
                   }],
                   exporting: {
                   showTable: false,
                   csv: {
                   columnHeaderFormatter: function(item, key) {
                   if (!item || item instanceof Highcharts.Axis) {
                   return 'Realizo'
                   } else {
                   return item.name;
                   }
                   }
                   },
                   xls: {
                   columnHeaderFormatter: function(item, key) {
                   if (!item || item instanceof Highcharts.Axis) {
                   return 'Realizo'
                   } else {
                   return item.name;
                   }
                   }
                   }
                   }
                   });





            //duracion_tcs
            var area=Highcharts.chart('duracion_tcs', {
               chart: {
               type: 'column'
               },
               title: {
               text: 'Tickets con más duración'
               },

               accessibility: {
               announceNewData: {
               enabled: true
               }
               },
               xAxis: {
               type: 'category',
               title: {
               text: '# Folio'
               }
               },
               yAxis: {
               title: {
               text: 'Duración (días)'
               }

               },
               legend: {
               enabled: false
               },
               plotOptions: {
               series: {
                   point: {
                               events: {
                                   click: function() {
                                       location.href = this.options.url;
                                   }
                               }
                           },
               borderWidth: 0,
               dataLabels: {
               enabled: true,
               format: '{point.y}'
               }
               }
               },

               tooltip: {
               headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
               pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> días <br />'
               },

               series: [
               {
               name: "Ticket",
               colorByPoint: true,
               data: [
               @foreach ($resultados as $tcs)
               {
               name: "#"+"{{$tcs->id}}",
               y: {{ $tcs->dias_transcurridos}} ,
               url: 'https://tickets.sumapp.cloud/dashboard/tickets/'+{{$tcs->id}}
               },
               @endforeach

               ]
               }
               ],

               });










            var area=Highcharts.chart('promedio', {
               chart: {
               type: 'column'
               },
               title: {
               text: 'Tiempo promedio por personal'
               },

               accessibility: {
               announceNewData: {
               enabled: true
               }
               },
               xAxis: {
               type: 'category',
               title: {
               text: 'Personal'
               }
               },
               yAxis: {
               title: {
               text: 'Promedio (días)'
               }

               },
               legend: {
               enabled: false
               },
               plotOptions: {
               series: {
                   point: {
                               events: {
                                   click: function() {
                                       location.href = this.options.url;
                                   }
                               }
                           },
               borderWidth: 0,
               dataLabels: {
               enabled: true,
               format: '{point.y}'
               }
               }
               },

               tooltip: {
               headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
               pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> días <br />'
               },

               series: [
               {
               name: "Ticket",
               colorByPoint: true,
               data: [
               @foreach ($promedio_monalisa as $prm)
               {
               name: "{{$prm->realizo}}",
               y: {{ $prm->promedio}} ,
               url:"https://tickets.sumapp.cloud/dashboard/filtro?nombre="+"{{$prm->realizo}}"+"&Tipo="
               },
               @endforeach

               ]
               }
               ],

               });

 

    

           
           

              
 



               </script>
           @if (auth()->user()->id_empresa==33)
           <script>



           element = document.getElementById('desc');

           element.style.display = 'block';

           function myFunction(key) {

               switch (key) {

                   case 1:

                   var x = document.getElementById("desc");
                   var color = document.getElementById('my_button');
                       if (x.style.display === "block") {
                           color.style.backgroundColor="#007BFF";

                           x.style.display = "none";
                       } else {


                           color.style.backgroundColor="#555555";
                           x.style.display = "block";
                       }

                   break;

                   default:
                       break;
               }



           }

           </script>
           @endif
