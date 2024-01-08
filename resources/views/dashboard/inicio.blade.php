@extends('adminlte::page')
@section('title', 'Inicio')

@section('content_header')
    <h1>{{ trans('messages.welcome') }}</h1>
@stop


@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if (auth()->user()->id_empresa==33)
                <div class="col text-left">
                <a  class="btn btn-primary" href="{{ route('web.dashboard.tickets.create') }}">
                                    <i class="fas fa-ticket-alt"
                                    aria-hidden="true"></i> Generar Ticket
                                </a>



                       <button   style="padding: .7% 1% " id="my_button" class="button button5" onclick="myFunction(1)">Orden del día</button>


                            </div>
				
				  @elseif(auth()->user()->id_empresa==39)
                            <a  class="btn btn-warning" href="https://checklist.sumapp.cloud/public/login?correo={{auth()->user()->correo}}&contrasena={{auth()->user()->contrasena}}" target="_blank">Equipos</a>
 

                 @endif
                <br>
                <br>


                <div class="col-lg-12 col-md-12">
                    <center>
                        <div class="form-group">

                            <label>{{ trans('messages.filtro_fecha') }}:</label>

                            <div class="input-group-btn">
                                <button type="button" class="btn btn-default" id="daterange-btn" style='width:230px'>

                                    <i class="fa fa-calendar"></i>&nbsp; <span>fecha por defecto</span>

                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <button id='btnDec' type="button" class="btn btn-danger btn-flat"
                                    title='Decrement month'><i class="fas fa-window-minimize"></i></button>
                                <button id='btnInc' type="button" class="btn btn-info btn-flat"
                                    title='Increment month'><i class="fas fa-plus"></i></button>

                            </div>
                        </div>
                    </center>
                </div>
            </div>




              
                    <div id="graficas">


                    </div>
                

                @section('css')

                <link type="text/css" rel="stylesheet" href="{{ asset('css/estilos.css') }}" />

            @stop


    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js"></script>
    <script>
        let año = (new Date).getFullYear();
        let mes = (new Date).getMonth() + 1;
        var start = moment('' + año + '-' + mes + '').startOf('month');
        var end = moment('' + año + '-' + mes + '').endOf('month');

        let mes_inicio = moment().subtract(1, 'month').startOf('month');
        console.log(start);
        var label = '';

        $('#daterange-btn').daterangepicker({
                locale: {
                    format: 'DD MMM YYYY'
                },
                startDate: moment(start),
                endDate: moment(end),
                ranges: {
                    'YTD': [moment().subtract(1, 'days').startOf('year'), moment()],
                    '{{ trans('messages.dias') }}': [moment().subtract(29, 'days'), moment()],
                    '{{ trans('messages.mes') }}': [moment().startOf('month'), moment().endOf('month')],
                    '{{ trans('messages.mespasado') }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                        'month')],
                }
            },
            function(start, end, label) {
                if (isDate(start)) {
                    $('#daterange-btn span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
                    var fecha_inicio = start.format('YYYY-MM-DD');
                    var fecha_fin = end.format('YYYY-MM-DD');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('web.dashboard.filtrograficas') }}",
                        type: 'POST',
                        data: {
                            fecha_inicio: fecha_inicio,
                            fecha_fin: fecha_fin
                        },
                        success: function(response) {
                            $('#graficas').html(response);
                            //alert(response);
                        },
                        error: function(response) {
                            $('#graficas').html(response);
                            alert('Error....!');
                        }
                    });
                }
            });

        $('#btnInc').click(function(e) {
            IncDecMonth('Inc')
        })

        $('#btnDec').click(function(e) {
            IncDecMonth('Dec')
        })

        function isDate(val) {
            //var d = new Date(val);
            //return !isNaN(d.valueOf());
            var d = Date.parse(val);

            return Date.parse(val);

        }

        function IncDecMonth(Action) {
            if (!isDate(start)) {
                start = moment().startOf('month');
            }
            if (Action == 'Inc') {
                start = moment(start).add(1, 'month').startOf('month');
                end = moment(start).endOf('month')
            }
            if (Action == 'Dec') {
                start = moment(start).subtract(1, 'month').startOf('month');
                end = moment(start).endOf('month')
            } else {
                start = moment(start).subtract(0, 'month').startOf('month');
                end = moment(start).endOf('month')
            }
            if (isDate(start)) {
                $('#daterange-btn span').html( mes_inicio.format('YYYY-MM-DD') + ' - ' + end.format('DD-MM-YYYY'));
                var fecha_inicio = mes_inicio.format('YYYY-MM-DD');
                var fecha_fin = end.format('YYYY-MM-DD');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('web.dashboard.filtrograficas') }}",
                    type: 'POST',
                    data: {
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin
                    },
                    success: function(response) {
                        $('#graficas').html(response);
                        //alert(response);
                    },
                    error: function(response) {
                        $('#graficas').html(response);
                        alert('Error....!');
                    }
                });
            }

        }



        IncDecMonth();
    </script>


@stop
