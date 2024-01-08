

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
            <a href="{{ route('web.dashboard.filtro_accor',['Estatus'=>'Abierto'])}}" class="small-box-footer">
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
            <a href="{{ route('web.dashboard.filtro_accor',['Estatus'=>'Cancelado'])}}" class="small-box-footer">
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
            <a href="{{ route('web.dashboard.filtro_accor',['Estatus'=>'En proceso'])}}" class="small-box-footer">
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
            <a href="{{ route('web.dashboard.filtro_accor',['Estatus'=>'Cerrado'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $status->validado }}</h3>
                <p>Validado</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_accor',['Estatus'=>'validado'])}}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    </div>

    <div class="row">



        <div class="col-lg-12 col-md-6">
            <div class="small-box" style="background-color:  rgb(159, 106, 228)">
                <div class="inner">
                    <h3>{{  +  $status->abiertos + $status->cancelado  + $status->cerrados + $status->validado  }}</h3>
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
        <figure class="highcharts-figure col-lg-6 col-md-6">
            <div id="prioridad"></div>
        </figure>
        <figure class="highcharts-figure col-lg-12 col-md-12">
            <div id="realizo"></div>
        </figure>
        <figure class="highcharts-figure col-lg-12 col-md-12">
            <div id="area"></div>
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
        name: "Cancelado",
        y: {{$status->cancelado }},
        drilldown: "Cancelado"
        },
        {
        name: "Cerrados",
        y: {{$status->cerrados }},
        drilldown: "Cerrados"
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
        },

        {
        name: "Cierre final",
        id: "Cierre final",
        data: [
        [
        "Correctivos",
        {{$cierrefinal->correctivos}}
        ],
        [
        "Preventivos",
        {{$cierrefinal->preventivos}}
        ],
        [
        "Modificaciones",
        {{$cierrefinal->modificaciones}}
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
        text: 'Personal que realizo'
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
    </script>
