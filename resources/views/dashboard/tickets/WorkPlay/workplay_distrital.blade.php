<div class="row">


    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $status->atendidos }}</h3>
                <p>Atendidos</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_workplay', ['Estatus' => 'Atendido.']) }}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 style="color: white">{{ $status->en_proceso_lsm }}</h3>
                <p style="color: white">En proceso</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_workplay', ['Estatus' => 'En proceso']) }}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-dark">
            <div class="inner">
                <h3>{{ $status->no_atendidos }}</h3>
                <p>No atendido</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro_workplay', ['Estatus' => 'No atendido']) }}" class="small-box-footer">
                Ver <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box" style="background-color:  rgb(159, 106, 228)">
            <div class="inner">
                <h3>{{ $status->atendidos + $status->en_proceso_lsm + $status->no_atendidos }}</h3>
                <p>Total</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('web.dashboard.tickets.index') }}" class="small-box-footer">
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
            <div id="sucursales_lsm_chart"></div>
        </figure>
    <figure class="highcharts-figure col-lg-6 col-md-6">
        <div id="categoria"></div>
    </figure>
    <figure class="highcharts-figure col-lg-6 col-md-12">
        <div id="duracion_tcs"></div>
    </figure>
    <figure class="highcharts-figure col-lg-6 col-md-6">
        <div id="categorias_all"></div>
    </figure>
    <figure class="highcharts-figure col-lg-6 col-md-6">
        <div id="area"></div>
    </figure>
    <figure class="highcharts-figure col-lg-12 col-md-12">
        <div id="container"></div>
         
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
         name: "No atendidos",
         y: {{ $status->no_atendidos }},
         drilldown: "No atendidos"
         },
         {
         name: "En proceso",
         y: {{ $status->en_proceso_lsm }},
         drilldown: "En proceso"
         },
         {
         name: "Atendidos",
         y: {{$status->atendidos }},
         drilldown: "Atendidos"
         },
 
         ]
         }
         ],
       
         });
 






         
        

//sucursales_lsm_chart
var personal= Highcharts.chart('sucursales_lsm_chart', {
    chart: {
    type: 'column'
    },
    title: {
    text: "Top 5 sucursales con mayor incidencias en SURESTE"   
    },

    accessibility: {
    announceNewData: {
    enabled: true
    }
    },
    xAxis: {
    type: 'category',
    title: {
    text: 'Sucursales'
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
    @foreach($sucursales_lsm as $s)
    {
    name: "{{   $s->sucursal  }}",
    y: {{ $s->conteo}},
    },
    @endforeach

    ]
    }
    ],

    });




    
    
    //Categoria

    var categoria=Highcharts.chart('categoria', {
    chart: {
    type: 'pie'
    },
    title: {
    text: 'Top 5 categorías con mayor incidencias'
    },
    xAxis: {
    type: 'category',
    title: {
    text: 'Categoria'
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
    @foreach($categorias_lsm as $c)
    {
    name: "{{   $c->categoria  }} : {{ $c->conteo }}",
    y: {{ $c->conteo}},
    },
    @endforeach

    ]


    }],
    exporting: {
    showTable: false,
    csv: {
    columnHeaderFormatter: function(item, key) {
    if (!item || item instanceof Highcharts.Axis) {
    return 'Categoria'
    } else {
    return item.name;
    }
    }
    },
    xls: {
    columnHeaderFormatter: function(item, key) {
    if (!item || item instanceof Highcharts.Axis) {
    return 'Categoria'
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
    text:'Top 10 tickets con mayor duración (SURESTE)' 
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
    @foreach ($resultados_lsm as $tcs)
    {
    name: "#"+"{{$tcs->id}}  ({{$tcs->sucursal}})",
    y: {{ $tcs->dias_transcurridos}} ,
    url: 'https://tickets.sumapp.cloud/dashboard/tickets/'+{{$tcs->id}}
    },
    @endforeach

    ]
    }
    ],

    });


//sucursales_lsm_chart
var personal= Highcharts.chart('categorias_all', {
    chart: {
    type: 'column'
    },
    title: {
    text: 'Categorías (Todas)'   
    },

    accessibility: {
    announceNewData: {
    enabled: true
    }
    },
    xAxis: {
    type: 'category',
    title: {
    text: 'Sucursales'
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
    @foreach($categorias_all as $ca)
    {
    name: "{{   $ca->categoria  }}",
    y: {{ $ca->conteo}},
    },
    @endforeach

    ]
    }
    ],

    });

    

    //area

    var categoria=Highcharts.chart('area', {
    chart: {
    type: 'pie'
    },
    title: {
    text: 'Áreas con incidencias'
    },
    xAxis: {
    type: 'category',
    title: {
    text: 'Categoria'
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
    @foreach($areas_lsm as $ar)
    {
    name: "{{   $ar->area  }} : {{ $ar->totalareas }}",
    y: {{ $ar->totalareas}},
    },
    @endforeach

    ]


    }],
    exporting: {
    showTable: false,
    csv: {
    columnHeaderFormatter: function(item, key) {
    if (!item || item instanceof Highcharts.Axis) {
    return 'Categoria'
    } else {
    return item.name;
    }
    }
    },
    xls: {
    columnHeaderFormatter: function(item, key) {
    if (!item || item instanceof Highcharts.Axis) {
    return 'Categoria'
    } else {
    return item.name;
    }
    }
    }
    }
    });


    




    Highcharts.chart('container', {
    title: {
        text: 'Sucursales SURESTE (todas)',
        align: 'left'
    },
    yAxis: {
        title: {
            text: '# Incidencias'
        }
    },
    xAxis: {
        accessibility: {
            rangeDescription: 'Range: 2010 to 2024'
        },
        categories: [
            @foreach($sucursales_lsm_all as $s)
                "{{ $s->sucursal }}",
            @endforeach
        ]
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
        }
    },
    series: [{
        name: 'Incidencias',
        data: [
            @foreach($sucursales_lsm_all as $s)
                {{ $s->conteo }},
            @endforeach
        ]
    }],
    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }
});
 </script>