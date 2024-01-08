

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-light">
            <div class="inner">
                <h3>{{ $status->abiertos }}</h3>
                <p>{{ trans('messages.tickets_open') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_proyectos9',['Estatus'=>'Abierto'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3  style="color: white">{{ $status->cancelado }}</h3>
                <p style="color: white">Cancelado</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_proyectos9',['Estatus'=>'Cancelado'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $status->ejecutado }}</h3>
                <p>Ejecutados</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_proyectos9',['Estatus'=>'Ejecutado' ])}}" class="small-box-footer">
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
            <a href="{{ route('web.dashboard.filtro_proyectos9',['Estatus'=>'Cerrado' ])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $status->vencido }}</h3>
                <p>Vencidos</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_proyectos9',['estado'=>'Vencido'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    </div>

    <div class="row">



        <div class="col-lg-12 col-md-6">
            <div class="small-box" style="background-color:  rgb(159, 106, 228)">
                <div class="inner">
                    <h3>{{   $status->abiertos + $status->cancelado + $status->ejecutado + $status->cerrados  }}</h3>
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




    <hr>

    <div id="desc">
    <div class="pb-2">
        <div class="row">
    <div class="col-12 col-md-6 mb-3">

        <h5>Orden del día   &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
    {{-- <a href="{{ route('web.dashboard.filtro_proyectos9',['fecha'=>'orden'])}}" class="btn btn-primary">Ver más</a> --}}
<br>Total:  {{$totales->orden}}</h5>
        <table style="width: 90%" style="width: 80%" class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Persona</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orden as $ordenes)
                <tr>
                <td class="service">{{$ordenes->id}}</td>
                <td class="desc">{{$ordenes->accion}}</td>
                <td class="unit">{{$ordenes->estado}}</td>
                <td class="unit">{{$ordenes->realizo}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>


    </div>
    <div class="col-12 col-md-6 mb-3">
        <h5>Vencidos{{" (8 días previos)"}}      &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;
            &nbsp;

    {{-- <a href="{{ route('web.dashboard.filtro_proyectos9',['fecha'=>'vencio'])}}" class="btn btn-primary">Ver más</a> --}}
    <br>Total:  {{$totales->vencidos}}</h5></h5>
        <table style="width: 90%" class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Persona</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vencidos as $vencido)
                <tr>
                <td >{{$vencido->id}}</td>
                <td >{{$vencido->accion}}</td>
                <td >{{$vencido->estado}}</td>
                <td >{{$vencido->realizo}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>
</div>
    </div>



    <hr>








    <div class="row">
        <figure class="highcharts-figure col-lg-6 col-md-6">
            <div id="estado"></div>
        </figure>

        @if(auth()->user()->id_sucursal==200)

        <figure  class="highcharts-figure col-lg-6 col-md-6">
            <div id="drilldown"></div>
        </figure>
        @endif
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



 //duracion_tcs
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
    @foreach ($promedio as $prm)
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
        name: "Cancelado",
        y: {{$status->cancelado }},
        drilldown: "Cancelado"
        },
        {
        name: "Cerrados",
        y: {{$status->cerrados }},
        drilldown: "Cerrados"
        },

        {
        name: "Ejecutados",
        y: {{$status->ejecutado}},
        drilldown: "Ejecutados"
        },


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



        @if(auth()->user()->id_sucursal==200)

          //drilldown
          var estado=Highcharts.chart('drilldown', {
        chart: {
        type: 'column'
        },
        title: {
        text: 'Tickets por area'
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
        name: "{{ trans('messages.tickets_state') }}",
        colorByPoint: true,
        data: [

        {
        name: "Cuauhtémoc comercial",
        y: {{$areas_proyectos9->plaza_comercial }},
        drilldown: "Plaza comercial"
        },
        {
        name: "Cuauhtémoc residencial",
        y: {{$areas_proyectos9->residencial }},
        drilldown: "Residencial"
        },

        ]
        }
        ],
        drilldown: {
        series: [

        {
        name: "Plaza comercial",
        id: "Plaza comercial",
        data: [
            [
        "Abiertos",
        {{$plaza_comercial->abiertos}}
        ],
        [
        "En Ejecutado",
        {{$plaza_comercial->en_proceso}}
        ],
        [
        "Cerrados",
        {{$plaza_comercial->cerrado}}
        ],
        [
        "Cancelado",
        {{$plaza_comercial->cancelado}}
        ],

        ]
        },
        {
        name: "Residencial",
        id: "Residencial",
        data: [
            [
        "Abiertos",
        {{$residencial->abiertos}}
        ],
        [
        "Ejecutado",
        {{$residencial->en_proceso}}
        ],
        [
        "Cerrados",
        {{$residencial->cerrado}}
        ],
        [
        "Cancelado",
        {{$residencial->cancelado}}
        ]
        ]
        }


        ]
        }
        });
