<input hidden type="text" id="logueado" value="{{ auth()->user()->nombre . ' ' . auth()->user()->apellido }}">
<input hidden type="text" id="tipo" value="{{ auth()->user()->rol_tickets }}">
@if (!empty($fecha))
<input hidden type="text" id="var_fecha" value="{{ $fecha }}">
@else
<input hidden type="text" id="var_fecha" value="inicial">
<div class="form-group mb-2">
    <div class="input-group-btn">
        <button type="button" class="btn btn-primary" id="daterange-btn-{{ $id }}">
            <i class="far fa-calendar-alt"></i>
            <span>{{ trans('messages.fecha') }} </span>
            <i class="fa fa-caret-down"></i>
        </button>
    </div>
</div>
@endif
<div>

    <div class="py-2">


        <table id="{{ $id }}DataTable" style="font-size:14px" class="table table-hover " style="width: 100%">
            {!! $slot !!}
        </table>
    </div>
    <style>
        .row-link {
            cursor: pointer;
        }

        .row-link:hover {
            color: #0097bd;
            font-weight: 800;
        }
    </style>

    @section('js_component')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/2.1.25/daterangepicker.min.js"></script>
        <script>
            function toUrl(href) {
                window.location.href = href;
            }

            $(document).ready(() => {
                @if (isset($visibilidadColumnasExportar))
                    var visibilidadColumnasExportar = {!! json_encode($visibilidadColumnasExportar) !!};
                    var columnasVisibles = [];
                    var columnasNoVisibles = [];
                    visibilidadColumnasExportar.forEach((obj) => {
                        if (obj.visible == 1) {
                            columnasVisibles.push(obj.columna);
                        } else {
                            columnasNoVisibles.push(obj.columna);
                        }
                    });
                @endif
                let idioma{{ $id }}DataTable = {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": '{{ trans('messages.Sinresultados') }}',
                    "sEmptyTable": "Ningun dato disponible en esta tabla",
                    "sInfo": '{{ trans('messages.mostrando') }} _START_ {{ trans('messages.al') }} _END_ {{ trans('messages.totalde') }} _TOTAL_ {{ trans('messages.registros') }}',
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": '{{ trans('messages.search') }}',
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "ÃƒÅ¡ltimo",
                        "sNext": '{{ trans('messages.next') }}',
                        "sPrevious": '{{ trans('messages.previus') }}'
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": '{{ trans('messages.copiar') }}',
                        "colvis":  '{{ trans('messages.visibilidad') }}',
                        "copyTitle": '{{ trans('messages.copiada') }}',
                        "copyKeys": 'Use your keyboard or menu to select the copy command',
                        "copySuccess": {
                            "_": '%d {{ trans('messages.copiadas') }}',
                            "1": '{{ trans('messages.unocopiadas') }} '
                        },
                        "pageLength": {
                            "_": "Mostrar %d filas",
                            "-1": '{{ trans('messages.todos') }}'
                        }
                    }
                };

                Loader.show();


                const nombre = document.getElementById("var_fecha").value;
                const tipo = document.getElementById("tipo").value;
                console.log(nombre);


                var asset = '{{ asset('') }}';
                var url = asset + 'dashboard/tcs_json/' + nombre;


                console.log(url);

                $.ajax({

                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
 
                        var rutaver = "{{ asset('dashboard/tickets') }}";
                        const modal = document.getElementById("modal");

                        var rutaaceptar = "{{ asset('dashboard') }}"
                        var rutaedit = "{{ asset('dashboard/tickets') }}";
                        var rutatcs = "{{ asset('dashboard/generarPDF') }}";
                        let label = '';
                        var datos = [];
                        var acciones = "";
                        $.each(data, function(i, item) {
                            
                            if (item.estatus == "Cierre final" ||  tipo=="Usuario" )
                                acciones = "<a href='javascript:void(0)' onclick='ver_ticket(" +
                                item
                                .id +
                                "),Loader.show();' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a>";
                            else
                                acciones = "<a href='javascript:void(0)' onclick='ver_ticket("+item.id+ "),Loader.show();' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a> <a href='" +
                                rutaedit + "/" + item.id + "/edit" +
                                "' class='btn btn-primary btn-sm'><i class='fas fa-pencil-alt'></i></a> <a href='" +
                                    rutatcs + "/" + item.id +
                                    "' class='btn btn-danger btn-sm'><i class='fas fa-ticket-alt'></i></a> <a href='javascript:void(0)' onclick='edit_ticket(" +
                                item.id +
                                "),Loader.show();' class='btn btn-warning btn-sm'><i class='fas fa-external-link-alt'></i></a> ";





                            switch (item.prioridad) {
                                case "Alta":
                                    item.prioridad =
                                        "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.alta') }}'+"</span>";
                                    break;
                                case "Media":
                                    item.prioridad =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.media') }}'+"</span>";
                                    break;
                                case "Baja":
                                    item.prioridad =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.baja') }}'+"</span>";
                                    break;
                            }
                            switch (item.estatus) {
                                case "Cerrado":
                                    item.estatus =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.cerrado') }}'+"</span>";

                                    break;
                                case "Abierto":
                                    item.estatus =
                                        "<span class='badge badge-primary badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.abierto') }}'+"</span>";
                                    break;
                                case "Cancelado":
                                    item.estatus =
                                        "<span class='badge badge-dark badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.cancelado') }}'+"</span>";
                                    break;
                                case "Cierre final":

                                    item.estatus =
                                        "<span class='badge badge-secondary badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.tickets_close_final') }}'+"</span>";
                                    break;                                                         
                                case "En proceso":
                                    item.estatus =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.proceso') }}'+"</span>";
                                    break;
                                    
                            }
                            switch (item.tipo_ticket) {
                                case "Preventivo":
                                    item.tipo_ticket =
                                        "<span class='badge badge-info badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.preventivo') }}'+"</span>";
                                    break;
                                case "Correctivo":
                                    item.tipo_ticket =
                                        "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.correctivo') }}'+"</span>";
                                    break;
                                case "Mejora continua":
                                    item.tipo_ticket =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.mejora') }}'+"</span>";
                                    break;
                                case "Modificaciones":
                                    item.tipo_ticket =
                                        "<span class='badge badge-dark badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.modificaciones') }}'+"</span>";
                                    break;
                                case "Rutinario":
                                    item.tipo_ticket =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.rutinario') }}'+"</span>";
                                    break;
                            }
                            switch (item.estado) {
                                case "Rechazado":
                                    item.estado =
                                        "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.rechazado') }}'+"</span>";
                                    break;
                                case "Aceptado":
                                    item.estado =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.aceptado') }}'+"</span>";
                                    break;
                              
                                case "En proceso":
                                    item.estado =
                                        "<span class='badge badge-primary badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.tickets_process') }}'+"</span>";
                                    break;
                                case null:
                                    item.estado =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.revision') }}'+"</span>";
                                    break;
                            }

                            if (item.realizo != null) {
                                item.realizo =
                                    "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>" +
                                    item.realizo + "</span>";
                            } else {
                                item.realizo =
                                    "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.sin_registro') }}'+"</span>";
                            }

                            if (item.falla != null) {
                                item.falla =
                                    "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>" +
                                    item.falla + "</span>";
                            } else {
                                item.falla =
                                    "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>"+'{{ trans('messages.sin_registro') }}'+"</span>";
                            }



                            item.evidenciaInicial = "https://tickets.sumapp.cloud/evidencias/" +
                                item.evidenciaInicial;

                              
  
                            const nombre = document.getElementById("logueado").value;


                            if (item.usuario == nombre)
                                pilot =
                                "<a class='btn btn-sm' style='background-color: #23805c' onclick='Loader.show();'  href='" +
                                rutaaceptar + "/ajax_success/" + item.id +
                                "'> <i style='color: #ffffff' class='fas fa-check'></i></a> <a href='javascript:void(0)' onclick='rechazar_ticket(" +
                                item.id +
                                ")' style='background-color: #940b0b'  class='btn  btn-sm' type='button'>  <i  style='color: #ffffff' class='fas fa-times'></i></a>";
                            else
                                pilot = "";
                           

                                let fecha1 = moment(item.fecha_estimada);
                            let fecha2 = moment(item.close_at);
                            let fecha3 = fecha2.diff(fecha1, 'days');
                            if(fecha3 == 0){
                                fecha3 = fecha2.diff(fecha1, 'h') + " horas";
                            }else{
                            fecha3 = fecha2.diff(fecha1, 'h')/24 ;
                           fecha3 = Number(fecha3).toFixed(1) + " días";
                        }


                        if (item.evidencia_inicial_multiple != null) {
                        if ((item.evidencia_inicial_multiple).length == 2 ) {
                            foto="<a href='javascript:void(0) '><i style='color: rgb(170, 17, 17)' class='fas fa-eye-slash'></i></a> ";
                            } else {
                              let ei=  JSON.parse(item.evidencia_inicial_multiple);
                              let i=0;
                                               
                              foto="<a href='https://fotostickets.sumapp.cloud/pilotchemical/" + ei[i] + "'" + "data-lightbox='models',Loader.show();' data-title='Folio: "+item.id+"<br> Autor: "+item.usuario +"<br> Descripcion: "+item.ticket_descripcion +"'><i style='color: rgb(236, 186, 120)' class='fas fa-folder'></i></a> ";
                            
                         
                        }
                    }
                                datos.push({
                                    "idticket": item.id,
                                    "fecha": item.created_at.substring(0, 10),
                                    "prioridad": item.prioridad,
                                    "transmitio": item.transmitio ?? '{{ trans('messages.sin_registro') }}',
                                    "nombre": item.usuario ?? '{{ trans('messages.sin_registro') }}',
                                    "area": item.area ?? '{{ trans('messages.sin_registro') }}',
                                    "categoria": item.categoria ?? '{{ trans('messages.sin_registro') }}',
                                    "estatus": item.estatus ?? '{{ trans('messages.sin_registro') }}',
                                    "fecha_estimada": item.fecha_estimada,
                                    "fecha_cierre": item.close_at,
                                    "prioridad": item.prioridad,
                                    "tipo_tcs": item.tipo_ticket,
                                    "equipo": item.inventario,
                                    "usuario": item.usuario,
                                    "estado": item.estado ?? '{{ trans('messages.sin_registro') }}',
                                    "realizo": item.realizo ?? '{{ trans('messages.sin_registro') }}',
                                    "dias" : fecha3,
                                    "falla": item.falla ?? '{{ trans('messages.sin_registro') }}',                                    
                                    "acciones": acciones,
                                    "pilot": pilot,
                                    "descripcion": item.ticket_descripcion,
                                    "trabajo_ing": item.observaciones,
                                    "foto":foto,

                                });

                        });


                        
                            let {{ $id }}DataTable = $('#{{ $id }}DataTable')
                                .DataTable({

                                    data: datos,
                                    columns: [
                                     
                                        {
                                        
                                            title: '{{ trans('messages.folio') }}',
                                            data: 'idticket' 
                                      
                                        },
                                        {
                                            title: '{{ trans('messages.creacion') }}',
                                            data: 'fecha'
                                        },
                                        {
                                            title:'{{ trans('messages.mantto') }}',
                                            data: 'fecha_estimada'
                                        },
                                        {
                                            title:'{{ trans('messages.cierre') }}',
                                            data: 'fecha_cierre'
                                        },
                                        {
                                            title: '{{ trans('messages.edo') }}',
                                            data: 'estatus'
                                        },
                                        {
                                            title: '{{ trans('messages.prioridad') }}',
                                            data: 'prioridad'
                                        },
                                        {
                                            title: "Area",
                                            data: 'area'
                                        },
                                        {
                                            title: '{{ trans('messages.categor') }}',
                                            data: 'categoria'
                                        },
                                        {
                                            title:  '{{ trans('messages.tip') }}',
                                            data: 'tipo_tcs'
                                        },
                                        {
                                            title: "Duración",
                                            data: 'dias'
                                        },
                                        {
                                            title: '{{ trans('messages.equipo') }}',
                                            data: 'equipo'
                                        },
                                        {
                                            title: '{{ trans('messages.usuario') }}',
                                            data: 'usuario'
                                        },
                                        {
                                            title: '{{ trans('messages.realizado') }}',
                                            data: 'realizo'
                                        },
                                        {
                                            title:'{{ trans('messages.foto') }}',
                                            data: 'foto'
                                        },
                                        {
                                            title: '{{ trans('messages.motivo') }}',
                                            data: 'falla'
                                        }, 
                                        {
                                            title: 'Descripcion',
                                            data: 'descripcion',
                                            visible: false
                                        },
                                        {
                                            title: 'Trabajo por ing. y mantto',
                                            data: 'trabajo_ing',
                                            visible: false
                                        },


                                        {

                                            title: '{{ trans('messages.accion') }}',
                                            data: 'acciones'
                                        },

                                        {
                                            title: '{{ trans('messages.acept') }}',
                                            data: 'pilot'
                                        },
                                        {
                                            title: '{{ trans('messages.condicion') }}',
                                            data: 'estado'
                                        }
                                    ],
                                    createdRow: function(row, data, indice) {
                                        
                                       
                                        $(row).find("td:eq(4)").attr('id', "estatus" + data
                                            .idticket);
                                        $(row).find("td:eq(5)").attr('id', "prioridad" + data
                                            .idticket);
                                        $(row).find("td:eq(8)").attr('id', "tipo" + data.idticket);

                                        if (data.categoria == "Seguridad") {
                                            $(row).find("td").css('background-color', '#e89f9f');
                                        }


                                    },
                                    "responsive": true,
                                    "language": idioma{{ $id }}DataTable,
                                    "order": [],
                                    "paging": {{ $paging ?? 'true' }},
                                    "lengthChange": true,
                                    columnDefs: [{
                                        orderable: false,
                                        targets: {!! json_encode($disableSort ?? []) !!}
                                    }],
                                    "searching": true,
                                    "scrollX": true,
                                    "info": true,
                                    "autoWidth": false,

                                    dom: 'Bfrtip',
                                    buttons: [{
                                            extend: 'copy',
                                            @if (isset($visibilidadColumnasExportar))
                                                exportOptions: {
                                                    columns: columnasVisibles
                                                }
                                            @endif
                                        },
                                        {
                                            extend: 'excel',
                                            @if (isset($visibilidadColumnasExportar))
                                                exportOptions: {
                                                    columns: columnasVisibles
                                                }
                                            @endif
                                        },
                                        {
                                            extend: 'pdf',
                                            orientation: 'landscape',
                                            @if (isset($visibilidadColumnasExportar))
                                                exportOptions: {
                                                    columns: columnasVisibles
                                                }
                                            @endif
                                        },
                                        {
                                            extend: 'colvis',
                                            columns: ':not(".select-disabled")'
                                        }
                                    ],

                                    "lengthMenu": [
                                        [7, 10, 30, 31, -1],
                                        [7, 10, 30, 31, "Mostrar Todo"]
                                    ],
                                });
                

                        $('.status-dropdown').on('change', function(e) {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            $('.status-dropdown').val(status)
                                dataTable.column(4).search(status).draw();
                        })
                        let dataTable = {{ $id }}DataTable;

                        @if (!empty($estatus))
                            $("#status > option[value='{{ $estatus }}']").attr("selected", true);
                                dataTable.column(4).search('{{ $estatus }}').draw();
                        @endif

                        @if (!empty($tipo))
                            $("#type > option[value='{{ $tipo }}']").attr("selected", true);
                            ticketsIndexDataTable.column(8).search('{{ $tipo }}').draw();
                        @endif

                        $('.type-dropdown').on('change', function(e) {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            $('.type-dropdown').val(status)
                            dataTable.column(8).search(status).draw();
                        })
						
						 $('.category-dropdown').on('change', function(e) {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            $('.category-dropdown').val(status)
                            dataTable.column(7).search(status).draw();
                        })


                     
                      

                       
            let año = {{ $año ?? '(new Date).getFullYear()' }};
            let mes = {{ $mes ?? '(new Date).getMonth() + 1' }};


            let start = moment('' + año + '-' + mes + '').startOf('month');
            let end = moment('' + año + '-' + mes + '').endOf('month');
            

            let startHistory = moment('2022-01-01');
                        $('#daterange-btn-{{ $id }}').daterangepicker({
                                locale: {
                                    format: 'YYYY/MM/DD'
                                },
                                startDate: moment(startHistory),
                    endDate: moment(end),

                                ranges: {
                        'YTD': [moment().subtract(1, 'days').startOf('year'), moment()],
                        '{{ trans('messages.dias') }}': [moment().subtract(29, 'days'), moment()],
                        '{{ trans('messages.mes') }}': [moment().startOf('month'), moment().endOf('month')],
                        '{{ trans('messages.mespasado') }}': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')],
                            '{{ trans('messages.todos') }}': [moment('2022-01-01'), moment().endOf('month')]
                                }
                            },
                            function(start, end, label) {
                                if (isDate(start)) {
                                    $('#daterange-btn-{{ $id }} span').html(start.format(
                                        'YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
                                    minDateFilter = start;
                                    maxDateFilter = end;
                                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                                   
                                            var date = Date.parse(data[1]);
                                   
                                        if (
                                            (isNaN(minDateFilter) && isNaN(maxDateFilter)) ||
                                            (isNaN(minDateFilter) && date <= maxDateFilter) ||
                                            (minDateFilter <= date && isNaN(maxDateFilter)) ||
                                            (minDateFilter <= date && date <= maxDateFilter)
                                        ) {
                                            return true;
                                        }
                                        return false;
                                    });
                                    {{ $id }}DataTable.draw();
                                }
                            });
                        $('#btnInc').click(function(e) {
                            IncDecMonth('Inc')
                        })
                        $('#btnDec').click(function(e) {
                            IncDecMonth('Dec')
                        })

                        function isDate(val) {
                            return Date.parse(val);
                        }

                        function IncDecMonth(Action) {
                            if (!isDate(start)) {
                                start = moment().startOf('month');
                            }
                            if (Action == 'Inc') {
                                start = moment(start).add(0, 'month').startOf('month');
                                end = moment(start).endOf('month')
                            } else {
                                start = moment(start).subtract(0, 'month').startOf('month');
                                end = moment(start).endOf('month')
                            }
                            if (isDate(start)) {
                                $('#daterange-btn-{{ $id }} span').html(startHistory.format(
                                    'DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
                            }
                            minDateFilter = startHistory;
                            maxDateFilter = end;
                            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                                    var date = Date.parse(data[1]);
                                if (
                                    (isNaN(minDateFilter) && isNaN(maxDateFilter)) ||
                                    (isNaN(minDateFilter) && date <= maxDateFilter) ||
                                    (minDateFilter <= date && isNaN(maxDateFilter)) ||
                                    (minDateFilter <= date && date <= maxDateFilter)
                                ) {
                                    return true;
                                }
                                return false;
                            });
                            {{ $id }}DataTable.draw();
                        }
                        IncDecMonth();

                        Loader.hide();

                    }



                });



            });
        </script>
    @endsection
