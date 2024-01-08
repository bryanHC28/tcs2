<input hidden type="text" id="logueado2" value="{{ auth()->user()->nombre . ' ' . auth()->user()->apellido }}">
<input hidden type="text" id="logueado" value="{{ auth()->user()->id_usuario }}">
@if (!empty($fecha))
    <input hidden type="text" id="var_fecha" value="{{ $fecha }}">
@else
    <input hidden type="text" id="var_fecha" value="inicial">
    <div class="form-group mb-2">
        <div class="input-group-btn">
            <button type="button" class="btn btn-primary" id="daterange-btn-{{ $id }}">
                {!! $slot !!}
                <i class="far fa-calendar-alt"></i>
                <span>Selecciona la fecha</span>
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
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningun dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "ÃƒÅ¡ltimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": 'Copiar',
                        "colvis": 'Visibilidad de columnas',
                        "copyTitle": 'Informacion copiada',
                        "copyKeys": 'Use your keyboard or menu to select the copy command',
                        "copySuccess": {
                            "_": '%d filas copiadas al portapapeles',
                            "1": '1 fila copiada al portapapeles'
                        },
                        "pageLength": {
                            "_": "Mostrar %d filas",
                            "-1": "Todo"
                        }
                    }
                };

                Loader.show();


                const nombre = document.getElementById("var_fecha").value;
                console.log(nombre);
                var asset = '{{ asset('') }}';
                var url = asset + 'dashboard/tcs_json/' + nombre;
                $.ajax({

                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {




                        var rutaedit = "{{ asset('dashboard/tcs_monalisa') }}";
                        var rutatcs = "{{ asset('dashboard/generarPDF') }}";
                        let label = '';
                        var datos = [];
                        var nombres = [];
                        var acciones = "";
                        const nombre = document.getElementById("logueado").value;
                        console.log(nombre);
                        $.each(data, function(i, item) {



                            if (nombre == 381 || nombre == 382 || nombre == 394 ||nombre == 406 || nombre == 429  ) {
                                acciones2 = "<a href='javascript:void(0)' onclick='ver_ticket(" +
                                    item
                                    .id +
                                    "),Loader.show();' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a> <a href='" +
                                    rutaedit + "/" + item.id + "/edit" +
                                    "' class='btn btn-primary btn-sm'><i class='fas fa-pencil-alt'></i></a> <a href='" +
                                    rutatcs + "/" + item.id +
                                    "' class='btn btn-danger btn-sm'><i class='fas fa-ticket-alt'></i></a> <a href='javascript:void(0)' onclick='edit_ticket(" +
                                    item.id +
                                    "),Loader.show();' class='btn btn-warning btn-sm'><i class='fas fa-external-link-alt'></i></a> ";
                            } else if (nombre == 395 || nombre == 399 || nombre == 400 || nombre == 401 || nombre == 402) {

                                acciones2 = "<a href='javascript:void(0)' onclick='ver_ticket(" +
                                    item
                                    .id +
                                    "),Loader.show();' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a> <a href='javascript:void(0)' onclick='edit_ticket(" +
                                    item.id +
                                    "),Loader.show();' class='btn btn-warning btn-sm'><i class='fas fa-external-link-alt'></i></a> ";
                            }else if(nombre == 387 || nombre == 388 || nombre == 390 || nombre == 391 || nombre == 396 || nombre == 429 ||                                 nombre == 393 || nombre == 430){
                                const nombre2 = document.getElementById("logueado2").value;
                                if (item.usuario == nombre2)
                                acciones2 = "<a href='javascript:void(0)' onclick='ver_ticket(" +
                                    item
                                    .id +
                                    "),Loader.show();' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a>  <a href='" +
                                    rutatcs + "/" + item.id +
                                    "' class='btn btn-danger btn-sm'><i class='fas fa-ticket-alt'></i></a> <a href='javascript:void(0)' onclick='comentario(" +
                                    item.id +
                                    "),Loader.show();' class='btn btn-success btn-sm'><i class='far fa-comment'></i></a> <a href='javascript:void(0)' onclick='edit_ticket(" +
                                    item.id +
                                    "),Loader.show();' class='btn btn-warning btn-sm'><i class='fas fa-external-link-alt'></i></a> ";
                            else
                                acciones2 = "";



                            } else {

                                acciones2 = "<a href='javascript:void(0)' onclick='ver_ticket(" +
                                    item
                                    .id +
                                    "),Loader.show();' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a> <a href='javascript:void(0)' onclick='comentario(" +
                                    item.id +
                                    "),Loader.show();' class='btn btn-success btn-sm'><i class='far fa-comment'></i></a> ";
                            }







                            switch (item.prioridad) {
                                case "Alta":
                                    item.prioridad =
                                        "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>Alta</span>";
                                    break;
                                case "Media":
                                    item.prioridad =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>Media</span>";
                                    break;
                                case "Baja":
                                    item.prioridad =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>Baja</span>";
                                    break;
                            }
                            switch (item.estatus) {
                                case "Cerrado":
                                    item.estatus =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>Cerrado</span>";

                                    break;
                                case "Abierto":
                                    item.estatus =
                                        "<span class='badge badge-primary badge-xs' style='font-size: 0.7em;'>Abierto</span>";
                                    break;

                                case "Ejecutado":
                                    item.estatus =
                                        "<span class='badge badge-secondary badge-xs' style='font-size: 0.7em;'>" +
                                        item.estatus + "</span>";
                                    break;
                                case "En proceso":
                                    item.estatus =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>" +
                                        item.estatus + "</span>";
                                    break;
                                case "Suspendido":
                                    item.estatus =
                                        "<span class='badge badge-dark badge-xs' style='font-size: 0.7em;'>" +
                                        item.estatus + "</span>";
                                    break;
                            }
                            switch (item.tipo_ticket) {
                                case "Preventivo":
                                    item.tipo_ticket =
                                        "<span class='badge badge-info badge-xs' style='font-size: 0.7em;'>" +
                                        item.tipo_ticket + "</span>";
                                    break;
                                case "Correctivo":
                                    item.tipo_ticket =
                                        "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>" +
                                        item.tipo_ticket + "</span>";
                                    break;
                                case "Mejora continua":
                                    item.tipo_ticket =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>" +
                                        item.tipo_ticket + "</span>";
                                    break;
                                case "Modificaciones":
                                    item.tipo_ticket =
                                        "<span class='badge badge-dark badge-xs' style='font-size: 0.7em;'>" +
                                        item.tipo_ticket + "</span>";
                                    break;
                                case "Rutinario":
                                    item.tipo_ticket =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>" +
                                        item.tipo_ticket + "</span>";
                                    break;
                            }
                            

                            if (item.realizo != null) {
                                item.realizo =
                                    "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>" +
                                    item.realizo + "</span>";
                            } else {
                                item.realizo =
                                    "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>Sin registro</span>";
                            }

                            if (item.falla != null) {
                                item.falla =
                                    "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>" +
                                    item.falla + "</span>";
                            } else {
                                item.falla =
                                    "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>Sin registro</span>";
                            }



                            item.evidenciaInicial = "https://tickets.sumapp.cloud/evidencias/" +
                                item.evidenciaInicial;


                            let fecha1 = moment(item.created_at);
                            let fecha2 = moment(item.fecha_tecnico);
                            let fecha3 = fecha2.diff(fecha1, 'days');
                            if (fecha3 == 0) {
                                fecha3 = fecha2.diff(fecha1, 'h') + " horas";
                            } else {
                                fecha3 = fecha2.diff(fecha1, 'h') / 24;
                                fecha3 = Number(fecha3).toFixed(1) + " días";
                            }

                            if ((item.evidencia_inicial_multiple).length == 2 ) {
                            foto="<a href='javascript:void(0) '><i style='color: rgb(170, 17, 17)' class='fas fa-eye-slash'></i></a> ";
                            } else {
                              let ei=  JSON.parse(item.evidencia_inicial_multiple);
                              let i=0;
                                               
                              foto="<a href='https://fotostickets.sumapp.cloud/Monalisa/" + ei[i] + "'" + "data-lightbox='models',Loader.show();' data-title='Folio: "+item.id+"<br> Autor: "+item.usuario +"<br> Descripcion: "+item.accion +"'><i style='color: rgb(236, 186, 120)' class='fas fa-folder'></i></a> ";
                            
                         
                        }
                           
                           
                            datos.push({
                                "idticket":item.id,
                                "fecha": item.created_at.substring(0, 10),
                                "fecha_cierre": item.close_at,
                                "fecha_estimada": item.fecha_estimada ?? "Sin fecha",
                                "estatus": item.estatus ?? "Sin estatus",
                                "prioridad": item.prioridad,
                                "area": item.area ?? "Sin area",
                                "subarea": item.subarea ?? "Sin registro",
                                "categoria": item.categoria ?? "Sin categoria",
                                "costo_estimado": '$' + item.costo_estimado ?? "Sin registro",
                                "transmitio": item.transmitio,
                                "observaciones": item.ticket_descripcion ?? "Sin motivos",
                                "comentario_cliente": item.comentario_cliente ?? "Sin comentarios",
                                "comentario_mantto": item.comentario_mantto ?? "Sin comentarios",
                                "realizo": item.realizo,
                                "descripcion": item.accion,
                                "usuario": item.usuario,
                                "foto":foto,
                                "accion": acciones2
                            });


                        });

                        @php
                            $nombre = auth()->user()->id_usuario;
                        @endphp



                        @if (
                                $nombre == 381 ||
                                $nombre == 382 ||
                                $nombre == 395 ||
                                $nombre == 399 ||
                                $nombre == 400 ||
                                $nombre == 401 ||
							    $nombre == 406 ||
							    $nombre == 429 ||
                                $nombre == 402)

                            let {{ $id }}DataTable = $('#{{ $id }}DataTable')
                                .DataTable({

                                    data: datos,
                                    columns: [{
                                            title: "Folio",
                                            data: 'idticket'
                                        },
                                        {
                                            title: "Creación",
                                            data: 'fecha'
                                        },
                                        {
                                            title: "Fecha estimada",
                                            data: 'fecha_estimada'
                                        },
                                        {
                                            title: "Estado",
                                            data: 'estatus'
                                        },
                                        {
                                            title: "Prioridad",
                                            data: 'prioridad'
                                        },

                                        {
                                            title: "Área",
                                            data: 'area'
                                        },
                                        {
                                            title: "Subarea",
                                            data: 'subarea'
                                        },

                                        {
                                            title: "Trabajo a realizar",
                                            data: 'descripcion'
                                        },
                                        {
                                            title: "Motivos de suspensión",
                                            data: 'observaciones'
                                        },

                                        {
                                            title: "Responsable",
                                            data: 'realizo'
                                        },
                                        {
                                            title: "Autor",
                                            data: 'usuario'
                                        },
                                        {
                                            title: "Preview",
                                            data: 'foto'
                                        },
 
                                        {
                                            title: "Fecha cierre",
                                            data: 'fecha_cierre'
                                        },
                                        
                                        {
                                            title: "Costo estimado",
                                            data: 'costo_estimado'
                                        },

                                        {
                                            title: "Acciones",
                                            data: 'accion'
                                        }
                                    ],
                                    createdRow: function(row, data, indice) {

                                        $(row).find("td:eq(2)").attr('id', "fecha_estimada" + data
                                            .idticket);
                                        $(row).find("td:eq(3)").attr('id', "estatus" + data
                                            .idticket);
                                        $(row).find("td:eq(4)").attr('id', "prioridad" + data
                                            .idticket);

                                        $(row).find("td:eq(8)").attr('id', "motivo" + data
                                            .idticket);

                                        $(row).find("td:eq(9)").attr('id', "asignado" + data
                                            .idticket);


                                        $(row).find("td:eq(7)").css('background-color', '#F1F3F2');
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
                        @else

                            let {{ $id }}DataTable = $('#{{ $id }}DataTable')
                                .DataTable({

                                    data: datos,
                                    columns: [{
                                            title: "Folio",
                                            data: 'idticket'
                                        },
                                        {
                                            title: "Creación",
                                            data: 'fecha'
                                        },
									    {
                                            title: "Autor",
                                            data: 'usuario'
                                        },
                                        {
                                            title: "Trabajo a realizar",
                                            data: 'descripcion'
                                        },
                                        
                                        {
                                            title: "Estado",
                                            data: 'estatus'
                                        },
                                        {
                                            title: "Prioridad",
                                            data: 'prioridad'
                                        },

                                        {
                                            title: "Área",
                                            data: 'area'
                                        },
                                        {
                                            title: "Subarea",
                                            data: 'subarea'
                                        },
                                        {
                                            title: "Comentario mantto",
                                            data: 'comentario_mantto'
                                        },
                                        {
                                            title: "Preview",
                                            data: 'foto'
                                        },
 

                                        {
                                            title: "Responsable",
                                            data: 'realizo'
                                        },
                                      
                                        {
                                            title: "Acciones",
                                            data: 'accion'
                                        }
                                    ],
                                    createdRow: function(row, data, indice) {

                                        $(row).find("td:eq(2)").attr('id', "comentarios_cliente" +
                                            data
                                            .idticket);



                                        $(row).find("td:eq(2)").css('background-color', '#F1F3F2');

                                        $(row).find("td:eq(7)").css('background-color', '#F1F3F2');
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
                        @endif

                        $('.status-dropdown').on('change', function(e) {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            $('.status-dropdown').val(status)
						   @if (
                                $nombre == 381 ||
                                $nombre == 382 ||
                                $nombre == 395 ||
                                $nombre == 399 ||
                                $nombre == 400 ||
                                $nombre == 401 ||
							    $nombre == 406 ||
                                $nombre == 402)					
                            dataTable.column(3).search(status).draw();
											@else
															
                            dataTable.column(4).search(status).draw();
											@endif
                        })
                        @php
                            $responsable = auth()->user()->complete_name;
                        @endphp
                        let dataTable = {{ $id }}DataTable;
                        @if (!empty($estatus)&& !empty($responsable))
                            $("#status > option[value='{{ $estatus }}']").attr("selected", true);
			
			@if (
                                $nombre == 381 ||
                                $nombre == 382 ||
                                $nombre == 395 ||
                                $nombre == 399 ||
                                $nombre == 400 ||
                                $nombre == 401 ||
							    $nombre == 406 ||
                                $nombre == 402)					
                             dataTable.column(3).search('{{ $estatus }}').draw();
											@else
                           dataTable.column(4).search('{{ $estatus }}').draw();
											@endif
                            
                            $("#asignados > option[value='{{ $responsable }}']").attr("selected", true);


                            @if (
                                $nombre == 381 ||
                                $nombre == 382 ||
                                $nombre == 395 ||
                                $nombre == 399 ||
                                $nombre == 400 ||
                                $nombre == 401 ||
							    $nombre == 406 ||
                                $nombre == 402)					
                            
                                ticketsIndexDataTable.column(10).search('{{ $responsable }}').draw();
											@else
                       
                                ticketsIndexDataTable.column(2).search('{{ $responsable }}').draw();
											@endif






 
                        @endif
                        @if (!empty($estatus) && empty($responsable))
                            $("#status > option[value='{{ $estatus }}']").attr("selected", true);
                           @if (
                                $nombre == 381 ||
                                $nombre == 382 ||
                                $nombre == 395 ||
                                $nombre == 399 ||
                                $nombre == 400 ||
                                $nombre == 401 ||
							    $nombre == 406 ||
                                $nombre == 402)					
                             dataTable.column(3).search('{{ $estatus }}').draw();
											@else
                           dataTable.column(4).search('{{ $estatus }}').draw();
											@endif
                        @endif
                      
                        @if (!empty($responsable) && empty($estatus) && empty($estado) && empty($fecha))
                            $("#asignados > option[value='{{ $responsable }}']").attr("selected", true);

                            
                            @if (
                                $nombre == 381 ||
                                $nombre == 382 ||
                                $nombre == 395 ||
                                $nombre == 399 ||
                                $nombre == 400 ||
                                $nombre == 401 ||
							    $nombre == 406 ||
                                $nombre == 402)					
                            
                                ticketsIndexDataTable.column(10).search('{{ $responsable }}').draw();
											@else
                       
                                ticketsIndexDataTable.column(2).search('{{ $responsable }}').draw();
											@endif
                                 
                        @endif
                        @php
                            $tipo_user = auth()->user()->rol_tickets;
                            $name = auth()->user()->nombre . ' ' . auth()->user()->apellido;
                        @endphp
                        @if ($tipo_user == 'tecnico')
                            $("#responsables > option[value='{{ $name }}']").attr("selected",
                            true);
                            ticketsIndexDataTable.column(9).search('{{ $name }}').draw();
                        @endif

                        let año = {{ $año ?? '(new Date).getFullYear()' }};
            let mes = {{ $mes ?? '(new Date).getMonth() + 1' }};


            let start = moment('' + año + '-' + mes + '').startOf('month');
            let end = moment('' + año + '-' + mes + '').endOf('month');
            let startHistory = moment('2023-01-01');

                        $('#daterange-btn-{{ $id }}').daterangepicker({
                                locale: {
                                    format: 'YYYY/MM/DD'
                                },
                                startDate: moment(startHistory),
                    endDate: moment(end),

                                ranges: {
                                  
                                    'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
                                    'Este mes': [moment().subtract(1, 'month').endOf('month'), moment().endOf('month')],
                                    'Mes pasado': [moment().subtract(1, 'month').startOf('month'),
                                        moment().subtract(1, 'month').endOf('month')
                                    ],
                                    'YTD': [moment('2023-01-01'), moment().endOf('month')]
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
                                $('#daterange-btn-{{ $id }} span').html( startHistory.format(
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
    function comentario(id) {
        $.get('edit_ajax/' + id, function(ticket) {
            $('#folio_c').val(ticket[0].id);
            $('#comentario_cliente').val(ticket[0].comentario_cliente);
            $('#comentarios').modal('toggle');
            Loader.hide();
        })
    }



    function edit_ticket(id) {

        $.get('edit_ajax/' + id, function(ticket) {
            $('#folio').val(ticket[0].id);
            $('#estado_tcs').val(ticket[0].estatus);
            $('#prioridad').val(ticket[0].prioridad);;
            $('#realizo').val(ticket[0].realizo);
            $('#tics_descripcion').val(ticket[0].ticket_descripcion);
            $('#fecha_estimada').val(ticket[0].fecha_estimada);
            $('#costo_estimado').val(ticket[0].costo_estimado);
            $('#comentario_mantto').val(ticket[0].comentario_mantto);
            $('#exampleModal').modal('toggle');
            Loader.hide();
        })


    }

    function ver_ticket(id) {



        $.get('edit_ajax/' + id, function(ticket) {
            $('#folio2').val(ticket[0].id);
            $('#estado_tcs2').val(ticket[0].estatus);
            $('#prioridad2').val(ticket[0].prioridad);
            $('#realizo2').val(ticket[0].realizo);
            $('#crear').val(ticket[0].created_at);
            $('#actualizar').val(ticket[0].updated_at);
            $('#Sucursal').val(ticket[0].sucursal);
            $('#Area').val(ticket[0].area);
            $('#categoria_mona').val(ticket[0].categoria);
            $('#fecha_de_entrega').val(ticket[0].fecha_estimada);
            $('#descripcion').val(ticket[0].ticket_descripcion);
            $('#costo_estimado_mona').val('$' + ticket[0].costo_estimado);
            $('#trabajo_monalisa').val(ticket[0].accion);
            $('#obs_monalisa').val(ticket[0].observaciones);
            $('#Sub_area').val(ticket[0].subarea);
            $('#comentarios_cliente_monalisa').val(ticket[0].comentario_cliente);
            $('#comentarios_mantto_monalisa').val(ticket[0].comentario_mantto);

            $('#imagen1').html("<h5>Cargando...</h5>");
            $('#imagen2').html("<h5>Cargando...</h5>");
            $('#imagen3').html("<h5>Cargando...</h5>");
            $('#imagen4').html("<h5>Cargando...</h5>");
            $('#imagen5').html("<h5>Cargando...</h5>");
            $('#imagen6').html("<h5>Cargando...</h5>");

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('web.dashboard.imagenes') }}',
                data: {
                    'id': ticket[0].id
                },

                success: function(data) {

                    $('#imagen1').html(data.foto1 ?? null);
                    $('#imagen2').html(data.foto2 ?? null);
                    // console.log(data.var)
                    // Loader.hide();
                    // Swal.fire(
                    // 'Ticket cerrado!',
                    // 'Pulse ok para continuar!',
                    // 'success')

                }

            });

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('web.dashboard.imagenes_finales') }}',
                data: {
                    'id': ticket[0].id
                },

                success: function(data) {

                    $('#imagen3').html(data.foto1 ?? null);
                    $('#imagen4').html(data.foto2 ?? null);
                    // console.log(data.var)
                    // Loader.hide();
                    // Swal.fire(
                    // 'Ticket cerrado!',
                    // 'Pulse ok para continuar!',
                    // 'success')

                }

            });

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('web.dashboard.imagenes_proceso') }}',
                data: {
                    'id': ticket[0].id
                },

                success: function(data) {

                    $('#imagen5').html(data.foto1 ?? null);
                    $('#imagen6').html(data.foto2 ?? null);
                    // console.log(data.var)
                    // Loader.hide();
                    // Swal.fire(
                    // 'Ticket cerrado!',
                    // 'Pulse ok para continuar!',
                    // 'success')

                }

            });




            // let array=  ticket[0].evidencia_inicial_multiple;
            $('#verticket').modal('toggle');
            Loader.hide();


        })





    }


 
</script>
