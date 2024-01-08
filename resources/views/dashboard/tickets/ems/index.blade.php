@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Tickets</h1>
@stop

@section('content')
    <div class="pb-2">

        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="col text-center">
                        <button onclick="tutorial();" class="btn btn-primary"><i class="fa fa-play-circle"
                                aria-hidden="true"></i>&nbsp;Iniciar tutorial</button>
                    </div>




                    @php
                    if(auth()->user()->tipo_cuenta=='usuario')
                    $hidden='';
                    else
                    $hidden='hidden';
                    @endphp

                    <div class="form-group two-fields">
                        <label for="">Filtros</label>
                        <div class="input-group">

                            <div class="input-group-prepend ">
                                <div class="input-group-text bg-primary"><i class="fa fa-hourglass-start"
                                        aria-hidden="true"></i>&nbsp;Estado</div>
                            </div>
                            <select id="status" class="form-control status-dropdown" style="margin-right: 20px">
                                <option value="">Todos</option>
                                <option value="Abierto">Abierto</option>
                                <option value="Cerrado">Cerrado</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Ejecutado">Ejecutado</option>
                                <option value="Validado">Validado</option>
                            </select>
                            <select hidden id="asignados" class="form-control asignados-dropdown" style="margin-right: 20px">
                                <option value="">Todos</option>
                                <option value="Alfredo Bravo">Alfredo Bravo</option>
                                <option value="Jesus Farfan">Jesus Farfan</option>
                                <option value="Juan Rivera">Juan Rivera</option>
                                <option value="Edgar Duran">Edgar Duran</option>
                                <option value="Karina Badillo">Karina Badillo</option>
                                <option value="Tecnico Ems">Tecnico Ems</option>

                            </select>
                           
                                <div {{  $hidden }} class="input-group-prepend ">
                                    <div class="input-group-text bg-primary"><i class="fa fa-hourglass-start"
                                            aria-hidden="true"></i>&nbsp;Sucursal</div>
                                </div>

                                <select {{  $hidden }} id="sucursal" class="form-control sucursal-dropdown">
                                    <option value="">Todos</option>
                                    <option value="Sucursal Cuautla">Sucursal Cuautla</option>
                                    <option value="Planta Cuautla">Planta Cuautla</option>
                                    <option value="Sucursal Jojutla">Sucursal Jojutla</option>
                                    <option value="Sucursal Axochiapan">Sucursal Axochiapan</option>
                                    <option value="Sucursal San Antonio">Sucursal San Antonio</option>
                                    <option value="Sucursal Tizayuca">Sucursal Tizayuca</option>
                                    <option value="Sucursal Tula">Sucursal Tula</option>
                                    <option value="Sucursal Actopan">Sucursal Actopan</option>
                                    <option value="Sucursal Sahagún">Sucursal Sahagún</option>
                                    <option value="Sucursal Tulancingo">Sucursal Tulancingo</option>
                                    <option value="Sucursal Huauchinango">Sucursal Huauchinango</option>
                                    <option value="Sucursal Zacualtipán">Sucursal Zacualtipán</option>
                                    <option value="Sucursal Zacatlán">Sucursal Zacatlán</option>
                                    <option value="Mini bodega Ahuacatlán">Mini bodega Ahuacatlán</option>
                                    <option value="Mini bodega San Bartolo">Mini bodega San Bartolo</option>
                                    <option value="Mini bodega Tetela de Ocampo">Mini bodega Tetela de Ocampo</option>
                                    <option value="Mini bodega Ixtlahuaco">Mini bodega Ixtlahuaco</option>
                                    <option value="MDM Pachuca">MDM Pachuca</option>
                                    <option value="MDM Cuautla">MDM Cuautla</option>
                                    <option value="Planta Pachuca">Planta Pachuca</option>
                                </select>
                           



                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">




                <x-ems :estatus="$estatus ?? null" id="ticketsIndexx" :disableSort="[7]">


                </x-ems>





                <!-- Modal edit-->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="ticket_edit">
                                <div class="modal-body">

                                    @csrf

                                    <label hidden class="form-label">Folio</label>
                                    <input hidden type="text" class="form-control" id="folio" name="folio">
                                    <br>
                                    <label class="form-label">Estado</label>
                                    <select class="form-control" id="estado_tcs" name="estado_tcs">
                                        <option {{ $hidden }} value="Abierto">Abierto</option>
                                        <option {{ $hidden }} value="Cerrado">Cerrado</option>
                                        <option {{ $hidden }} value="Cancelado">Cancelado</option>
                                        <option {{ $hidden }} value="Ejecutado">Ejecutado</option>                                        
                                        @if(auth()->user()->tipo_cuenta == 'tecnico')
                                        <option value="Ejecutado">Ejecutado</option>
                                        @else
                                        <option value="Validado">Validado</option>
                                        @endif
                                    </select>
                                    <br>

                                    <div {{ $hidden }}>
                                    <label class="form-label">Prioridad</label>
                                    <select class="form-control" id="prioridad" name="prioridad">
                                        <option value="Critica">Critica</option>
                                        <option value="Urgente">Urgente</option>
                                        <option value="Media">Media</option>
                                    </select>
                                    <br>
                                    </div>
                                    <div {{ $hidden }}>
                                    <label class="form-label">Tipo ticket</label>
                                    <select class="form-control" id="tipo_tcs" name="tipo_tcs">


                                        <option value="Preventivo">Preventivo</option>
                                        <option value="Correctivo">Correctivo</option>
                                        <option value="Modificaciones">Modificaciones</option>
                                        <option value="Rutinario">Rutinario</option>
                                        <option value="Mejora continua">Mejora continua</option>


                                    </select>
                                    <br>
                                    </div>
                                    <div {{ $hidden }}>
                                    <label class="form-label">Reasignar:</label>
                                    <select class="form-control" id="realizo" name="realizo">
                                        <option value="Leonel García">Leonel García</option>
                                        <option value="Salvador Valle">Salvador Valle</option>
                                        <option value="Horacio Garcia">Horacio Garcia</option> 
                                        <option value="Giovanni de Jesus">Giovanni de Jesus</option>
                                        <option value="Jacqueline de Jesus">Jacqueline de Jesus</option> 
                                    </select>
                                    <br>
                                    </div>
                                    <div {{ $hidden }}>
                                    <label class="form-label">Fecha cita:</label>
                                    <input type="datetime-local" class="form-control" id="fecha_cita_ems_edit" name="fecha_cita_ems_edit">
                                    <br>
                                    </div>
                                    <div {{ $hidden }}>
                                    <label >Costo estimado</label>
                                    <input type="number" class="form-control" id="costo_estimado">
                                    <br>
                                    </div>
                                    <label  >Observaciones</label>
                                    <textarea   class="form-control" id="comentario_cliente"></textarea>
                                </div>
								
								
								                                <div class="contenedor">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <canvas id="draw-canvas" width="420" height="360">
                                                No tienes un buen navegador.
                                            </canvas>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="button" class="button" id="draw-submitBtn"
                                                value="Firmar"></input>
                                            <input type="button" class="button" id="draw-clearBtn"
                                                value="Borrar Firma"></input>

                                            <label>Color</label>
                                            <input type="color" id="color">
                                            <label>Tamaño Puntero</label>
                                            <input type="range" id="puntero" min="1" default="1"
                                                max="5" width="10%">


                                        </div>

                                    </div>

                                    <br />
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea hidden name="firma" id="draw-dataUrl" class="form-control" rows="5">Para los que saben que es esto:</textarea>

                                            <input hidden type="text" id="inputDestino" placeholder="Este es el destino">

                                        </div>
                                    </div>
                                    <br />
                                    <div class="contenedor">
                                        <div class="col-md-12">
                                            <img id="draw-image" src="" alt="Tu Imagen aparecera Aqui!" />
                                        </div>
                                    </div>
                                </div>





								
								
								
								
								
                                    <div class="modal-footer">

                                        <button type="submit" class="btn btn-primary">Guardar</button>

                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
          
                <!-- Modal ver-->
                <div class="modal fade" id="verticket" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Datos ticket</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <div class="pb-2">
                                    <div class="row">
                                        <div class="col-12 col-md-4 mb-3">
                                            <label class="form-label">Folio #:</label>
                                            <input readonly type="text" class="form-control" id="folio2">
                                        </div>
                                        <div class="col-12 col-md-4 mb-3">
                                            <label class="form-label">Creación:</label>
                                            <input readonly type="text" class="form-control" id="crear">
                                        </div>
                                        <div class="col-12 col-md-4 mb-3">
                                            <label class="form-label">Actualización:</label>
                                            <input readonly type="text" class="form-control" id="actualizar">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Estado</label>
                                            <input readonly type="text" class="form-control" id="estado_tcs2">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Prioridad</label>
                                            <input readonly type="text" class="form-control" id="prioridad2">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Sucursal</label>
                                            <input readonly type="text" class="form-control" id="Sucursal">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Area</label>
                                            <input readonly type="text" class="form-control" id="Area">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Tipo ticket</label>
                                            <input readonly type="text" class="form-control" id="tipo_tk">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Asignado</label>
                                            <input readonly type="text" class="form-control" id="realizo2">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Fecha estimada:</label>
                                            <input readonly type="text" class="form-control" id="fecha_de_entrega">
                                        </div>

                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Fecha cita:</label>
                                            <input readonly type="text" class="form-control" id="fecha_cita_ems">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Costo estimado:</label>
                                            <input readonly type="text" class="form-control" id="costo_estimado_ems">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Responsable:</label>
                                            <input readonly type="text" class="form-control" id="responsable_ems">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Trabajo a realizar:</label>
                                            <textarea readonly type="text" class="form-control" id="trabajo_ems"></textarea>
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Observaciones:</label>
                                            <textarea readonly type="text" class="form-control" id="obs_ems"></textarea>
                                        </div>
                                        <br>


                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Evidencia inicial:</label>

                                            <div id="imagen1">


                                            </div>


                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label"></label>

                                            <div id="imagen2">


                                            </div>

                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Evidencia del proceso:</label>

                                            <div id="imagen5">


                                            </div>


                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label"></label>

                                            <div id="imagen6">


                                            </div>

                                        </div>

                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Evidencia final:</label>

                                            <div id="imagen3">


                                            </div>


                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label"></label>

                                            <div id="imagen4">


                                            </div>

                                        </div>


 