</div>


<script>
    function edit_ticket(id) {
        $.get('edit_ajax/' + id, function(ticket) {
            var input = document.getElementById("fecha_comienzo");
            $('#folio').val(ticket[0].id);
            $('#estado_tcs').val(ticket[0].estatus);
            $('#prioridad').val(ticket[0].prioridad);
            $('#tipo_tcs').val(ticket[0].tipo_ticket);
            $('#exampleModal').modal('toggle');
            Loader.hide();
        })
    }

    function ver_ticket(id) {

        $.get('edit_ajax/' + id, function(ticket) {
            $('#folio2').val(ticket[0].id);
            $('#estado_tcs2').val(ticket[0].estatus);
            $('#prioridad2').val(ticket[0].prioridad);
            $('#tipo_tcs2').val(ticket[0].tipo_ticket);
            $('#realizo2').val(ticket[0].realizo);
            $('#crear').val(ticket[0].created_at);
            $('#actualizar').val(ticket[0].updated_at);
            $('#Sucursal').val(ticket[0].sucursal);
            $('#Area').val(ticket[0].area);
            $('#categoria').val(ticket[0].categoria);
            $('#equipo').val(ticket[0].inventario);
            $('#tiempo').val(ticket[0].tiempo_ejecucion);
            $('#fecha_de_entrega').val(ticket[0].fecha_estimada);
            $('#descripcion').val(ticket[0].ticket_descripcion);
            $('#trabajo_ing').val(ticket[0].observaciones);
            $('#entrega_usuario').val(ticket[0].fecha);
            $('#imagen1').html("<h5>Cargando...</h5>");
            $('#imagen2').html("<h5>Cargando...</h5>");
            $('#imagen3').html("<h5>Cargando...</h5>");
            $('#imagen4').html("<h5>Cargando...</h5>");
            $('#imagen5').html("<h5>Cargando...</h5>");
            $('#imagen6').html("<h5>Cargando...</h5>");

            $.ajax({
                            type: "GET",
                            dataType: "json",
                            url:'{{ route('web.dashboard.imagenes')}}',
                            data:{'id': ticket[0].id},

                            success: function(data){

                                $('#imagen1').html(data.foto1 ?? null);
                                $('#imagen2').html(data.foto2 ?? null);
                               
                            }

                        });

                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url:'{{ route('web.dashboard.imagenes_finales')}}',
                            data:{'id': ticket[0].id},

                            success: function(data){

                                $('#imagen3').html(data.foto1 ?? null);
                                $('#imagen4').html(data.foto2 ?? null);
                          
                            }

                        });

                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url:'{{ route('web.dashboard.imagenes_proceso')}}',
                            data:{'id': ticket[0].id},

                            success: function(data){

                                $('#imagen5').html(data.foto1 ?? null);
                                $('#imagen6').html(data.foto2 ?? null);
                            }

                        });
            $('#verticket').modal('toggle');
            Loader.hide();
        })

    }

    function rechazar_ticket(id) {

        $('#folio_rechazo').val(id);
        $('#rechazarModal').modal('toggle');

    }
</script>
