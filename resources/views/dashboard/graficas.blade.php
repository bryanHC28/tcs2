

<div class="row">
<div class="col-lg-3 col-md-6">
    <div class="small-box bg-danger">
        <div class="inner">
            <h3>{{ $status->abiertos }}</h3>
            <p>{{ trans('messages.tickets_open') }}</p>
        </div>
        <div class="icon">
            <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('web.dashboard.filtro',['Estatus'=>trans('messages.abierto')])}}" class="small-box-footer">
            {{ trans('messages.ver') }} <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="small-box bg-warning">
        <div class="inner">
            <h3>{{ $status->en_proceso }}</h3>
            <p>{{ trans('messages.tickets_process') }}</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('web.dashboard.filtro',['Estatus'=>trans('messages.tickets_process')])}}" class="small-box-footer">
            {{ trans('messages.ver') }} <i class="fas fa-arrow-circle-right"></i>
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
        <a href="{{ route('web.dashboard.filtro',['Estatus'=>trans('messages.cerrado')])}}" class="small-box-footer">
            {{ trans('messages.ver') }} <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-lg-3 col-md-6">
    <div class="small-box bg-dark">
        <div class="inner">
            <h3>{{ $status->cierrefinal }}</h3>
            <p>{{ trans('messages.tickets_close_final') }}</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('web.dashboard.filtro',['Estatus'=> trans('messages.tickets_close_final')])}}" class="small-box-footer">
            {{ trans('messages.ver') }}<i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

