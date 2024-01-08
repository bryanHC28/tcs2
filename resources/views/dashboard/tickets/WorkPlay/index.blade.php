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


                    <div class="form-group">
                        <label for="">Filtros</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-primary">Estado</div>
                                    </div>
                                    <select id="status" class="form-control status-dropdown" multiple="multiple" style="margin-right: 20px">
                                        
                                        <option value="En proceso">En proceso</option>
                                        <option value="No atendido">No atendido</option>
                                        <option value="Atendido.">Atendido</option>
                                    </select>
                                </div>
                            </div>
                            @if (auth()->user()->id_usuario == 496 ||
                                    auth()->user()->id_usuario == 497 ||
                                    auth()->user()->id_usuario == 433 ||
                                    auth()->user()->id_usuario == 495||
                                    auth()->user()->id_usuario == 502 ||
                                    auth()->user()->id_usuario == 503 ||
                                    auth()->user()->id_usuario == 504)
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-primary">Sucursal</div>
                                        </div>
                                        <select class="form-control sucursal-dropdown" multiple="multiple" style="margin-right: 20px">
                                            
                                             <option value="AFM">AFM</option>
                                            <option value="AGO">AGO</option>
                                            <option value="AGS">AGS</option>
                                            <option value="ALT">ALT</option>
                                            <option value="ANT">ANT</option>
                                            <option value="ARA">ARA</option>
                                            <option value="ATI">ATI</option>
                                            <option value="BUE">BUE</option>
                                            <option value="CAN">CAN</option>
                                            <option value="CAR">CAR</option>
                                            <option value="CFM">CFM</option>
                                            <option value="CIB">CIB</option>
                                            <option value="COA">COA</option>
                                            <option value="COS">COS</option>
                                            <option value="CTZ">CTZ</option>
                                            <option value="CUL">CUL</option>
                                            <option value="CUM">CUM</option>
                                            <option value="DOR">DOR</option>
                                            <option value="DUR">DUR</option>
                                            <option value="ECA">ECA</option>
                                            <option value="GUA">GUA</option>
                                            <option value="GVO">GVO</option>
                                            <option value="HAGS">HAGS</option>
                                            <option value="HCAN">HCAN</option>
                                            <option value="HCAR">HCAR</option>
                                            <option value="HGVO">HGVO</option>
                                            <option value="INS">INS</option>
                                            <option value="INT">INT</option>
                                            <option value="LAG">LAG</option>
                                            <option value="MAD">MAD</option>
                                            <option value="MER">MER</option>
                                            <option value="MET">MET</option>
                                            <option value="MOR">MOR</option>
                                            <option value="MUE">MUE</option>
                                            <option value="OAS">OAS</option>
                                            <option value="OFI">OFI</option>
                                            <option value="PAC">PAC</option>
                                            <option value="PAT">PAT</option>
                                            <option value="PDC">PDC</option>
                                            <option value="PLV">PLV</option>
                                            <option value="PSA">PSA</option>
                                            <option value="REF">REF</option>
                                            <option value="SAL">SAL</option>
                                            <option value="SER">SER</option>
                                            <option value="SFD">SFD</option>
                                            <option value="TAB">TAB</option>
                                            <option value="TAM">TAM</option>
                                            <option value="TEP">TEP</option>
                                            <option value="TEZ">TEZ</option>
                                            <option value="TLA">TLA</option>
                                            <option value="TOL">TOL</option>
                                            <option value="ZAC">ZAC</option>


                                        </select>
                                    </div>
                                </div>
                            @endif
							@if( auth()->user()->id_usuario == 501)
							   <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text bg-primary">Sucursal</div>
                                        </div>
                                        <select class="form-control sucursal-dropdown" multiple="multiple" style="margin-right: 20px">
                                            
                                            <option value="AFM">AFM</option>
                                            <option value="CAN">CAN</option>
                                            <option value="CTZ">CTZ</option>
                                            <option value="MER">MER</option>
                                            <option value="PDC">PDC</option>
                                            <option value="TAB">TAB</option>
                                            

                                        </select>
                                    </div>
                                </div>
							@endif
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-primary">Categoria</div>
                                    </div>
                                    <select id="categoria" class="form-control categoria-dropdown" multiple="multiple" style="margin-right: 20px">
                                        
                                        <option value="Electricidad">Electricidad</option>
                                        <option value="Plomería">Plomería</option>
                                        <option value="Aire acondicionado">Aire acondicionado</option>
                                        <option value="Cortina">Cortina</option>
                                        <option value="Audio">Audio</option>
                                        <option value="Detección de humo">Detección de humo</option>
                                        <option value="Cámaras">Cámaras</option>
                                        <option value="Telefonía e internet">Telefonía e internet</option>
                                        <option value="Electroimanes">Electroimanes</option>
                                        <option value="Pantallas">Pantallas</option>
                                        <option value="Alarmado y seguridad">Alarmado y seguridad</option>
                                        <option value="Mobiliarios">Mobiliarios</option>
                                        <option value="Pisos, muros y plafones">Pisos, muros y plafones</option>
                                        <option value="Puertas y cerraduras">Puertas y cerraduras</option>
                                        <option value="Equipos de cómputo">Equipos de cómputo</option>
                                        <option value="Plagas">Plagas</option>
                                        <option value="Señalización">Señalización</option>
                                        <option value="Letreros luminosos">Letreros luminosos</option>

                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>



                    <div class="form-group">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend ">
                                        <div class="input-group-text bg-primary">Tipo/Area</div>
                                    </div>
                                    <select id="area" class="form-control area-dropdown" multiple="multiple" style="margin-right: 20px">
                                        
                                        <option value="Patio de venta">Patio de venta</option>
                                        <option value="Áreas comunes">Áreas comunes</option>
                                        <option value="Site">Site</option>
                                        <option value="Bodega">Bodega</option>
                                        <option value="Laboratorío">Laboratorío</option>
                                        <option value="Bodega Costumer Service">Bodega Costumer Service</option>
                                        <option value="Fachada">Fachada</option>
                                        <option value="Pasillo de servicio">Pasillo de servicio</option>
                                        <option value="Computo y sistemas">Computo y sistemas</option>
                                        <option value="GM3">GM3</option>
                                        <option value="Display">Display</option>
                                        <option value="Evidencias">Evidencias</option>
                                        <option value="Seguridad">Seguridad</option>

                                    </select>
                                </div>
                            </div>
                            @if (auth()->user()->id_usuario == 496 ||
                                    auth()->user()->id_usuario == 497 ||
                                    auth()->user()->id_usuario == 433 ||
                                    auth()->user()->id_usuario == 495||
                                    auth()->user()->id_usuario == 502 ||
                                    auth()->user()->id_usuario == 503 ||
                                    auth()->user()->id_usuario == 504)
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend ">
                                            <div class="input-group-text bg-primary">Prioridad</div>
                                        </div>
                                        <select id="prioridad" class="form-control prioridad-dropdown" multiple="multiple" style="margin-right: 20px">
                                            
                                            <option value="Alta">Alta</option>
                                            <option value="Media">Media</option>
                                            <option value="Baja">Baja</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend ">
                                            <div class="input-group-text bg-primary">Distrito</div>
                                        </div>
                                        <select id="distrito" class="form-control distrito-dropdown" multiple="multiple" style="margin-right: 20px">
                                            
                                            <option value="BAJIO">BAJIO</option>
                                            <option value="CENTRO NORTE">CENTRO NORTE</option>
                                            <option value="CENTRO SUR">CENTRO SUR</option>
                                            <option value="NORTE.">NORTE</option>
                                            <option value="SURESTE">SURESTE</option>
                                            <option value="HUBS">HUBS</option>
                                            <option value="CORPORATIVO">CORPORATIVO</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
							
                            <input type="text" id="multiselect_area" hidden>
                            <input type="text" id="multiselect_prioridad" hidden>
                            <input type="text" id="multiselect_distrito" hidden>
                            <input type="text" id="multiselect_status" hidden>
                            <input type="text" id="multiselect_sucursal" hidden>
                            <input type="text" id="multiselect_categoria" hidden>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                @php
                    $responsable = auth()->user()->complete_name;
                @endphp



                {{-- <x-proyectos9 :estatus="$estatus ?? null" :estado="$estado ?? null" id="ticketsIndex" :disableSort="[7]">


                </x-proyectos9> --}}


                <x-lsm :estatus="$estatus ?? null" id="ticketsIndex" :disableSort="[7]">


                </x-lsm>



                <div class="modal fade" id="exampleFoto" tabindex="-1" role="dialog"
                    aria-labelledby="exampleFotoLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleFotoLabel">EVIDENCIAS</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="ticket_foto">
                                <div class="modal-body">

                                    @csrf





                                    <div id="fotos"style="display:none" class="col-12 col-md-6 mb-3">

                                        <x-form.inputfile capture="user" label="Evidencia del proceso 1 (opcional)"
                                            model="evidencia_proceso0" accept=".jpg,.jpeg,.png" />
                                        <x-form.inputfile capture="user" label="Evidencia del proceso 2 (opcional)"
                                            model="evidencia_proceso1" accept=".jpg,.jpeg,.png" />
                                    </div>



                                    <br>
                                    <div id="div">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label">Evidencia del proceso:</label>

                                        <div id="imagen55">


                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6 mb-3">
                                        <label class="form-label"></label>

                                        <div id="imagen66">


                                        </div>

                                    </div>

                                </div>







                              













                                </div>
                                <hr style="background-color: #4ae">
                                <div id="fotos2" style="display:none" class="col-12 col-md-6 mb-3">
                                    <x-form.inputfile capture="user" label="Evidencia de solución 1"
                                        model="evidencia_final0" accept=".jpg,.jpeg,.png" />
                                    <x-form.inputfile capture="user" label="Evidencia de solución 2"
                                        model="evidencia_final1" accept=".jpg,.jpeg,.png" />
                                </div>



                                <br>
                                <div id="div2">
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label">Evidencia final:</label>

                                    <div id="imagen33">


                                    </div>


                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label"></label>

                                    <div id="imagen44">


                                    </div>

                                </div>

                            </div>


								
                            <hr style="background-color: #4ae">
                            <div    class="col-12 col-md-6 mb-3">
                                <label>Comentarios:</label>
                                <textarea name="myText" id="myText" rows="6" cols="50" ></textarea>
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
                                    <select class="form-control" id="estado_tcs" name="estado_tcs">




                                        <option value="Atendido">Atendido</option>
                                        <option value="En proceso">En proceso</option>
                                        <option value="No atendido">No atendido</option>

                                    </select>
                                    <br>
                                    <label class="form-label">Prioridad</label>
                                    <select class="form-control" id="prio_ajax" name="prio_ajax">

                                        <option value="Baja">Baja</option>
                                        <option value="Media">Media</option>
                                        <option value="Alta">Alta</option>

                                    </select>
                                    <br>

                                    <label class="form-label">Folio CPS</label>
                                    <input type="text" class="form-control" id="ticket_sumapp_lsm"
                                        name="ticket_sumapp_lsm">

                                    <br>

                                    <label class="form-label">Descripción</label>
                                    <textarea type="text" class="form-control" id="descripcion_lsm" name="descripcion_lsm"></textarea>


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
                                            <input readonly type="text" class="form-control" id="folio2"
                                                name="folio2">
                                        </div>
                                        <div class="col-12 col-md-4 mb-3">
                                            <label class="form-label">Creación:</label>
                                            <input readonly type="text" class="form-control" id="crear"
                                                name="folio2">
                                        </div>
                                        <div class="col-12 col-md-4 mb-3">
                                            <label class="form-label">Actualización:</label>
                                            <input readonly type="text" class="form-control" id="actualizar"
                                                name="folio2">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Estado</label>
                                            <input readonly type="text" class="form-control" id="estado_tcs2"
                                                name="estado_tcs2">
                                        </div>


                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Prioridad</label>
                                            <input readonly type="text" class="form-control" id="prioridad2"
                                                name="prioridad2">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Autor</label>
                                            <input readonly type="text" class="form-control" id="autor_lsm"
                                                name="autor_lsm">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Sucursal</label>
                                            <input readonly type="text" class="form-control" id="Sucursal"
                                                name="prioridad2">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Area</label>
                                            <input readonly type="text" class="form-control" id="Area"
                                                name="prioridad2">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Categoría</label>
                                            <input readonly type="text" class="form-control" id="categoria_lsm"
                                                name="categoria_lsm">
                                        </div>

                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Folio CPS</label>
                                            <input readonly type="text" class="form-control" id="folio_lsm"
                                                name="folio_lsm">
                                        </div>


                                        <br>

                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Descripcion:</label>
                                            <textarea readonly type="text" class="form-control" id="descripcion" name="realizo2"></textarea>
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
                    $('#ticket_edit').submit(function(e) {
                        e.preventDefault();
                        let folio2 = $('#folio').val();
                        let estado2 = $('#estado_tcs').val();
                        let prioridad2 = $('#prio_ajax').val();
                        let folio_cps_2 = $('#ticket_sumapp_lsm').val();
                        let descripcion_2 = $('#descripcion_lsm').val();
                        let token2 = $("input[name=_token]").val();

                        Loader.show();
                        $.ajax({
                            url: "{{ route('web.dashboard.update_ajax_lsm') }}",
                            type: "POST",
                            data: {
                                folio: folio2,
                                edo: estado2,
                                prority: prioridad2,
                                cps: folio_cps_2,
                                descripcion: descripcion_2,
                                "_token": $("meta[name='csrf-token']").attr("content")
                            },

                            success: function(data) {


                                if (data.error == 'Ocurrio un error') {

                                    Loader.hide();
                                    Swal.fire(
                                        'El ticket tiene que tener evidencias finales para poder pasar Atendido',
                                        'Pulse ok para continuar!',
                                        'error')


                                } else {
                                    console.log("aqio" + data.prioridad);
                                    $('#estatus' + folio2).html(data.estado);
                                    $('#prioridad' + folio2).html(data.prioridad);
                                    $('#descripcion_lsm' + folio2).html(data.descripcion);
                                    $('#cps' + folio2).html(data.cps);
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
                                    element: document.querySelector('#type'),
                                    intro: '<h3>Filtro tipo de ticket</h3>Filtrar por tipo de ticket (Preventivo,Correctivo y Modificaciones)',
                                    position: 'top'
                                },
                                {
                                    element: document.querySelector('#ticketsIndexDataTable_length'),
                                    intro: '<h3>Selector de registros</h3>Seleccionar cuantos registros quieres mostrar',
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


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        #imagen-principal {
            width: 100%;
            /* Ajusta el porcentaje según tus necesidades */
            height: 100%;
        }


        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 8px;
        }

        .gallery img {
            width: 100%;
        }

        .image-container {
            position: relative;
            display: inline-block;
        }

        .overlay-text {
            position: absolute;
            top: 40%;
            left: 51%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px;
            border-radius: 5px;

        }

        .image-description {
            margin-top: 10px;
            /* Ajusta el margen superior según tus preferencias */
            text-align: center;
        }
    </style>
    <style>
        body.lb-disable-scrolling {
            overflow: hidden;
        }

        .lightboxOverlay {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 9999;
            background-color: black;
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);
            opacity: 0.8;
            display: none;
        }

        .lightbox {
            position: absolute;
            left: 0;
            width: 100%;
            z-index: 10000;
            text-align: center;
            line-height: 0;
            font-weight: normal;
            outline: none;
        }

        .lightbox .lb-image {
            display: block;
            width: 657.111px !important;
            height: 595.111px !important;
            max-width: inherit;
            max-height: none;
            border-radius: 3px;

            /* Image border */
            border: 4px solid white;
        }

        .lightbox a img {
            border: none;
        }

        .lb-outerContainer {
            position: relative;
            *zoom: 1;
            width: 656px !important;
            height: 594px !important;
            margin: 0 auto;
            border-radius: 4px;

            /* Background color behind image.
         This is visible during transitions. */
            background-color: white;
        }

        .lb-outerContainer:after {
            content: "";
            display: table;
            clear: both;
        }

        .lb-loader {
            position: absolute;
            top: 43%;
            left: 0;
            height: 25%;
            width: 100%;
            text-align: center;
            line-height: 0;
        }

        .lb-cancel {

            display: block;
            width: 32px;
            height: 32px;
            margin: 0 auto;
            background: url(../images/loading.gif) no-repeat;
        }

        .lb-nav {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 10;
        }

        .lb-container>.nav {
            left: 0;
        }

        .lb-nav a {
            outline: none;
            background-image: url('data:image/gif;base64,R0lGODlhAQABAPAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
        }

        .lb-prev,
        .lb-next {
            height: 100%;
            cursor: pointer;
            display: block;
        }

        .lb-nav a.lb-prev {
            width: 34%;
            left: 0;
            float: left;
            background: url(../images/prev.png) left 48% no-repeat;
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
            opacity: 0;
            -webkit-transition: opacity 0.6s;
            -moz-transition: opacity 0.6s;
            -o-transition: opacity 0.6s;
            transition: opacity 0.6s;
        }

        .lb-nav a.lb-prev:hover {
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
            opacity: 1;
        }

        .lb-nav a.lb-next {
            width: 64%;
            right: 0;
            float: right;
            background: url(../images/next.png) right 48% no-repeat;
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=0);
            opacity: 0;
            -webkit-transition: opacity 0.6s;
            -moz-transition: opacity 0.6s;
            -o-transition: opacity 0.6s;
            transition: opacity 0.6s;
        }

        .lb-nav a.lb-next:hover {
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
            opacity: 1;
        }

        .lb-dataContainer {
            margin: 0 auto;
            padding-top: 5px;
            *zoom: 1;
            width: 100%;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .lb-dataContainer:after {
            content: "";
            display: table;
            clear: both;
        }

        .lb-data {
            padding: 0 4px;
            color: #ccc;
        }

        .lb-data .lb-details {
            width: 85%;
            float: left;
            text-align: left;
            line-height: 1.1em;
        }

        .lb-data .lb-caption {
            font-size: 13px;
            font-weight: bold;
            line-height: 1em;
        }

        .lb-data .lb-caption a {
            color: #4ae;
        }

        .lb-data .lb-number {
            display: block;
            clear: left;
            padding-bottom: 1em;
            font-size: 12px;
            color: #999999;
        }

        .lb-data .lb-close {
            display: block;
            float: right;
            width: 30px;
            height: 30px;
            background: url(../images/close.png) top right no-repeat;
            text-align: right;
            outline: none;
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=70);
            opacity: 0.7;
            -webkit-transition: opacity 0.2s;
            -moz-transition: opacity 0.2s;
            -o-transition: opacity 0.2s;
            transition: opacity 0.2s;
        }

        .lb-data .lb-close:hover {
            cursor: pointer;
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=100);
            opacity: 1;
        }
    </style>















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
    <script>
        function eliminarItem(idTicket) {
            Swal.fire({
                icon: 'question',
                title: '¿Deseas continuar?',
                text: `Estás a punto de eliminar el ticket #${idTicket}, ten en cuenta que esta acción es permanente`,
                confirmButtonText: 'Si, continuar',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
            }).then((res) => {
                if (res.isConfirmed) {
                    Loader.show();
                    $(`#formDeleteTicket${idTicket}`).submit();
                }
            });
        }
    </script>



    <script type="text/javascript">
        function executeAjaxRequest() {
            Loader.show();
        }
    </script>
    
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
 
 <script>


$('.categoria-dropdown').select2({
    width: '55%',  // Puedes ajustar el ancho según tus necesidades
    allowClear: true, // Opción para permitir deseleccionar
    placeholder: "Seleccione...", // Texto de marcador de posición
    closeOnSelect: false, // Para mantener abierto después de la selección
    tags: true, // Para permitir etiquetas personalizadas (nuevas opciones no listadas)
});

// Puedes agregar eventos adicionales o personalizar según tus necesidades
$('.categoria-dropdown').on('change', function() {
    printSelectedValues_categoria();
});


$('.sucursal-dropdown').select2({
    width: '55%',  // Puedes ajustar el ancho según tus necesidades
    allowClear: true, // Opción para permitir deseleccionar
    placeholder: "Seleccione...", // Texto de marcador de posición
    closeOnSelect: false, // Para mantener abierto después de la selección
    tags: true, // Para permitir etiquetas personalizadas (nuevas opciones no listadas)
});

// Puedes agregar eventos adicionales o personalizar según tus necesidades
$('.sucursal-dropdown').on('change', function() {
    printSelectedValues_sucursal();
});
 

$('.status-dropdown').select2({
    width: '62%',  // Puedes ajustar el ancho según tus necesidades
    allowClear: true, // Opción para permitir deseleccionar
    placeholder: "Seleccione...", // Texto de marcador de posición
    closeOnSelect: false, // Para mantener abierto después de la selección
    tags: true, // Para permitir etiquetas personalizadas (nuevas opciones no listadas)
});

// Puedes agregar eventos adicionales o personalizar según tus necesidades
$('.status-dropdown').on('change', function() {
    printSelectedValues_status();
});
   

$('.area-dropdown').select2({
    width: '55%',  // Puedes ajustar el ancho según tus necesidades
    allowClear: true, // Opción para permitir deseleccionar
    placeholder: "Seleccione...", // Texto de marcador de posición
    closeOnSelect: false, // Para mantener abierto después de la selección
    tags: true, // Para permitir etiquetas personalizadas (nuevas opciones no listadas)
});

// Puedes agregar eventos adicionales o personalizar según tus necesidades
$('.area-dropdown').on('change', function() {
    printSelectedValues();
});


$('.prioridad-dropdown').select2({
    width: '55%',  // Puedes ajustar el ancho según tus necesidades
    allowClear: true, // Opción para permitir deseleccionar
    placeholder: "Seleccione...", // Texto de marcador de posición
    closeOnSelect: false, // Para mantener abierto después de la selección
    tags: true, // Para permitir etiquetas personalizadas (nuevas opciones no listadas)
});

// Puedes agregar eventos adicionales o personalizar según tus necesidades
$('.prioridad-dropdown').on('change', function() {
    printSelectedValues_prioridad();
});


$('.distrito-dropdown').select2({
    width: '62%',  // Puedes ajustar el ancho según tus necesidades
    allowClear: true, // Opción para permitir deseleccionar
    placeholder: "Seleccione...", // Texto de marcador de posición
    closeOnSelect: false, // Para mantener abierto después de la selección
    tags: true, // Para permitir etiquetas personalizadas (nuevas opciones no listadas)
});

// Puedes agregar eventos adicionales o personalizar según tus necesidades
$('.distrito-dropdown').on('change', function() {
    printSelectedValues_distrito();
});


function printSelectedValues() {
    selectedValues = $('.area-dropdown').val();
    $('#multiselect_area').val(selectedValues);
    console.log(selectedValues);
} 
function printSelectedValues_prioridad() {
    selectedValues = $('.prioridad-dropdown').val();
    $('#multiselect_prioridad').val(selectedValues);
    console.log(selectedValues);
} 
function printSelectedValues_distrito() {
    selectedValues = $('.distrito-dropdown').val();
    $('#multiselect_distrito').val(selectedValues);
    console.log(selectedValues);
} 
function printSelectedValues_status() {
    selectedValues = $('.status-dropdown').val();
    $('#multiselect_status').val(selectedValues);
    console.log(selectedValues);
} 

function printSelectedValues_sucursal() {
    selectedValues = $('.sucursal-dropdown').val();
    $('#multiselect_sucursal').val(selectedValues);
    console.log(selectedValues);
} 

function printSelectedValues_categoria() {
    selectedValues = $('.categoria-dropdown').val();
    $('#multiselect_categoria').val(selectedValues);
    console.log(selectedValues);
} 

  </script>
@stop
