<input hidden type="text" id="logueado" value="{{ auth()->user()->nombre . ' ' . auth()->user()->apellido }}">
<input hidden type="text" id="id_usuario" value="{{ auth()->user()->id_usuario }}">

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
            &nbsp;
            &nbsp;
            @if (auth()->user()->id_usuario == 496 ||
                    auth()->user()->id_usuario == 497 ||
                    auth()->user()->id_usuario == 433 ||
                    auth()->user()->id_usuario == 495)
                <a target="_blank" style="background-color: #DC2921" class="btn btn-sm" type="button"
                    onclick="ejecutar_pdf();">
                    <i style="color: #ffffff" class="fas fa-file-pdf"></i>
                </a>
            @endif
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
                const id_usuario = document.getElementById("id_usuario").value;
                console.log(nombre);


                var asset = '{{ asset('') }}';
                var url = asset + 'dashboard/tcs_json/' + nombre;




                $.ajax({

                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        const modal = document.getElementById("modal");
                        var rutaedit = "{{ asset('dashboard/workplay') }}";
                        var rutatcs = "{{ asset('dashboard/generarPDF') }}";
                        let label = '';
                        var datos = [];
                        let distrito = '';

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

                                case null:
                                    item.prioridad =
                                        "<span class='badge badge-dark badge-xs' style='font-size: 0.7em;'>Sin registro</span>";
                                    break;
                            }
                            switch (item.estatus) {
                                case "Atendido":
                                    item.estatus =
                                        "<span class='badge badge-success badge-xs' style='font-size: 0.7em;'>Atendido.</span>";

                                    break;

                                case "No atendido":
                                    item.estatus =
                                        "<span class='badge badge-dark badge-xs' style='font-size: 0.7em;'>No atendido</span>";
                                    break;
                                case "En proceso":
                                    item.estatus =
                                        "<span class='badge badge-warning badge-xs' style='font-size: 0.7em;'>" +
                                        item.estatus + "</span>";
                                    break;

                            }
          




                            item.evidenciaInicial = "https://tickets.sumapp.cloud/evidencias/" +
                                item.evidenciaInicial;



                            if (id_usuario == 496 || id_usuario == 497 || id_usuario == 433 ||
                                id_usuario == 495)
                                acciones2 = "<a href='javascript:void(0)' onclick='ver_ticket(" +
                                item.id +
                                "),Loader.show();' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a> <a href='" +
                                rutaedit + "/" + item.id + "/edit" +
                                "' class='btn btn-primary btn-sm'><i class='fas fa-pencil-alt'></i></a> <a href='" +
                                rutatcs + "/" + item.id +
                                "' class='btn btn-danger btn-sm'><i class='fas fa-ticket-alt'></i></a> <a href='javascript:void(0)' onclick='edit_ticket(" +
                                item.id +
                                "),Loader.show();' class='btn btn-warning btn-sm'><i class='fas fa-external-link-alt'></i></a>  <a href='javascript:void(0)' onclick='eliminar_ticket(" +
                                item.id +
                                ")' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a> ";



                                else if( id_usuario == 501 || id_usuario == 502 || id_usuario == 503 || id_usuario == 504)

                                acciones2 = "<a href='javascript:void(0)' onclick='ver_ticket(" +
                                item.id +
                                "),Loader.show();' class='btn btn-info btn-sm'><i class='fas fa-eye'></i></a> ";

                            else
                                acciones2 = "<a href='javascript:void(0)' onclick='fotos(" +
                                item.id +
                                ") ' class='btn btn-warning btn-sm'><i class='fas fa-camera-retro'></i></a>";


                            const nombre = document.getElementById("logueado").value;

                            if (item.evidencia_inicial_multiple != null) {
                                if ((item.evidencia_inicial_multiple).length == 2) {
                                    foto =
                                        "<a href='javascript:void(0) '><i style='color: rgb(170, 17, 17)' class='fas fa-eye-slash'></i></a> ";
                                } else {
                                    let ei = JSON.parse(item.evidencia_inicial_multiple);
                                    let i = 0;

                                    foto = "<a href='https://fotostickets.sumapp.cloud/Workplay/" +
                                        ei[i] + "'" +
                                        "data-lightbox='models',Loader.show();' data-title='Folio: " +
                                        item.id + "<br> Autor: " + item.usuario +
                                        "<br> Descripcion: " + item.ticket_descripcion +
                                        "'><i style='color: rgb(236, 186, 120)' class='fas fa-folder'></i></a> ";


                                }
                            }


                            datos.push({
                                "idticket": item.id,
                                "fecha": formatearFecha(item.created_at),
                                "fecha_cierre": item.close_at,
                                "estatus": item.estatus ?? "Sin estatus",
                                "prioridad": item.prioridad,
                                "area": item.area ?? "Sin area",
                                "categoria": item.categoria ?? "Sin categoria",
                                "transmitio": item.transmitio,
                                "observaciones": item.ticket_descripcion,
                                "realizo": item.realizo,
                                "usuario": item.usuario,
                                "sucursal": item.sucursal,
                                "ticket_sumapp": item.ticket_sumapp,
                                "accion": acciones2,
                                "distrito": item.distrito,
                                "foto": foto,
                                "coment":item.comentario_cliente ?? "Sin comentarios"
                            });


                        });




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
                                        title: "Fecha cierre",
                                        data: 'fecha_cierre'
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
                                        title: "Folio CPS",
                                        data: 'ticket_sumapp'
                                    },
                                    {
                                        title: "Sucursal",
                                        data: 'sucursal'
                                    },
                                    {
                                        title: "Distrito",
                                        data: 'distrito'
                                    },
                                    {
                                        title: "Área",
                                        data: 'area'
                                    },

                                    {
                                        title: "Categoria",
                                        data: 'categoria'
                                    },

                                    {
                                        title: "Descripción",
                                        data: 'observaciones'
                                    },


                                    {
                                        title: "Autor",
                                        data: 'usuario'
                                    },
									{
                                        title: 'Comentarios',
                                        data: 'coment'
                                    },
                                    {
                                        title: '{{ trans('messages.foto') }}',
                                        data: 'foto'
                                    },
                                    {
                                        title: "Acciones",
                                        data: 'accion'
                                    }
                                ],
                                createdRow: function(row, data, indice) {

                                    $(row).find("td:eq(3)").attr('id', "estatus" + data
                                        .idticket);
                                    $(row).find("td:eq(4)").attr('id', "prioridad" + data
                                        .idticket);
                                    $(row).find("td:eq(10)").attr('id', "descripcion_lsm" + data
                                        .idticket);
                                    $(row).find("td:eq(5)").attr('id', "cps" + data
                                        .idticket);


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


						
                        $('.status-dropdown').on('change', function() {
                            let dataTable = {{ $id }}DataTable;
                            var status = $(this).val();
                            dataTable.column(3).search(status ? status.join('|') : '', true, false)
                                .draw();
                        });


                        $('.categoria-dropdown').on('change', function() {
                            let dataTable = {{ $id }}DataTable;
                            var categoria = $(this).val();
                            dataTable.column(9).search(categoria ? categoria.join('|') : '', true, false)
                                .draw();
                        });

                     

                        $('.sucursal-dropdown').on('change', function() {
                            let dataTable = {{ $id }}DataTable;
                            var sucursal = $(this).val();
                            dataTable.column(6).search(sucursal ? sucursal.join('|') : '', true, false).draw();
                        });


                        $('.area-dropdown').on('change', function() {
                            let dataTable = {{ $id }}DataTable;
                            var areas = $(this).val();
                            dataTable.column(8).search(areas ? areas.join('|') : '', true, false)
                                .draw();
                        });

                        $('.prioridad-dropdown').on('change', function() {
                            let dataTable = {{ $id }}DataTable;
                            var prioridad = $(this).val();
                            dataTable.column(4).search(prioridad ? prioridad.join('|') : '', true, false)
                                .draw();
                        });

                        $('.distrito-dropdown').on('change', function() {
                            let dataTable = {{ $id }}DataTable;
                            var distrito = $(this).val();
                            dataTable.column(7).search(distrito ? distrito.join('|') : '', true, false)
                                .draw();
                        });
				
										
										
										
										
						
						let dataTable = {{ $id }}DataTable;

                        @if (!empty($estatus))
                            $("#status > option[value='{{ $estatus }}']").attr("selected", true);
                            dataTable.column(3).search('{{ $estatus }}').draw();
                        @endif

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
                                    'Mes pasado': [moment().subtract(1, 'month').startOf('month'),
                                        moment().subtract(1,
                                            'month').endOf('month')
                                    ],
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
	
	
	function ejecutar_pdf() {
       
        // Obtener el elemento de entrada por su ID
        var area = document.getElementById("multiselect_area").value;
        var status = document.getElementById("multiselect_status").value;
        var sucursal_select2 = document.getElementById("multiselect_sucursal").value;
        var categoria = document.getElementById("multiselect_categoria").value;
        var prioridad = document.getElementById("multiselect_prioridad").value;
        var distrito = document.getElementById("multiselect_distrito").value;
        status = status.replace(".", "");
        distrito = distrito.replace(".", "");
        //var url = "https://tickets.sumapp.cloud/dashboard/pdf_lsm?status="+status+"&sucursal="+sucursal_select2+"&categoria="+categoria;
           var url = "https://tickets.sumapp.cloud/dashboard/pdf_lsm?status=" + status + "&sucursal=" + sucursal_select2 +
            "&categoria=" + categoria + "&area=" + area + "&prioridad=" + prioridad + "&distrito=" + distrito;

        // Abrir la URL en una nueva pestaña
        window.open(url, '_blank');
        console.log("El valor del input es: " + status);
        console.log("El valor del input es: " + sucursal_select2);
        console.log("El valor del input es: " + categoria);
        console.log("El valor del input es: " + area);
        console.log("El valor del input es: " + prioridad);
        console.log("El valor del input es: " + distrito);
    }
	
    
</script>
<script>
    function edit_ticket(id) {




        $.get('edit_ajax/' + id, function(ticket) {
            var input = document.getElementById("fecha_comienzo");
            $('#folio').val(ticket[0].id);
            $('#estado_tcs').val(ticket[0].estatus);
            $('#prioridad').val(ticket[0].prioridad);
            $('#ticket_sumapp_lsm').val(ticket[0].ticket_sumapp);
            $('#descripcion_lsm').val(ticket[0].ticket_descripcion);
            $('#exampleModal').modal('toggle');
            Loader.hide();
        })




    }

    function fotos(id) {
        var formulario = document.getElementById('ticket_foto');

        // Usamos la función `route` de Blade para obtener la ruta con el ID
        var ruta = @json(route('web.dashboard.update_fotos', ':id'));
        // Reemplazamos ':id' con el valor real
        ruta = ruta.replace(':id', id);

        // Agregamos los atributos al formulario
        formulario.setAttribute('action', ruta);
        formulario.setAttribute('method', 'POST');
        formulario.setAttribute('enctype', 'multipart/form-data');
        formulario.setAttribute('onsubmit', 'Loader.show()');


        $('#fotos').css('display', 'none')
        $('#fotos2').css('display', 'none')
        $('#imagen55').html("<h5>Cargando...</h5>");
        $('#imagen66').html("<h5>Cargando...</h5>");
        $('#imagen33').html("<h5>Cargando...</h5>");
        $('#imagen44').html("<h5>Cargando...</h5>");

        $('#exampleFoto').modal('toggle');
		  $.get('edit_ajax/' + id, function(ticket) {
            $('#myText').val(ticket[0].comentario_cliente);
        })

		
		
		
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{ route('web.dashboard.imagenes_proceso') }}',
            data: {
                'id': id
            },

            success: function(data) {

                console.log(data.foto1)
                $('#imagen55').html(data.foto1 ?? null);
                $('#imagen66').html(data.foto2 ?? null);

                if (data.foto1 == '<h5>[Sin evidencia]</h5>') {
                    $('#fotos').css('display', 'block')
                    $('#div').css('display', 'none')
                } else {
                    $('#fotos').css('display', 'none')
                    $('#div').css('display', 'block')

                }

            }

        });







        $.ajax({
            type: "GET",
            dataType: "json",
            url: '{{ route('web.dashboard.imagenes_finales') }}',
            data: {
                'id': id
            },

            success: function(data) {
            
                $('#imagen33').html(data.foto1 ?? null);
                $('#imagen44').html(data.foto2 ?? null);

                if (data.foto1 == '<h5>[Sin evidencia]</h5>') {
                    $('#fotos2').css('display', 'block')
                    $('#div2').css('display', 'none')
                } else {
                    $('#fotos2').css('display', 'none')
                    $('#div2').css('display', 'block')

                }


            }

        });


    }

    function ver_ticket(id) {



        $.get('edit_ajax/' + id, function(ticket) {


            $('#folio2').val(ticket[0].id);
            $('#estado_tcs2').val(ticket[0].estatus);
            $('#prioridad2').val(ticket[0].prioridad);
            $('#realizo2').val(ticket[0].realizo);
            $('#crear').val(ticket[0].fecha);
            $('#actualizar').val(ticket[0].updated_at);
            $('#Sucursal').val(ticket[0].sucursal);
            $('#Area').val(ticket[0].area);
            $('#autor_lsm').val(ticket[0].usuario);
            $('#folio_lsm').val(ticket[0].ticket_sumapp);
            $('#categoria_lsm').val(ticket[0].categoria);
            $('#descripcion').val(ticket[0].ticket_descripcion);
            $('#no_habiacion').val(ticket[0].habitacion);
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


                }

            });




            // let array=  ticket[0].evidencia_inicial_multiple;
            $('#verticket').modal('toggle');
            Loader.hide();


        })





    }

    function formatearFecha(fecha) {
        const date = new Date(fecha);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function eliminar_ticket(id) {
        
         
        var tablaId = '#ticketsIndexDataTable'; // Reemplaza 'miTabla' con el ID de tu tabla

        var asset = '{{ asset('') }}';
        var url = asset + 'dashboard/eliminar_wp/' + id;

        console.log(url);
        // Pregunta al usuario para confirmar la eliminación
        if (confirm('¿Estás seguro de que deseas eliminar este ticket?')) {
            // Realiza la solicitud AJAX
            $.ajax({
                url: url, // Reemplaza '/ruta/del/servidor/' con la ruta real en tu servidor Laravel
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Asegúrate de tener el token CSRF en la página
                },
                success: function(response) {
                    // Maneja la respuesta exitosa
                    console.log(response);
                    console.log(response.message);
                  

                    Swal.fire(
                        'Ticket eliminado!',
                        'Pulse ok para continuar!',
                        'success'
                    ).then((result) => {
                        
                        // Si el usuario hace clic en el botón "OK", recarga los datos de la tabla
                        if (result.isConfirmed) {
                            // Actualiza solo los datos de la tabla sin perder la paginación
                            location.reload();
                        }
                    });
                    
                },
                error: function(error) {
                    // Maneja el error
                    console.error(error);
                    // Puedes mostrar un mensaje de error al usuario si es necesario
                    alert('Hubo un error al intentar eliminar el ticket.');
                    Loader.hide();
                }
            });
        }
    }
</script>
