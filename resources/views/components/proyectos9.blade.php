<input hidden type="text" id="logueado" value="{{ auth()->user()->nombre . ' ' . auth()->user()->apellido }}">
@if (!empty($fecha))
<input hidden type="text" id="var_fecha" value="{{ $fecha }}">
@else
<input hidden type="text" id="var_fecha" value="inicial">
<div class="form-group mb-2">
    <div class="input-group-btn">
        <button type="button" class="btn btn-primary" id="daterange-btn-{{ $id }}">
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


                console.log(url);

                $.ajax({

                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var rutaver = "{{ asset('dashboard/tickets') }}";
                        const modal = document.getElementById("modal");                     
                        var rutaedit = "{{ asset('dashboard/tcs_proyectos9') }}";
                        var rutatcs = "{{ asset('dashboard/generarPDF') }}";
                        let label = '';
                        let url="prbando cadena";
                        var datos = [];
                        var nombres = [];
                        var acciones = "";
                        $.each(data, function(i, item) {
                            



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
                                case "Cancelado":
                                    item.estatus =
                                        "<span class='badge badge-dark badge-xs' style='font-size: 0.7em;'>Cancelado</span>";
                                    break;
                               
                                case "Ejecutado":
                                    item.estatus =
                                        "<span class='badge badge-secondary badge-xs' style='font-size: 0.7em;'>" +
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
                            switch (item.estado) {
                                case "Rechazado":
                                    item.estado =
                                        "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>" +
                                        item.estado + "</span>";
                                    break;
                                case "Aceptado":
                                    item.estado =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>" +
                                        item.estado + "</span>";
                                    break;
                                case "Rechazado":
                                    item.estado =
                                        "<span class='badge badge-danger badge-xs' style='font-size: 0.7em;'>" +
                                        item.estado + "</span>";
                                    break;
                                case "inactivo":
                                    item.estado =
                                        "<span class='badge badge-dark badge-xs' style='font-size: 0.7em;'>" +
                                        item.estado + "</span>";
                                    break;
                                case "En revisión":
                                    item.estado =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>" +
                                        item.estado + "</span>";
                                    break;
                                case "Aprobado":
                                    item.estado =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>" +
                                        item.estado + "</span>";
                                    break;
                                case "En proceso":
                                    item.estado =
                                        "<span class='badge badge-primary badge-xs' style='font-size: 0.7em;'>" +
                                        item.estado + "</span>";
                                    break;
                                case null:
                                    item.estado =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>En revisión</span>";
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








 



                                const nombre = document.getElementById("logueado").value;

                                if (nombre == "Ricardo Garza" || nombre == "Joaquin Sanchez")

                                    acciones = "<a href='" +
                                    rutatcs + "/" + item.id +
                                    "' class='btn btn-danger btn-sm'><i class='fas fa-ticket-alt'></i></a><a href='" +
                                    rutaver + "/" + item.id +
                                    "'class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a>";
                                else
                                    acciones = "<a href='" +
                                    rutatcs + "/" + item.id +
                                    "' class='btn btn-danger btn-sm'><i class='fas fa-ticket-alt'></i></a> <a href='javascript:void(0)' onclick='ver_ticket(" +
                                    item
                                    .id +
                                    "),Loader.show();' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a> <a href='" +
                                    rutaedit + "/" + item.id + "/edit" +
                                    "' class='btn btn-primary btn-sm'><i class='fas fa-pencil-alt'></i></a> <a href='javascript:void(0)' onclick='edit_ticket(" +
                                    item.id +
                                    "),Loader.show();' class='btn btn-warning btn-sm'><i class='fas fa-external-link-alt'></i></a> ";
                       






                            let fecha1 = moment(item.created_at);
                            let fecha2 = moment(item.fecha_tecnico);
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
                                               
                              foto="<a href='https://fotostickets.sumapp.cloud/proyectos9/" + ei[i] + "'" + "data-lightbox='models',Loader.show();' data-title='Folio: "+item.id+"<br> Autor: "+item.usuario +"<br> Descripcion: "+item.accion +"'><i style='color: rgb(236, 186, 120)' class='fas fa-folder'></i></a> ";
                            
                         
                        }
                    }
                            @if (auth()->user()->id_sucursal == 200 )

                                datos.push({
                                    "idticket": item.id,
                                    "accion": item.accion,
                                    "estatus": item.estatus ?? "Sin estatus",
                                    "fecha": item.created_at.substring(0, 10),
                                    "fecha_estimada": item.fecha_estimada ?? "Sin registro",
                                    "fecha_cierre": item.close_at,
                                    "prioridad": item.prioridad,
                                    "area": item.area ?? "Sin area",
                                    "nivel": item.nivel ?? "Sin nivel",
                                    "vencimiento": item.estado,
                                    "realizo": item.realizo ?? "Sin registro",
                                    "dias" : fecha3,
                                    "tipo_tcs": item.tipo_ticket,
                                    "nombre": item.usuario ?? "Sin nombre",
                                    "cita": item.fecha_cita ?? "Sin cita",
                                    "acciones": acciones,
                                    "foto":foto,

                                });
                            @endif


                            @if (auth()->user()->id_sucursal == 201 || auth()->user()->id_sucursal == 111)

                                datos.push({
                                    "idticket": item.id,
                                    "accion": item.accion,
                                    "estatus": item.estatus ?? "Sin estatus",
                                    "fecha": item.created_at.substring(0, 10),
                                    "fecha_estimada": item.fecha_estimada ?? "Sin registro",
                                    "fecha_cierre": item.close_at,
                                    "prioridad": item.prioridad,
                                    "area": item.area ?? "Sin area",
                                    "nivel": item.nivel ?? "Sin nivel",
                                    "descripcion": item.ticket_descripcion ??
                                    "Sin descripcion",
                                    "vencimiento": item.estado,
                                    "realizo": item.realizo ?? "Sin registro",
                                    "dias" : fecha3,
                                    "tipo_tcs": item.tipo_ticket,
                                    "nombre": item.usuario ?? "Sin nombre",
                                    "acciones": acciones,
                                    "foto":foto,
                                });
                            @endif


                         

                        });



                        @if (auth()->user()->id_sucursal == 201 || auth()->user()->id_sucursal == 111)



                            let {{ $id }}DataTable = $('#{{ $id }}DataTable')
                                .DataTable({
                                    data: datos,
                                    columns: [{
                                            title: "Folio",
                                            data: 'idticket'
                                        },
                                        {
                                            title: "Tarea",
                                            data: 'accion'
                                        },
                                        {
                                            title: "Estado",
                                            data: 'estatus'
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
                                            title: "Fecha cierre",
                                            data: 'fecha_cierre'
                                        },
                                        {
                                            title: "Prioridad",
                                            data: 'prioridad'
                                        },
                                        {
                                            title: "Sucursal",
                                            data: 'area'
                                        },
                                        {
                                            title: "Area",
                                            data: 'nivel'
                                        },

                                        {
                                            title: "Vencimiento",
                                            data: 'vencimiento'
                                        },
                                        {
                                            title: "Asignados",
                                            data: 'realizo'
                                        },
                                        {
                                            title: "Duración",
                                            data: 'dias'
                                        },
                                      
                                        {
                                            title: "Tipo ticket",
                                            data: 'tipo_tcs'
                                        },

                                        {

                                            title: "Usuario",
                                            data: 'nombre'
                                        },  
                                        {
                                            title:'{{ trans('messages.foto') }}',
                                            data: 'foto'
                                        },

                                        {
                                            title: "Accion",
                                            data: 'acciones'
                                        }
                                    ],
                                    createdRow: function(row, data, indice) {

                                        $(row).find("td:eq(2)").attr('id', "estatus" + data
                                            .idticket);
                                        $(row).find("td:eq(6)").attr('id', "prioridad" + data
                                            .idticket);
                                            $(row).find("td:eq(10)").attr('id', "asignament" + data
                                            .idticket);
                                        $(row).find("td:eq(12)").attr('id', "tipo" + data.idticket);

                                        if (data.categoria == "Seguridad") {
                                            $(row).find("td").css('background-color', '#e89f9f');
                                        }
                                        if (data.vencimiento == "Vencido") {
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
                        @endif











                        @if (auth()->user()->id_sucursal == 200 )

                        



                            let {{ $id }}DataTable = $('#{{ $id }}DataTable')
                                .DataTable({
                                    data: datos,
                                    columns: [{
                                            title: "Folio",
                                            data: 'idticket'
                                        },
                                        {
                                            title: "Tarea",
                                            data: 'accion'
                                        },
                                        {
                                            title: "Estado",
                                            data: 'estatus'
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
                                            title: "Fecha cierre",
                                            data: 'fecha_cierre'
                                        },
                                        {
                                            title: "Prioridad",
                                            data: 'prioridad'
                                        },
                                        {
                                            title: "Area",
                                            data: 'area'
                                        },
                                        {
                                            title: "Nivel",
                                            data: 'nivel'
                                        },
                                          {
                                            title: "Cita",
                                            data: 'cita'
                                        },

                                        {
                                            title: "Vencimiento",
                                            data: 'vencimiento'
                                        },
                                        {
                                            title: "Asignados",
                                            data: 'realizo'
                                        },
                                        {
                                            title: "Duración",
                                            data: 'dias'
                                        },
                                        {
                                            title: "Tipo ticket",
                                            data: 'tipo_tcs'
                                        },

                                        {

                                            title: "Usuario",
                                            data: 'nombre'
                                        },
                                        {
                                            title:'{{ trans('messages.foto') }}',
                                            data: 'foto'
                                        },
                                        {
                                            title: "Accion",
                                            data: 'acciones'
                                        }
                                    ],
                                    createdRow: function(row, data, indice) {

                                        $(row).find("td:eq(2)").attr('id', "estatus" + data
                                            .idticket);
                                        $(row).find("td:eq(6)").attr('id', "prioridad" + data
                                            .idticket);
                                        $(row).find("td:eq(11)").attr('id', "asignament" + data.idticket);

                                        $(row).find("td:eq(9)").attr('id', "cita" + data.idticket);

                                        if (data.categoria == "Seguridad") {
                                            $(row).find("td").css('background-color', '#e89f9f');
                                        }
                                        if (data.vencimiento == "Vencido") {
                                            $(row).find("td").css('background-color', '#e89f9f');
                                        }

                                        $(row).find("td:eq(9)").css('background-color', '#F1F3F2');
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
                                dataTable.column(2).search(status).draw();
                             
                        })
                        let dataTable = {{ $id }}DataTable;

                        @if (!empty($estatus))
                            $("#status > option[value='{{ $estatus }}']").attr("selected", true);
                                dataTable.column(2).search('{{ $estatus }}').draw();                             
                        @endif

                        @if (!empty($nombre))
                        $("#asignados > option[value='{{ $nombre }}']").attr("selected",true);
                        @if (auth()->user()->id_sucursal == 200)
                        dataTable.column(11).search('{{ $nombre }}').draw();
                        @elseif(auth()->user()->id_sucursal == 201 || auth()->user()->id_sucursal == 111)
                        dataTable.column(10).search('{{ $nombre }}').draw();
                        @endif
                        @endif

                        @if (!empty($estado))
                            $("#estado > option[value='{{ $estado }}']").attr("selected", true);
                            ticketsIndexDataTable.column(10).search('{{ $estado }}').draw();
                        @endif

                        




                        
                            @php
                                $responsable = auth()->user()->complete_name;
                            @endphp
                            @if (!empty($responsable) && empty($estatus) && empty($estado)  && empty($nombre) && empty($fecha) )
                                $("#asignados > option[value='{{ $responsable }}']").attr("selected",
                                    true);
                                @if (auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314)
                                    ticketsIndexDataTable.column(13).search('{{ $responsable }}').draw();
                                @elseif (auth()->user()->id_usuario == 445 || auth()->user()->id_usuario == 318)
                                    ticketsIndexDataTable.column(14).search('{{ $responsable }}').draw();
                                @elseif (auth()->user()->id_sucursal == 201 || auth()->user()->id_sucursal == 111)
                                ticketsIndexDataTable.column(10).search('{{ $responsable }}').draw();
                                @else
                                    ticketsIndexDataTable.column(11).search('{{ $responsable }}').draw();
                                @endif
                            @endif
                        







                        $('.type-dropdown').on('change', function(e) {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            $('.type-dropdown').val(status)
                            dataTable.column(8).search(status).draw();
                        })


                        $('.area-dropdown').on('change', function(e) {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            $('.area-dropdown').val(status)
                            @if (auth()->user()->id_sucursal == 201 || auth()->user()->id_sucursal == 111)
                                dataTable.column(8).search(status).draw();
                            @else
                                dataTable.column(7).search(status).draw();
                            @endif

                        })

                        $('.asignados-dropdown').on('change', function(e) {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            $('.asignados-dropdown').val(status)
                            @if (auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314)
                                dataTable.column(11).search(status).draw();
                                @elseif (auth()->user()->id_usuario == 445 || auth()->user()->id_usuario == 318)
                                dataTable.column(14).search(status).draw();
                                @elseif (auth()->user()->id_sucursal == 201 || auth()->user()->id_sucursal == 111)
                                dataTable.column(10).search(status).draw();
                                @else
                                dataTable.column(11).search(status).draw();
                                @endif
                        })

                        $('.estado-dropdown').on('change', function(e) {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            $('.estado-dropdown').val(status)
                            dataTable.column(9).search(status).draw();
                        })

                        $('.sucursal-dropdown').on('change', function(e) {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            $('.sucursal-dropdown').val(status)
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
                        'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
                        'Este mes': [moment().startOf('month'), moment().endOf('month')],
                        'Mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')],
                        'Todo': [moment('2022-01-01'), moment().endOf('month')]
                                }
                            },
                            function(start, end, label) {
                                if (isDate(start)) {
                                    $('#daterange-btn-{{ $id }} span').html(start.format(
                                        'YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
                                    minDateFilter = start;
                                    maxDateFilter = end;
                                    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                                        
                                            var date = Date.parse(data[3]);
                                        
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


                                    var date = Date.parse(data[3]);
                                
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
            $('#realizo').val(ticket[0].realizo);
            if(ticket[0].fecha_comienzo  != null){
            $('#fecha_comienzo').val(ticket[0].fecha_comienzo);
            input.setAttribute("readonly", true);
            console.log(ticket[0].fecha_comienzo);
            }else{

            $('#fecha_comienzo').val(ticket[0].fecha_comienzo);
            input.removeAttribute("readonly");
            console.log(ticket[0].fecha_comienzo);
            }
            $('#fecha_cita').val(ticket[0].fecha_cita);
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
            $('#fecha_citas').val(ticket[0].fecha_cita);
            $('#crear').val(ticket[0].created_at);
            $('#actualizar').val(ticket[0].updated_at);
            $('#Sucursal').val(ticket[0].sucursal);
            $('#Area').val(ticket[0].area);
            $('#nivel').val(ticket[0].nivel);
            $('#accion_realizar').val(ticket[0].accion);
            $('#fecha_de_entrega').val(ticket[0].fecha_estimada);
            $('#fecha_comienzos').val(ticket[0].fecha_comienzo);
            $('#descripcion').val(ticket[0].ticket_descripcion);
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
                            url:'{{ route('web.dashboard.imagenes_finales')}}',
                            data:{'id': ticket[0].id},

                            success: function(data){

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
                            url:'{{ route('web.dashboard.imagenes_proceso')}}',
                            data:{'id': ticket[0].id},

                            success: function(data){

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