</div>

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-light">
            <div class="inner">
                <h3>{{ $status->correctivos }}</h3>
                <p>{{ trans('messages.tickets_corrective') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro',['Tipo'=> trans('messages.correctivo')])}}" class="small-box-footer">
                {{ trans('messages.ver') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $status->preventivos }}</h3>
                <p>{{ trans('messages.tickets_preventive') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro',['Tipo'=>  trans('messages.preventivo') ])}}" class="small-box-footer">
                {{ trans('messages.ver') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $status->modificaciones }}</h3>
                <p>{{ trans('messages.tickets_modification') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro',['Tipo'=> trans('messages.tickets_modification')])}}"
                class="small-box-footer">
                {{ trans('messages.ver') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $status->rutinario }}</h3>
                <p>{{ trans('messages.tickets_routine') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro',['Tipo'=>trans('messages.tickets_routine')])}}" class="small-box-footer">
                {{ trans('messages.ver') }}<i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box " style="background-color: rgb(159, 106, 228)">
            <div class="inner">
                <h3  style="color: white">{{ $status->cancelado }}</h3>
                <p style="color: white">{{ trans('messages.cancelado') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{ route('web.dashboard.filtro',['Estatus'=>trans('messages.cancelado')])}}" class="small-box-footer">
                {{ trans('messages.ver') }}<i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-12 col-md-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $status->abiertos + $status->cancelado + $status->en_proceso + $status->cerrados + $status->cierrefinal }}</h3>
                <p>{{ trans('messages.todos') }}</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{ route('web.dashboard.tickets.index')}}" class="small-box-footer">
                {{ trans('messages.ver') }} <i class="fas fa-arrow-circle-right"></i>
            </a>
     </div>
    </div>

</div>





<div class="row">
    <figure class="highcharts-figure col-lg-6 col-md-6">
        <div id="estado"></div>
    </figure>
    <figure class="highcharts-figure col-lg-6 col-md-6">
        <div id="categoria"></div>
    </figure>
    <figure class="highcharts-figure col-lg-6 col-md-6">
        <div id="prioridad"></div>
    </figure>
    <figure class="highcharts-figure col-lg-6 col-md-6">
        <div id="realizo"></div>
    </figure>
    <figure class="highcharts-figure col-lg-12 col-md-12">
        <div id="equipo"></div>
    </figure>
    <figure class="highcharts-figure col-lg-6 col-md-6">
        <div id="aceptado"></div>
    </figure>
    <figure class="highcharts-figure col-lg-6 col-md-6">
        <div id="rechazado"></div>
    </figure>
    <figure class="highcharts-figure col-lg-12 col-md-12">
        <div id="area"></div>
    </figure>
    <figure class="highcharts-figure col-lg-12 col-md-12">
        <div id="personal"></div>
    </figure>
    <figure class="highcharts-figure col-lg-6 col-md-12">
        <div id="duracion_tcs"></div>
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
    text: '{{ trans('messages.estado') }}'
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
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> en total<br />'
    },

    series: [
    {
    name: "{{ trans('messages.tickets_state') }}",
    colorByPoint: true,
    data: [
    {
    name: "{{ trans('messages.abierto') }}",
    y: {{ $status->abiertos}},
    drilldown: "Abiertos"
    },
    {
    name: "{{ trans('messages.tickets_process') }}",
    y: {{$status->en_proceso }},
    drilldown: "En proceso"
    },
    {
    name: "{{ trans('messages.cerrado') }}",
    y: {{$status->cerrados }},
    drilldown: "Cerrados"
    },

    {
    name: "{{ trans('messages.tickets_close_final') }}",
    y: {{$status->cierrefinal}},
    drilldown: "Cierre final"
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

    "{{ trans('messages.tickets_corrective') }}",
    {{$abiertos->correctivos}},

    ],
    [
    "{{ trans('messages.preventivo') }}",
    {{$abiertos->preventivos}}
    ],
    [
    "{{ trans('messages.modificaciones') }}",
    {{$abiertos->modificaciones}}
    ]
    ]
    },
    {
    name: "En proceso",
    id: "En proceso",
    data: [
    [
        "{{ trans('messages.tickets_corrective') }}",
    {{$en_proceso->correctivos}}
    ],
    [
        "{{ trans('messages.preventivo') }}",
    {{$en_proceso->preventivos}}
    ],
    [
        "{{ trans('messages.modificaciones') }}",
    {{$en_proceso->modificaciones}}
    ]
    ]
    },
    {
    name: "Cerrados",
    id: "Cerrados",
    data: [
    [
        "{{ trans('messages.tickets_corrective') }}",
    {{$cerrados->correctivos}}
    ],
    [
        "{{ trans('messages.preventivo') }}",
    {{$cerrados->preventivos}}
    ],
    [
        "{{ trans('messages.modificaciones') }}",
    {{$cerrados->modificaciones}}
    ]
    ]
    },

    {
    name: "Cierre final",
    id: "Cierre final",
    data: [
    [
        "{{ trans('messages.tickets_corrective') }}",
    {{$cierrefinal->correctivos}}
    ],
    [
        "{{ trans('messages.preventivo') }}",
    {{$cierrefinal->preventivos}}
    ],
    [
        "{{ trans('messages.modificaciones') }}",
    {{$cierrefinal->modificaciones}}
    ]
    ]
    }


    ]
    }
    });



    //Categoria

    var categoria=Highcharts.chart('categoria', {
    chart: {
    type: 'pie'
    },
    title: {
    text: '{{ trans('messages.tickets_category') }}'
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
    
    {
    name: "{{ $categorias[0]->categoria ?? ' Sin registro' }} : {{ $categorias[0]->totalcategorias ?? ' 0'  }} ",
    y: {{ $categorias[0]->totalcategorias ?? ' 0'  }} ,
    },
    {
    name: " {{ trans('messages.electrico') ?? ' Sin registro' }} : {{ $categorias[1]->totalcategorias ?? ' 0' }} ",
    y: {{ $categorias[1]->totalcategorias ?? ' 0' }} ,
    },
    {
    name: " {{ trans('messages.instrumentacion') ?? ' Sin registro' }} : {{ $categorias[2]->totalcategorias  ?? ' 0' }} ",
    y: {{ $categorias[2]->totalcategorias ?? ' 0' }},
    },
    {
    name: " {{ trans('messages.mecanica') ?? ' Sin registro' }} : {{ $categorias[3]->totalcategorias ?? ' 0' }} ",
    y: {{ $categorias[3]->totalcategorias ?? ' 0' }},
    },
    {
    name: " {{ trans('messages.seguridad') ?? ' Sin registro' }} : {{ $categorias[4]->totalcategorias ?? ' 0' }} ",
    y: {{ $categorias[4]->totalcategorias ?? ' 0' }},
    }
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
    
    {
    name: "{{ trans('messages.alta') ?? ' Sin registro' }} : {{ $prioridades[0]->totalprioridad ?? ' 0'}}",
    y: {{ $prioridades[0]->totalprioridad ?? ' 0'}},
    },

    {
    name: "{{ trans('messages.baja') ?? ' Sin registro' }} : {{ $prioridades[1]->totalprioridad ?? ' 0'}}",
    y: {{ $prioridades[1]->totalprioridad ?? ' 0'}},
    },
    {
    name: "{{ trans('messages.media') ?? ' Sin registro' }} : {{ $prioridades[2]->totalprioridad ?? ' 0'}}",
    y: {{ $prioridades[2]->totalprioridad ?? ' 0'}},
    }
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
    text: '{{ trans('messages.top10') }}'
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

//Equipo

var equipo= Highcharts.chart('equipo', {
    chart: {
    type: 'pie'
    },
    title: {
    text: '{{ trans('messages.top10inc') }}' 
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
//aceptado
var personal= Highcharts.chart('aceptado', {
    chart: {
    type: 'column'
    },
    title: {
    text: '{{ trans('messages.aceptadox') }}'   
    },

    accessibility: {
    announceNewData: {
    enabled: true
    }
    },
    xAxis: {
    type: 'category',
    title: {
    text: '{{ trans('messages.aceptado') }}'
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
    @foreach ($aceptados as $aceptado)
    {
    name: "{{$aceptado->usuario}}",
    y: {{ $aceptado->totalusuario}},
    },
    @endforeach

    ]
    }
    ],

    });



//rechazado
var personal= Highcharts.chart('rechazado', {
    chart: {
    type: 'column'
    },
    title: {
    text: '{{ trans('messages.rechazadox') }}'    
    },

    accessibility: {
    announceNewData: {
    enabled: true
    }
    },
    xAxis: {
    type: 'category',
    title: {
    text: '{{ trans('messages.rechazado') }}'
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
    @foreach ($rechazados as $rechazado)
    {
    name: "{{$rechazado->usuario}}",
    y: {{ $rechazado->totalusuario}},
    },
    @endforeach

    ]
    }
    ],

    });

 //duracion_tcs
 var area=Highcharts.chart('duracion_tcs', {
    chart: {
    type: 'column'
    },
    title: {
    text:'{{ trans('messages.duracionx') }}' 
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



    //area
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


     //Personal
     var personal= Highcharts.chart('personal', {
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
    text: '{{ trans('messages.personal') }}'
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

</script>
