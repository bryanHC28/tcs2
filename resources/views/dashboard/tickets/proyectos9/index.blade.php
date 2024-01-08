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
                                <option value="Cerrado">Cerrado</option>
                                <option value="Cancelado">Cancelado</option>
                                <option value="Ejecutado">Ejecutado</option>
                            </select>

                            @php
                                if (auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314) {
                                    $oculto = 'hidden';
                                } else {
                                    $oculto = '';
                                }
                                
                            @endphp
                            <div {{ $oculto }} class="input-group-prepend">
                                <div class="input-group-text bg-info"><i class="fa fa-cube"
                                        aria-hidden="true"></i>&nbsp;Area</div>
                            </div>
                            <div hidden>
                                <select id="estado" class="form-control estado-dropdown" style="margin-right: 20px">
                                    <option value="">Todos</option>
                                    <option value="Vencido">Vencido</option>
                                </select>
                            </div>

                            <select {{ $oculto }} id="area" class="form-control area-dropdown">
                                @if (auth()->user()->id_sucursal == 200)
                                    <option value="">Todos</option>
                                    <option value="Cuauhtémoc comercial">Cuauhtémoc comercial</option>
                                    <option value="Cuauhtémoc residencial">Cuauhtémoc residencial</option>
                                @elseif (auth()->user()->id_sucursal == 201)
                                    <option value="">Todos</option>
                                    <option value="PASILLOS">PASILLOS</option>
                                    <option value="ESTACIONAMIENTO">ESTACIONAMIENTO</option>
                                    <option value="MODULO 1">MODULO 1</option>
                                    <option value="MODULO 2">MODULO 2</option>
                                    <option value="MODULO 3">MODULO 3</option>
                                    <option value="MODULO 4">MODULO 4</option>
                                    <option value="MODULO 5">MODULO 5</option>
                                    <option value="MODULO 6">MODULO 6</option>
                                @elseif (auth()->user()->id_sucursal == 111)
                                <option value="">Todos</option>
                                <option value="VIVIENDA">VIVIENDA</option>
                                <option value="LOBBY VIVIENDA">LOBBY VIVIENDA</option>
                                <option value="ESTACIONAMIENTO VIVIENDA">ESTACIONAMIENTO VIVIENDA</option>
                                <option value="COMERCIO">COMERCIO</option>
                                <option value="OFICINAS">OFICINAS</option>
                                <option value="ESTACIONAMIENTO COMERCIO OFICINAS">ESTACIONAMIENTO COMERCIO OFICINAS</option>
                                @endif
                            </select>


                            &nbsp;
                            &nbsp;
                            &nbsp;

                            <div class="input-group-prepend">
                                <div class="input-group-text bg-info"><i class="fa fa-cube" aria-hidden="true"></i>&nbsp;
                                    @if (auth()->user()->id_usuario == 445 || auth()->user()->id_usuario == 318)
                                        Creados por:
                                    @else
                                        Asignados
                                    @endif
                                </div>
                            </div>
                            <select id="asignados" class="form-control asignados-dropdown">
                                <option value="">Todos</option>

                                @if (auth()->user()->id_sucursal == 200)
                                    <option value="Jose Castillo">Jose Castillo</option>
                                    <option value="Mariana Vazquez">Mariana Vazquez</option>
                                    <option value="Ricardo Garza">Ricardo Garza</option>
                                    <option value="Joaquin Sanchez">Joaquin Sanchez</option>
                                    <option value="Cristina Herrera">Cristina Herrera</option>
                                    <option value="Juan Sauceda">Juan Sauceda</option>
                                    <option value="Harim Bustos">Harim Bustos</option>
                                    <option value="Juan de León">Juan de León</option>
                                    @if (auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314)
                                        <option value="Elias Quiñones">Elias Quiñones</option>
                                        <option value="Oscar Saucedo">Oscar Saucedo</option>
                                        <option value="Reynaldo García">Reynaldo García</option>     
                                    @endif
                                @elseif (auth()->user()->id_sucursal == 111)
                                <option value="Reynaldo García">Reynaldo García</option>          
                                @else
                                    <option value="Elias Quiñones">Elias Quiñones</option>
                                    <option value="Oscar Saucedo">Oscar Saucedo</option>
                                @endif

                            </select>

                            &nbsp;
                            &nbsp;
                            &nbsp;



                            @if (auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314)
                                <div class="input-group-prepend ">
                                    <div class="input-group-text bg-primary"><i class="fa fa-hourglass-start"
                                            aria-hidden="true"></i>&nbsp;Sucursal</div>
                                </div>
                                <select id="sucursal" class="form-control sucursal-dropdown">
                                    <option value="">Todos</option>
                                    <option value="Cuauhtémoc comercial">Cuauhtémoc comercial</option>
                                    <option value="Cuauhtémoc residencial">Cuauhtémoc residencial</option>
                                    <option value="Almanara">Almanara</option>
                                    <option value="Trebol Park">Trebol Park</option>
                                </select>
                            @endif
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



                <x-proyectos9 :estatus="$estatus ?? null" :estado="$estado ?? null" id="ticketsIndex" :disableSort="[7]">


                </x-proyectos9>








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



                                        <option value="Abierto">Abierto</option>
                                        <option value="Ejecutado">Ejecutado</option>
                                        <option value="Cancelado">Cancelado</option>
                                        <option hidden value="Cerrado">Cerrado</option>
                                        @if (
                                            (auth()->user()->rol_tickets == 'gerente' && auth()->user()->id_empresa == 33) ||
                                                (auth()->user()->rol_tickets == 'Administrador' && auth()->user()->id_empresa == 33))
                                            <option value="Cerrado">Cerrado</option>
                                        @endif

                                    </select>
                                    <br>
                                    <label class="form-label">Prioridad</label>
                                    <select class="form-control" id="prioridad" name="prioridad">

                                        <option value="Baja">Baja</option>
                                        <option value="Media">Media</option>
                                        <option value="Alta">Alta</option>

                                    </select>
                                    <br>

                                    <label class="form-label">Tipo ticket</label>
                                    <select class="form-control" id="tipo_tcs" name="tipo_tcs">


                                        <option value="Preventivo">Preventivo</option>
                                        <option value="Correctivo">Correctivo</option>
                                        <option value="Modificaciones">Modificaciones</option>
                                        <option value="Rutinario">Rutinario</option>
                                        <option value="Mejora continua">Mejora continua</option>


                                    </select>
                                    <br>
                                    @if (auth()->user()->id_usuario == 312 ||
                                         auth()->user()->id_usuario == 374 ||
                                         auth()->user()->id_usuario == 445 ||
                                         auth()->user()->id_usuario == 321 ||
                                         auth()->user()->id_usuario == 318)
                                        <label class="form-label">Reasignar:</label>
                                        <select class="form-control" id="realizo" name="realizo">
                                            @if (auth()->user()->id_usuario == 318 || auth()->user()->id_usuario == 445)
                                                <option hidden value="Juan Sauceda">Juan Sauceda</option>
                                                <option hidden value="Harim Bustos">Harim Bustos</option>
                                                <option hidden value="Juan de León">Juan de León</option>
                                                <option value="Jose Castillo">Jose Castillo</option>
                                                <option value="Mariana Vazquez">Mariana Vazquez</option>
                                                <option value="Cristina Herrera">Cristina Herrera</option>

                                            @elseif (auth()->user()->id_usuario == 312)
                                            <option value="Juan Sauceda">Juan Sauceda</option>
                                            <option value="Harim Bustos">Harim Bustos</option>
                                            <option value="Juan de León">Juan de León</option>
                                            <option value="Jose Castillo">Jose Castillo</option>
                                            <option hidden value="Mariana Vazquez">Mariana Vazquez</option>
                                            <option hidden value="Cristina Herrera">Cristina Herrera</option>
                                            @elseif (auth()->user()->id_usuario == 374||auth()->user()->id_usuario == 321)
                                            <option value="Elias Quiñones">Elias Quiñones</option>
                                            <option value="Oscar Saucedo">Oscar Saucedo</option>
                                            @endif
                                            
                                        </select>

                                        <br>
                                        <label class="form-label">Fecha comienzo:</label>
                                        <input type="date" class="form-control" id="fecha_comienzo"
                                            name="fecha_comienzo">
                                    @else
                                        <input hidden type="text" class="form-control" id="realizo" name="realizo">
                                        <input hidden type="date" class="form-control" id="fecha_comienzo"
                                            name="fecha_comienzo">
                                    @endif


                                    @if (auth()->user()->id_empresa == 33)

                                        @if (auth()->user()->id_usuario == 445 ||auth()->user()->id_usuario == 300|| auth()->user()->id_usuario == 318 || auth()->user()->id_usuario == 321)
                                            <br>
                                            <label class="form-label">Fecha cita:</label>
                                            <input type="datetime-local" class="form-control" id="fecha_cita"
                                                name="fecha_cita">
                                        @else
                                            <br>
                                            <label readonly class="form-label">Fecha cita:</label>
                                            <input readonly type="datetime-local" class="form-control" id="fecha_cita"
                                                name="fecha_cita">
                                        @endif


                                    @endif
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
                                            <label class="form-label">Tipo ticket</label>
                                            <input readonly type="text" class="form-control" id="tipo_tcs2"
                                                name="tipo_tcs2">
                                        </div>

                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Realizo</label>
                                            <input readonly type="text" class="form-control" id="realizo2"
                                                name="realizo2">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label"> Fecha estimada:</label>
                                            <input readonly type="text" class="form-control" id="fecha_de_entrega"
                                                name="realizo2">
                                        </div>

                                        <br>

                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Nivel:</label>
                                            <input readonly type="text" class="form-control" id="nivel"
                                                name="nivel">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Fecha cita:</label>
                                            <input readonly type="text" class="form-control" id="fecha_citas"
                                                name="fecha_citas">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Fecha comienzo:</label>
                                            <input readonly type="text" class="form-control" id="fecha_comienzos"
                                                name="fecha_comienzos">
                                        </div>
                                        <br>
                                        <div class="col-12 col-md-6 mb-3">
                                            <label class="form-label">Acción a realizar:</label>
                                            <textarea readonly type="text" class="form-control" id="accion_realizar" name="accion_realizar"></textarea>
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
                        let prioridad2 = $('#prioridad').val();
                        let tipo_ticket2 = $('#tipo_tcs').val();
                        let realizo = $('#realizo').val();
                        let fecha_cita = $('#fecha_cita').val();
                        let fecha_comienzo = $('#fecha_comienzo').val();
                        let token2 = $("input[name=_token]").val();
                        Loader.show();
                        $.ajax({
                            url: "{{ route('web.dashboard.update_ajax') }}",
                            type: "POST",
                            data: {
                                folio: folio2,
                                edo: estado2,
                                prority: prioridad2,
                                type_tct: tipo_ticket2,
                                realizo2: realizo,
                                fecha_cita2: fecha_cita,
                                fecha_comienzo2: fecha_comienzo,
                                "_token": $("meta[name='csrf-token']").attr("content")
                            },

                            success: function(data) {


                                if (data.error == 'Ocurrio un error') {

                                    Loader.hide();
                                    Swal.fire(
                                        'El ticket tiene que pasar por el estado ejecutado para poder cerrarlo',
                                        'Pulse ok para continuar!',
                                        'error')


                                } else if (data.error2 == 'Ocurrio un error pilot') {
                                    Loader.hide();
                                    Swal.fire(
                                        'El ticket tiene que pasar por el estado Cerrado para poder dar Cierre final',
                                        'Pulse ok para continuar!',
                                        'error')

                                } else {
                                    $('#asignament' + folio2).html(data.realizo);
                                    $('#estatus' + folio2).html(data.var);
                                    $('#prioridad' + folio2).html(data.prioridad);
                                    $('#tipo' + folio2).html(data.tipo_tcs);
                                    $('#cita' + folio2).html(data.cita);
                                    $('#exampleModal').modal('hide');
                                    Loader.hide();
                                    Swal.fire(
                                        'Ticket actualizado!',
                                        'Pulse ok para continuar!',
                                        'success')

                                }
                                //  toastr.info('El registro es actualizado correctamente','Actualizar registro',{timeOut:3000});
                                //  $('#ticketsIndexDataTable').DataTable().ajax.reload();

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


<style>
    *{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}
 
#imagen-principal{
    width: 100%; /* Ajusta el porcentaje según tus necesidades */
  height: 100%;
  }


.gallery{
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    grid-gap: 8px;
}
.gallery img{
    width: 100%;
}.image-container {
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
    margin-top: 10px; /* Ajusta el margen superior según tus preferencias */
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

.lb-container > .nav {
  left: 0;
}

.lb-nav a {
  outline: none;
  background-image: url('data:image/gif;base64,R0lGODlhAQABAPAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');
}

.lb-prev, .lb-next {
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

@stop
