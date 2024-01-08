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
                                <option value="En proceso">En proceso</option>
                                <option value="Cerrado">Cerrado</option>
                                <option value="Suspendido">Suspendido</option>
                                <option value="Ejecutado">Ejecutado</option>
                            </select>


                            <select hidden id="asignados" class="form-control asignados-dropdown">
                                <option value="">Todos</option>
                                <option value="Carlos Nogueda">Carlos Nogueda</option>
                                <option value="Estefanía Pacheco">Estefanía Pacheco</option>
                                <option value="Abel Gonzalez">Abel Gonzalez</option>
                                <option value="Marco Dominguez">Marco Dominguez</option>
                                <option value="Jaime Ríos">Jaime Ríos</option>
                                <option value="Gerardo Segovia">Gerardo Segovia</option>
                                <option value="Mario Terrazas">Mario Terrazas</option>
                                <option value="Andres Mariles">Andres Mariles</option>
                                <option value="Xochitl Cuevas">Xochitl Cuevas</option>
                                <option value="Adriana Nuñez">Adriana Nuñez</option>
                                <option value="Guillermo Hernandez">Guillermo Hernandez</option>
                                <option value="Miguel Chaparro">Miguel Chaparro</option>
                                <option value="Giuseppe Napoli">Giuseppe Napoli</option>
                                <option value="Emiliano Papalardo">Emiliano Papalardo</option>
                                <option value="Hector Morales">Hector Morales</option>
                                <option value="Chief Steward">Chief Steward</option>
                                <option value="Tecnico 1">Tecnico 1</option>
                                <option value="Tecnico 2">Tecnico 2</option>
                                <option value="Tecnico 3">Tecnico 3</option>
                                <option value="Supervisor Mantenimiento">Supervisor Mantenimiento</option>
                                <option value="Auxiliar Sistemas">Auxiliar Sistemas</option>

                            </select>

                            <div hidden class="input-group-prepend ">
                                <div class="input-group-text bg-primary"><i class="fa fa-hourglass-start"
                                        aria-hidden="true"></i>&nbsp;Responsables</div>
                            </div>

                            <select hidden id="responsables" class="form-control responsables-dropdown">
                                <option value="">Todos</option>
                                <option value="Abel Gonzalez">Abel Gonzalez</option>
                                <option value="Marco Dominguez">Marco Dominguez</option>
                                <option value="Tecnico 1">Tecnico 1</option>
                                <option value="Tecnico 2">Tecnico 2</option>
                                <option value="Tecnico 3">Tecnico 3</option>
                                <option value="Daniel Amaya">Daniel Amaya</option>
                                <option value="Auxiliar Sistemas">Auxiliar Sistemas</option>
                            </select>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">



                
                <x-monalisa :estatus="$estatus ?? null" id="ticketsIndex" :disableSort="[7]">


                </x-monalisa>






                <!-- comentarios-->
                <div class="modal fade" id="comentarios" tabindex="-1" role="dialog" aria-labelledby="comentariosLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="comentariosLabel">Comentarios</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="comentarios">
                                <div class="modal-body">

                                    @csrf

                                    <label hidden class="form-label">Folio</label>
                                    <input hidden type="text" class="form-control" id="folio_c" name="folio_c">
                                    <br>

                                    <div>
                                        <label class="form-label">Comentarios para este ticket:</label>
                                        <textarea type="text" class="form-control" id="comentario_cliente" name="comentario_cliente"></textarea>
                                    </div>
                                    <br>




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




                <!-- Modal edit-->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <select onclick="myFunction(this.value);" class="form-control" id="estado_tcs"
                                        name="estado_tcs">
                                        <option value="Abierto">Abierto</option>
                                        <option hidden value="Suspendido">Suspendido</option>
                                        <option value="Ejecutado">Ejecutado</option>
                                        @if (auth()->user()->id_empresa == 39 && auth()->user()->rol_tickets == 'gerente')
                                            <option value="En proceso">En proceso</option>
                                            <option value="Cerrado">Cerrado</option>
                                            <option value="Suspendido">Suspendido</option>
                                        @endif

                                        <option hidden value="En proceso">En proceso</option>
                                        <option hidden value="Cerrado">Cerrado</option>
                                    </select>
                                    <br>
                                    @php
                                        if (auth()->user()->id_usuario == 381 || auth()->user()->id_usuario == 382 || auth()->user()->id_usuario == 406) {
                                            $var = '';
                                        } else {
                                            $var = 'hidden';
                                        }
                                    @endphp
                                    <div {{ $var }} id="motivos">
                                        <label class="form-label">Motivos de suspensión:</label>
                                        <textarea type="text" class="form-control" id="tics_descripcion" name="tics_descripcion"></textarea>
                                    </div>
                                    <br>

                                    <label {{ $var }} class="form-label">Prioridad</label>
                                    <select {{ $var }} class="form-control" id="prioridad" name="prioridad">

                                        <option value="Baja">Baja</option>
                                        <option value="Media">Media</option>
                                        <option value="Alta">Alta</option>

                                    </select>
                                    <br>



                                    <label {{ $var }} class="form-label">Reasignar:</label>
                                    <select {{ $var }} class="form-control" id="realizo" name="realizo">


                                        
                                        @if (auth()->user()->id_usuario == 381)abel
                                        <option value="Tecnico 1">Tecnico 1</option>
                                        <option value="Tecnico 2">Tecnico 2</option>
                                        <option value="Tecnico 3">Tecnico 3</option>
                                        <option hidden value="Daniel Amaya">Daniel Amaya</option>
                                        <option value="Auxiliar Sistemas">Auxiliar Sistemas</option>
                                        <option hidden value="Abel Gonzalez">Abel Gonzalez</option>
                                        <option hidden value="Marco Dominguez">Marco Dominguez</option>
                                            <option value="Marco Dominguez">Marco Dominguez</option>
                                            <option hidden value="Abel Gonzalez">Abel Gonzalez</option>
										<option value="Daniel Amaya">Daniel Amaya</option>
                                        @elseif (auth()->user()->id_usuario == 382)
                                        <option value="Tecnico 1">Tecnico 1</option>
                                        <option value="Tecnico 2">Tecnico 2</option>
                                        <option value="Tecnico 3">Tecnico 3</option>
                                        <option hidden value="Daniel Amaya">Daniel Amaya</option>
                                        <option value="Auxiliar Sistemas">Auxiliar Sistemas</option>
                                        <option hidden value="Abel Gonzalez">Abel Gonzalez</option>
                                        <option hidden value="Marco Dominguez">Marco Dominguez</option>
                                            <option value="Abel Gonzalez">Abel Gonzalez</option>
										<option value="Daniel Amaya">Daniel Amaya</option>
                                            <option hidden value="Marco Dominguez">Marco Dominguez</option>
										  @elseif (auth()->user()->id_usuario == 406)
                                            <option value="Abel Gonzalez">Abel Gonzalez</option>
										<option hidden value="Daniel Amaya">Daniel Amaya</option>
                                            <option  value="Marco Dominguez">Marco Dominguez</option>
                                            <option hidden value="Tecnico 1">Tecnico 1</option>
                                            <option hidden value="Tecnico 2">Tecnico 2</option>
                                            <option hidden value="Tecnico 3">Tecnico 3</option>
                                            <option hidden value="Auxiliar Sistemas">Auxiliar Sistemas</option>

                                            @else
                                            <option hidden value="Tecnico 1">Tecnico 1</option>
                                            <option hidden value="Tecnico 2">Tecnico 2</option>
                                            <option hidden value="Tecnico 3">Tecnico 3</option>
                                            <option hidden hidden value="Daniel Amaya">Daniel Amaya</option>
                                            <option hidden value="Auxiliar Sistemas">Auxiliar Sistemas</option>
                                            <option hidden value="Abel Gonzalez">Abel Gonzalez</option>
                                            <option hidden value="Marco Dominguez">Marco Dominguez</option>
                                        @endif

                                    </select>
                                    <br>

                                    <label {{ $var }}>Costo estimado</label>
                                    <input {{ $var }} type="number" class="form-control" id="costo_estimado">

                                    <br>
                                    <label {{ $var }}>Fecha estimada</label>
                                    <input {{ $var }} type="date" class="form-control" id="fecha_estimada">

                                    <br>
                                    <label {{ $var }}>Observaciones</label>
                                    <textarea {{ $var }} class="form-control" id="comentario_mantto"></textarea>

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

                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Subarea</label>
                                            <input readonly type="text" class="form-control" id="Sub_area">
                                        </div>

                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Categoria</label>
                                            <input readonly type="text" class="form-control" id="categoria_mona">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Asignado</label>
                                            <input readonly type="text" class="form-control" id="realizo2"
                                                name="realizo2">
                                        </div>


                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Fecha estimada:</label>
                                            <input readonly type="text" class="form-control" id="fecha_de_entrega"
                                                name="realizo2">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Costo estimado:</label>
                                            <input readonly type="text" class="form-control" id="costo_estimado_mona"
                                                name="realizo2">
                                        </div>

                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Descripcion:</label>
                                            <textarea readonly type="text" class="form-control" id="descripcion" name="realizo2"></textarea>
                                        </div>

                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Trabajo a realizar:</label>
                                            <textarea readonly type="text" class="form-control" id="trabajo_monalisa"></textarea>
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Observaciones:</label>
                                            <textarea readonly type="text" class="form-control" id="obs_monalisa"></textarea>
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Comentarios cliente:</label>
                                            <textarea readonly type="text" class="form-control" id="comentarios_cliente_monalisa"></textarea>
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Comentarios mantenimiento:</label>
                                            <textarea readonly type="text" class="form-control" id="comentarios_mantto_monalisa"></textarea>
                                        </div>

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
                                            <label class="form-label">Evidencia final:</label>

                                            <div id="imagen3">


                                            </div>


                                        </div>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label"></label>

                                            <div id="imagen4">


                                            </div>

                                        </div>






                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button onclick="generartcs();" class="btn btn-danger">Generar Ticket</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>

                        </div>
                    </div>
                </div>



                <script>
                    function generartcs(){
                        let folio2 = $('#folio2').val();
                        console.log(folio2);
                        window.location.href = "https://tickets.sumapp.cloud/dashboard/generarPDF/"+folio2;
                    }
                    </script>
                <script>
                    $('#comentarios').submit(function(e) {
                        e.preventDefault();

                        let folio_id = $('#folio_c').val();
                        let comentarios = $('#comentario_cliente').val();
                        let token2 = $("input[name=_token]").val();
                        Loader.show();
                        $.ajax({
                            url: "{{ route('web.dashboard.update_ajax_comentario') }}",
                            type: "POST",
                            data: {

                                folio_idd: folio_id,
                                comentario_idd: comentarios,
                                "_token": $("meta[name='csrf-token']").attr("content")
                            },

                            success: function(data) {




                                $('#comentarios_cliente' + folio_id).html(data.comentario);
                                $('#comentarios').modal('hide');
                                Loader.hide();
                                Swal.fire(
                                    'Comentario realizado!',
                                    'Pulse ok para continuar!',
                                    'success')
 
                            }



                        });

                        console.log("listo calixto")
                    });
                </script>

                <script>
                    $('#ticket_edit').submit(function(e) {
                        e.preventDefault();
                        let folio2 = $('#folio').val();
                        let estado2 = $('#estado_tcs').val();
                        let prioridad2 = $('#prioridad').val();
                        let realizo = $('#realizo').val();
                        let tics_motivo = $('#tics_descripcion').val();
                        let estimada = $('#fecha_estimada').val();
                        let estimado = $('#costo_estimado').val();
                        let mantto = $('#comentario_mantto').val();

                        Loader.show();
                        $.ajax({
                            url: "{{ route('web.dashboard.update_ajax_monalisa') }}",
                            type: "POST",
                            data: {
                                folio: folio2,
                                edo: estado2,
                                prority: prioridad2,
                                realizo2: realizo,
                                tics_descripcion: tics_motivo,
                                fecha_estimada: estimada,
                                costo: estimado,
                                comentario_mantto: mantto,
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
                                    $('#estatus' + folio2).html(data.var);
                                    $('#prioridad' + folio2).html(data.prioridad);
                                    $('#motivo' + folio2).html(data.motivo);
                                    $('#asignado' + folio2).html(data.realizo);
                                    $('#fecha_estimada' + folio2).html(data.fech_estimada);
                                    $('#exampleModal').modal('hide');
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
                    element = document.getElementById('motivos');
                    element.style.display = 'none';

                    function myFunction(key) {
                        var x = document.getElementById("motivos");
                        if (key == "Suspendido") {
                            x.style.display = "block";
                        } else {
                            x.style.display = "none";
                        }

                    }
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


@stop