<h1 style="text-align: center">________________________</h1>

<div class="col-12 col-md-6 mb-3">
    <label class="form-label">Firma:</label>

    <div id="firma1">


    </div>


</div>
 
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>

                        </div>
                    </div>
                </div>



               
                <script>
					var canvas = document.getElementById("draw-canvas");
                    var drawImage = document.getElementById("draw-image");

                    function clearCanvas() {
                        canvas.width = canvas.width;
                    }
                    // Obtener referencias a los elementos de entrada por su ID
                    var inputOrigen = document.getElementById('draw-dataUrl');
                    var inputDestino = document.getElementById('inputDestino');

                    
                    $('#ticket_edit').submit(function(e) {
						 inputDestino.value = inputOrigen.value;
                        e.preventDefault();
                        let folio2 = $('#folio').val();
                        let estado2 = $('#estado_tcs').val();
                        let prioridad2 = $('#prioridad').val();
                        let tipo2 = $('#tipo_tcs').val();
                        let realizo2 = $('#realizo').val();
                        let cita2 = $('#fecha_cita_ems_edit').val();
                        let estimado2 = $('#costo_estimado').val();comentario_cliente
                        let obs2 = $('#comentario_cliente').val();
						let firma = $('#inputDestino').val();

                        
                        Loader.show();
                        $.ajax({
                            url: "{{ route('web.dashboard.update_ajax_ems') }}",
                            type: "POST",
                            data: {
                                folio: folio2,
                                edo: estado2,
                                priority: prioridad2,
                                type: tipo2,
                                realizo: realizo2,
                                cita: cita2,
                                obs: obs2,
                                costo: estimado2,
								firma: firma,
                                "_token": $("meta[name='csrf-token']").attr("content")
                            },

                            success: function(data) {


                                if (data.error == 'Ocurrio un error') {

                                    Loader.hide();
                                    Swal.fire(
                                        'El ticket tiene que pasar por el estado ejecutado por parte del tecnico para poder cerrarlo',
                                        'Pulse ok para continuar!',
                                        'error')


                                } else {
                                    $('#estado' + folio2).html(data.estado);
                                    $('#prioridad' + folio2).html(data.prioridad);
                                    $('#tipo' + folio2).html(data.type);
                                    $('#realizo' + folio2).html(data.realizo);
                                    $('#costo' + folio2).html(data.costo);
                                    $('#exampleModal').modal('hide');									
                                    clearCanvas();
                                    drawImage.setAttribute("src", "");                                    
                                    Loader.hide();
                                    Swal.fire(
                                        'Ticket actualizado!',
                                        'Pulse ok para continuar!',
                                        'success')

                                }


                            }



                        });

                        console.log("listo calixto")
                    });
                </script>





                <script>
                    function tutorial() {
                        introJs().setOptions({
                            nextLabel: 'Siguiente',
                            prevLabel: 'Anterior',
                            doneLabel: 'Terminar',
                            skipLabel: 'Omitir',
                            steps: [{
                                    element: document.querySelector('#status'),
                                    intro: '<h3>Filtro estado</h3>Filtrar por estado de ticket (Abierto,En proceso, Cerrado,Etc)',
                                    position: 'top'
                                },


                                {
                                    element: document.querySelector('#ticketsIndexDataTable_filter'),
                                    intro: '<h3>Buscador</h3>Buscar por palabra en especifico',
                                    position: 'top'
                                },
                                {
                                    element: document.querySelector('#ticketsIndexDataTable_paginate'),
                                    intro: '<h3>Paginacion</h3>Gestionar paginas de registros',
                                    position: 'top'
                                }


                            ]
                        }).start();
                    }
                </script>

            </div>
        </div>
    </div>
@stop

@section('css')

    <link rel="stylesheet" type="text/css" href="{{ asset('css/efirma.css') }}">
    <style>
        .container {
            max-width: 820px;
            margin: 0px auto;
            margin-top: 50px;
        }

        .comment {
            float: left;
            width: 100%;
            height: auto;
        }

        .textinput {
            float: left;
            width: 100%;
            min-height: 75px;
            outline: none;
            resize: none;
            border: 1px solid grey;
        }

        .loading {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('https://hackernoon.imgix.net/images/0*4Gzjgh9Y7Gu8KEtZ.gif') 50% 50% no-repeat rgb(249, 249, 249);
            opacity: .8;
        }
    </style>


@stop

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous">
    </script>

    <script src="{{ asset('js/firma.js') }}"></script>


@stop