@endif
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
        name: "Cristina Herrera",
        y: {{ $personal_proyectos9->cristina_herrera}},
        drilldown: "Cristina Herrera"
        },

        {
        name: "Rocio Salazar",
        y: {{$personal_proyectos9->rocio_salazar }},
        drilldown: "Rocio Salazar"
        },
        {
        name: "Elias Quiñones",
        y: {{$personal_proyectos9->elias }},
        drilldown: "Elias Quiñones"
        },
        {
        name: "Reynaldo García",
        y: {{$personal_proyectos9->rey }},
        drilldown: "Reynaldo García"
        },
        ]
        }
        ],
        drilldown: {
        series: [
            {
        name: "Reynaldo García",
        id: "Reynaldo García",
        data: [
        [
        "Abiertos",
        {{$rey->abiertos}}
        ],
        [
        "En proceso",
        {{$rey->en_proceso}}
        ],
        [
        "Cerrados",
        {{$rey->cerrado}}
        ],
        [
        "Cancelado",
        {{$rey->cancelado}}
        ],
        [
        "Terminado",
        {{$rey->terminado}}
        ],
        [
        "Pausado",
        {{$rey->pausado}}
        ]
        ]
        },

        
        {
        name: "Cristina Herrera",
        id: "Cristina Herrera",
        data: [
        [
        "Abiertos",
        {{$cristina_herrera->abiertos}}
        ],
        [
        "En proceso",
        {{$cristina_herrera->en_proceso}}
        ],
        [
        "Cerrados",
        {{$cristina_herrera->cerrado}}
        ],
        [
        "Cancelado",
        {{$cristina_herrera->cancelado}}
        ],
        [
        "Terminado",
        {{$cristina_herrera->terminado}}
        ],
        [
        "Pausado",
        {{$cristina_herrera->pausado}}
        ]
        ]
        },

        {
        name: "Rocio Salazar",
        id: "Rocio Salazar",
        data: [
            [
        "Abiertos",
        {{$rocio_salazar->abiertos}}
        ],
        [
        "En proceso",
        {{$rocio_salazar->en_proceso}}
        ],
        [
        "Cerrados",
        {{$rocio_salazar->cerrado}}
        ],
        [
        "Cancelado",
        {{$rocio_salazar->cancelado}}
        ],
        [
        "Terminado",
        {{$rocio_salazar->terminado}}
        ],
        [
        "Pausado",
        {{$rocio_salazar->pausado}}
        ]
        ]
        },
        {
        name: "Elias Quiñones",
        id: "Elias Quiñones",
        data: [
            [
        "Abiertos",
        {{$elias->abiertos}}
        ],
        [
        "En proceso",
        {{$elias->en_proceso}}
        ],
        [
        "Cerrados",
        {{$elias->cerrado}}
        ],
        [
        "Cancelado",
        {{$elias->cancelado}}
        ],
        [
        "Terminado",
        {{$elias->terminado}}
        ],
        [
        "Pausado",
        {{$elias->pausado}}
        ]
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


 duracion_tcs
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


    //Equipo

    var equipo= Highcharts.chart('equipo', {
        chart: {
        type: 'pie'
        },
        title: {
        text: '{{ trans('messages.tickets_equipment') }}'
        },
        xAxis: {
        type: 'category',
        title: {
        text: 'Equipo'
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
        @foreach ($equipos as $equipo)
        {
        name: "{{$equipo->inventario}} : {{ $equipo->totalequipos}}",
        y: {{ $equipo->totalequipos}},
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


         //promedio
         var personal= Highcharts.chart('promedio', {
        chart: {
        type: 'column'
        },
        title: {
        text: '{{ trans('messages.tickets_staff') }}'
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
        name: "Total",
        colorByPoint: true,
        data: [
        @foreach ($personales as $personal)
        {
        name: "{{$personal->usuario}}",
        y: {{ $personal->totalpersonal}},
        },
        @endforeach

        ]
        }
        ],

        });


    //     var area=Highcharts.chart('duracion_tcs', {
    // chart: {
    // type: 'column'
    // },
    // title: {
    // text: 'Tickets con más duración'
    // },

    // accessibility: {
    // announceNewData: {
    // enabled: true
    // }
    // },
    // xAxis: {
    // type: 'category',
    // title: {
    // text: '# Folio'
    // }
    // },
    // yAxis: {
    // title: {
    // text: 'Duración (días)'
    // }

    // },
    // legend: {
    // enabled: false
    // },
    // plotOptions: {
    // series: {
    //     point: {
    //                 events: {
    //                     click: function() {
    //                         location.href = this.options.url;
    //                     }
    //                 }
    //             },
    // borderWidth: 0,
    // dataLabels: {
    // enabled: true,
    // format: '{point.y}'
    // }
    // }
    // },

    // tooltip: {
    // headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    // pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> días <br />'
    // },

    // series: [
    // {
    // name: "Ticket",
    // colorByPoint: true,
    // data: [
    // @foreach ($resultados as $tcs)
    // {
    // name: "#"+"{{$tcs->id}}",
    // y: {{ $tcs->dias_transcurridos}} ,
    // url: 'https://tickets.sumapp.cloud/dashboard/tickets/'+{{$tcs->id}}
    // },
    // @endforeach

    // ]
    // }
    // ],

    // });




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
