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
                                <option value="Cancelado">Cancelado</option>
                                <option value="Validado">Validado</option>
                            </select>
 

							    &nbsp;
     &nbsp;
     &nbsp;

 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

               
                <x-accor :estatus="$estatus ?? null" id="ticketsIndex" :disableSort="[7]">


                </x-accor>

 




                            <!-- Modal edit-->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                        <label hidden  class="form-label">Folio</label>
                                        <input hidden type="text" class="form-control" id="folio" name="folio">
                                        <br>
                                        <label  class="form-label">Estado</label>
                                        <select class="form-control" id="estado_tcs" name="estado_tcs">

 
											<option value="Abierto">Abierto</option>
                                            <option value="Cancelado">Cancelado</option>
											<option value="En proceso">En proceso</option>
                                            <option value="Cerrado">Cerrado</option>
                                            <option value="Validado">Validado</option>

                                        </select>
                                        <br>
                                        <label  class="form-label">Prioridad</label>
                                        <select class="form-control" id="prioridad" name="prioridad">

                                            <option value="Baja">Baja</option>
                                            <option value="Media">Media</option>
                                            <option value="Alta">Alta</option>

                                        </select>
                                        <br>
                                       
                                        
                                    </div>
                                    <div class="modal-footer">

                                      <button type="submit"  class="btn btn-primary">Guardar</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </form>
                                  </div>
                                </div>
                              </div>

          <!-- Modal ver-->
          <div class="modal fade" id="verticket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input readonly  type="text" class="form-control" id="folio2" name="folio2">
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Creación:</label>
                    <input readonly  type="text" class="form-control" id="crear" name="folio2">
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <label class="form-label">Actualización:</label>
                    <input readonly  type="text" class="form-control" id="actualizar" name="folio2">
                </div>
                    <br>
                    <div class="col-12 col-md-6 mb-3">
                    <label  class="form-label">Estado</label>
                    <input readonly type="text" class="form-control" id="estado_tcs2" name="estado_tcs2">
                </div>


                    <br>
                    <div class="col-12 col-md-6 mb-3">
                    <label  class="form-label">Prioridad</label>
                    <input readonly type="text" class="form-control" id="prioridad2" name="prioridad2">
                </div>
                <br>
                    <div class="col-12 col-md-6 mb-3">
                    <label  class="form-label">Sucursal</label>
                    <input readonly type="text" class="form-control" id="Sucursal" name="prioridad2">
                </div>
                <br>
                    <div class="col-12 col-md-6 mb-3">
                    <label  class="form-label">Area</label>
                    <input readonly type="text" class="form-control" id="Area" name="prioridad2">
                </div>
              
                    <br>
                    <div class="col-12 col-md-6 mb-3">
                    <label  class="form-label">Realizo</label>
                    <input readonly type="text" class="form-control" id="realizo2" name="realizo2">
                </div>

                
                <div class="col-12 col-md-6 mb-3">
                    <label  class="form-label">No. Habitación</label>
                    <input readonly type="text" class="form-control" id="no_habiacion" name="no_habiacion">
                </div>
                <div class="col-12 col-md-6 mb-3">

                </div>
                <br>
             
              
            
            <div class="col-12 col-md-6 mb-3">
            <label  class="form-label">Descripcion:</label>
            <textarea readonly type="text" class="form-control" id="descripcion" name="realizo2"></textarea>
        </div>
 
    <div class="col-12 col-md-6 mb-3">
        <label  class="form-label">Evidencia inicial:</label>

        <div id="imagen1">


        </div>


    </div>
    <div class="col-12 col-md-6 mb-3">
        <label  class="form-label"></label>

    <div id="imagen2">


    </div>

</div>
 
<br>
<div class="col-12 col-md-6 mb-3">
    <label  class="form-label">Evidencia final:</label>

    <div id="imagen3">


    </div>


</div>
<div class="col-12 col-md-6 mb-3">
    <label  class="form-label"></label>

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
    $('#ticket_edit').submit(function(e){
                    e.preventDefault();
                    let folio2 =  $('#folio').val();
                    let estado2 =$('#estado_tcs').val();
                    let prioridad2 =$('#prioridad').val();
                    let tipo_ticket2 =$('#tipo_tcs').val();
                    let realizo =$('#realizo').val();
                    let fecha_cita = $('#fecha_cita').val();
                    let fecha_comienzo = $('#fecha_comienzo').val();
                    let token2 =$("input[name=_token]").val();
                    Loader.show();
                    $.ajax({
                      url:"{{ route('web.dashboard.update_ajax') }}",
                      type: "POST",
                      data:{
                           folio: folio2,
                           edo: estado2,
                           prority : prioridad2,
                           type_tct: tipo_ticket2,
                           realizo2: realizo,
                           fecha_cita2: fecha_cita,
                           fecha_comienzo2: fecha_comienzo,
                           "_token": $("meta[name='csrf-token']").attr("content")
                       },

                       success:function(data){


                        if(data.error=='Ocurrio un error'){

                            Loader.hide();
                           Swal.fire(
                              'El ticket tiene que pasar por el estado ejecutado para poder cerrarlo',
                              'Pulse ok para continuar!',
                              'error')


                        }else if(data.error2=='Ocurrio un error pilot'){
                            Loader.hide();
                           Swal.fire(
                              'El ticket tiene que pasar por el estado Cerrado para poder dar Cierre final',
                              'Pulse ok para continuar!',
                              'error')

                        }else{
                            $('#asignament'+ folio2).html(data.realizo);
                          $('#estatus'+ folio2).html(data.var);
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
     
 
@stop
