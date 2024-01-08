@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
 
    <h1>{{ trans('messages.tcs') }}</h1>
 
@stop

@section('content')
    <div class="pb-2">
        <div class="card">

            <div class="card-body">
                
                <div class="col text-center">
                    <button onclick="tutorial();" class="btn btn-primary"><i class="fa fa-play-circle"
                            aria-hidden="true"></i>&nbsp;{{ trans('messages.tutorial') }}</button>
                </div>
                <br>
              
                <form action="{{ route('web.dashboard.tickets.store') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="Loader.show()">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
 
                            <x-form.select   label="{{ trans('messages.branch') }}" model="sucursal" onchange="getAreas(this.value),getResponzables(this.value)" required>
                                <option value="">{{ trans('messages.elige_sucursal') }}</option>
                                @foreach ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id_sucursal }}"
                                        {{ old('sucursal') != $sucursal->id_sucursal ?: 'selected' }}>
                                        {{ $sucursal->sucursal }}
                                    </option>
                                @endforeach
                            </x-form.select>                            
                        </div>




                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="{{ trans('messages.prioridad') }}" model="prioridad" required>
                                <option value="">{{ trans('messages.elige_prioridad') }}</option>
                                <option value="Alta">{{ trans('messages.alta') }}</option>
                                <option value="Media">{{ trans('messages.media') }}</option>
                                <option value="Baja">{{ trans('messages.baja') }}</option>
                            </x-form.select>
                            </div>




                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select choices label="Area" model="area" onchange="getSubareas(this.value),getCategorias()" required>
                                <option value="">{{ trans('messages.elige_area') }}</option>
                            </x-form.select>
                        </div>


                        
                        <div class="col-12 col-md-6 mb-3" id="seccionsubarea"  @if(auth()->user()->id_empresa!=33)style="display: none"@endif>
                            <x-form.select label="Subarea" model="subarea"  >
                                <option value="">Elige una subarea</option>
                            </x-form.select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="{{ trans('messages.categoria') }}" model="categoria" onchange="getSubcategorias(this.value)"
                                required>
                                <option value="">{{ trans('messages.elige_categoria') }}</option>
                            </x-form.select>
                        </div>

                        
                        
                            <div class="col-12 col-md-6 mb-3 ui-widget">
                                 <x-form.input label="{{ trans('messages.equipo') }}" model="inventario" id="inventario" placeholder="{{ trans('messages.escribe') }}" />

                            </div>
                        
                        
                            <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="{{ trans('messages.tipo_ticket') }}" model="tipo_ticket" required>
                                <option value="">{{ trans('messages.elige_tipo_ticket') }}</option>
                                <option value="Preventivo">{{ trans('messages.preventivo') }}</option>
                                <option value="Correctivo">{{ trans('messages.correctivo') }}</option>
                                <option value="Modificaciones">{{ trans('messages.modificaciones') }}</option>
                                <option value="Rutinario">{{ trans('messages.rutinario') }}</option>                        
                            </x-form.select>
                            </div>


                         
                        
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.textarea label="{{ trans('messages.descripcion') }}" model="descripcion"
                                placeholder="{{ trans('messages.elige_descripcion') }}" />
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.textarea label="{{ trans('messages.trabajo_efectuado') }}" model="observaciones" placeholder="{{ trans('messages.ingrese') }}" />
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input type="number" label="{{ trans('messages.costo') }}" model="costo_estimado"
                                placeholder="{{ trans('messages.ingresa_costo') }}" />
                        </div>
                        

                        
                         

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input autocomplete="false"  placeholder="{{ trans('messages.click') }}" label="{{ trans('messages.fecha_entrega') }}"  model="fecha_estimada" />
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="{{ trans('messages.evidencia1') }}" model="evidencia0" accept=".jpg,.jpeg,.png" />



                        </div>


                        <div  class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="{{ trans('messages.evidencia2') }}" model="evidencia1" accept=".jpg,.jpeg,.png" />
                        </div>
                        <div class="col-12">
                            <hr>
                            <div class="text-right">
                                <a href="{{ route('web.dashboard.tickets.index') }}" class="btn btn-outline-danger cancelar">
                                    <i class="fas fa-times"></i> {{ trans('messages.cancelar') }}
                                </a>
                                <button type="submit" class="btn btn-primary listo">
                                    <i class="fas fa-check"></i> {{ trans('messages.listo') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('css')

 <link
      href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css"
      rel="stylesheet"
    />


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
<script>

$(document).ready(function() {
$(function() {
$('#fecha_estimada').datepicker({
dateFormat: 'yy-mm-dd',
showButtonPanel: false,
changeMonth: false,
changeYear: false,
/*showOn: "button",
buttonImage: "images/calendar.gif",
buttonImageOnly: true,*/
minDate: '+0D',
maxDate: '+3M',
inline: true
});
});
$.datepicker.regional['es'] = {
closeText: 'Cerrar',
prevText: '<Ant',
nextText: 'Sig>' ,
currentText: 'Hoy' ,
monthNames: ['Enero', 'Febrero' , 'Marzo' , 'Abril' , 'Mayo'
    , 'Junio' , 'Julio' , 'Agosto' , 'Septiembre' , 'Octubre' , 'Noviembre' , 'Diciembre' ],
    monthNamesShort:
    ['Ene', 'Feb' , 'Mar' , 'Abr' , 'May' , 'Jun' , 'Jul' , 'Ago' , 'Sep' , 'Oct' , 'Nov' , 'Dic' ],
    dayNames:
    ['Domingo', 'Lunes' , 'Martes' , 'Miércoles' , 'Jueves' , 'Viernes' , 'Sábado' ],
    dayNamesShort: ['Dom', 'Lun'
    , 'Mar' , 'Mié' , 'Juv' , 'Vie' , 'Sáb' ],
    dayNamesMin: ['Do', 'Lu' , 'Ma' , 'Mi' , 'Ju' , 'Vi' , 'Sá' ],
    weekHeader: 'Sm' ,
    dateFormat: 'dd/mm/yy' ,
    firstDay: 1,
    isRTL: false,
    showMonthAfterYear: false,
    yearSuffix: '' };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $(function () { $("#fecha_estimada").datepicker(); });
});


    function tutorial(){
                    introJs().setOptions({
                    nextLabel: 'Siguiente',
                    prevLabel: 'Anterior',
                    doneLabel: 'Terminar',
                    skipLabel: 'Omitir',
                    steps: [
                    {
                    element: document.querySelector('#sucursal'),
                    intro: '<h3>Sucursal</h3>Selecciona la sucursal correspondiente',
                    position: 'top'
                    },
                    {
                    element: document.querySelector('#area'),
                    intro: '<h3>Area</h3>Selecciona el area de la sucursal donde te encuentras: (Ejem.Planta 1, Planta 2, Calderas ,Etc)',
                    position: 'top'
                    },
                {
                element: document.querySelector('#categoria'),
                intro: '<h3>Categoria</h3> Selecciona la categoria del equipo (Ejem.Electrico,Mecanico,Civil,Etc)',
                position: 'top'
                },
                {
                element: document.querySelector('#inventario'),
                intro: '<h3>Equipo</h3>Selecciona el equipo que tiene la incidencia (Ejem.ABS-1,AIRECON,APILADOR,Etc)',
                position: 'top'
                },
                {
                element: document.querySelector('#tipo_ticket'),
                intro: '<h3>Tipo ticket</h3>Selecciona el tipo de ticket , si sera preventivo,correctivo o alguna modificacion',
                position: 'top'
                },
                {
                element: document.querySelector('#prioridad'),
                intro: '<h3>Prioridad</h3>Selecciona que prioridad tendria el ticket , si es urgente resolver la  incidencia selecciona prioridad alta de lo contrario seleccione prioridad media y baja dependiendo del tiempo asignado ',
                position: 'top'
                },
                {
                element: document.querySelector('#descripcion'),
                intro: '<h3>Descripcion</h3>Ingrese el detalle de la incidencia ',
                position: 'top'
                },
                {
                element: document.querySelector('#observaciones'),
                intro: '<h3>Trabajo efectuado por ingenieria y mantenimiento</h3>Ingrese que se realizo para resolver la incidencia ',
                position: 'top'
                },
                {
                element: document.querySelector('#costo_estimado'),
                intro: '<h3>Costo estimado</h3>Ingrese el costo($MXN) estimado que tendra resolver la incidencia  ',
                position: 'top'
                },
                {
                element: document.querySelector('#fecha_estimada'),
                intro: '<h3>Fecha de entrega a mantenimiento</h3>Selecciona la fecha estimada que se entragara a mantenimiento ',
                position: 'top'
                },
                {
                element: document.querySelector('#evidenciapreview'),
                intro: '<h3>Evidencia de falla</h3>Presiona la imagen para tomar una foto de la incidencia ',
                position: 'top'
                },
                {
                element: document.querySelector('.imgRemove'),
                intro: '<h3>Remover evidencia de falla</h3>Presiona este boton si la foto tomada no es la indicada o no se ve bien ',
                position: 'top'
                },
                {
                element: document.querySelector('.cancelar'),
                intro: '<h3>Cancelar captura de ticket</h3>Presiona este boton si ya no deseas capturar el ticket ',
                position: 'top'
                },
                {
                element: document.querySelector('.listo'),
                intro: '<h3>Guardar ticket</h3>Presiona este boton si deseas guardar el ticket ',
                position: 'top'
                }
            ]
                    }).start();
                    }
</script>
  <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
      integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script>
        let id_sucursal_var;

        /**
         * Obtiene las areas y las coloca en el input area
         **/
        let areas = [];

        function getAreas(id_sucursal) {
            id_sucursal_var = id_sucursal;
            $('#area').html(new Option('Elige una opción...', ''));

            Loader.show();
            axios.get(`{{ url('api/resources/areas') }}/${id_sucursal_var}`)
                .then(async (response) => {
                    $.each(areas = await response.data, (index, item) => {
                        $('#area').append(new Option(item.area, item.id));
                    });
                }).catch((error) => {
                    areas = [];
                    console.log(`getAreas() - ${error}`);
                }).finally(() => {
                    Loader.hide();
                });
        }



/**
 * Obtiene las areas y las coloca en el input area
 **/
let niveles = [];

function getNiveles(id_area) {
    id_area_var = id_area;
    $('#nivel').html(new Option('', ''));

    Loader.show();
    axios.get(`{{ url('api/resources/niveles') }}/${id_area_var}`)
        .then(async (response) => {
            $.each(niveles = await response.data, (index, item) => {
                $('#nivel').append(new Option(item.nivel_descripcion, item.nivel_descripcion));
            });
        }).catch((error) => {
            niveles = [];
            console.log(`getNiveles() - ${error}`);
        }).finally(() => {
            Loader.hide();
        });
}



        /**
        * Obtiene las subareas y las coloca en el input subareas
        **/
        let subareas = [];

        function getSubareas(id_area) {
        $('#subarea').html(new Option('Elige una subarea', ''));

        Loader.show();
        axios.get(`{{ url('api/resources/subareas') }}/${id_sucursal_var}/${id_area}`)
        .then(async (response) => {
        if(response.data.length>0){
            $('#seccionsubarea').show();
        $.each(subareas = await response.data, (index, item) => {
        $('#subarea').append(new Option(item.subarea, item.id));
        });
        }else{
        $('#seccionsubarea').hide();
        }
        }).catch((error) => {
        subareas = [];
        console.log(`getSubareas() - ${error}`);
        }).finally(async () => {
        Loader.hide();
        });
        }

        /**
         * Obtiene las categorias y las coloca en el input categoria
         **/
        let categorias = [];

        function getCategorias() {
            $('#categoria').html(new Option('Elige una categoría', ''));

            Loader.show();
            axios.get(`{{ url('api/resources/tcs-categorias') }}/${id_sucursal_var}`)
                .then(async (response) => {


                    $.each(categorias = await response.data, (index, item) => {
                        $('#categoria').append(new Option(item.categoria, item.id));
                    });

                }).catch((error) => {
                    categorias = [];
                    console.log(`getCategoria() - ${error}`);
                }).finally(async () => {
                    Loader.hide();
                });
        }

        /**
         * Obtiene las subcategorias y las coloca en el input subcategoria
         **/
        let subcategorias = [];

        function getSubcategorias(id_categoria) {
            $('#subcategoria').html(new Option('Elige una subcategoría', ''));

            Loader.show();
            axios.get(`{{ url('api/resources/tcs-subcategorias') }}/${id_sucursal_var}/${id_categoria}`)
                .then(async (response) => {
                    if(response.data.length>0){
                        $('#seccionsubcategoria').show();
                    $.each(subcategorias = await response.data, (index, item) => {
                        $('#subcategoria').append(new Option(item.subcategoria, item.id));
                    });
                    }else{
                    $('#seccionsubcategoria').hide();
                    }
                }).catch((error) => {
                    subcategorias = [];
                    console.log(`getSubcategorias() - ${error}`);
                }).finally(async () => {
                    Loader.hide();
                });
        }
        let categoriasAccor = [];

function getCategoriasAccor(id_area) {
console.log(id_area);


    $('#categoria').html(new Option('Elige una categoría', ''));

    Loader.show();


    if(id_area==8){
        $('#seccionhabitacion').css('display','block');
    }else
    $('#seccionhabitacion').css('display','none');

    axios.get(`{{ url('api/resources/tcs-categoriasAccor') }}/${id_area}`)
        .then(async (response) => {
            $.each(categorias = await response.data, (index, item) => {
                $('#categoria').append(new Option(item.categoria, item.id));
            });
        }).catch((error) => {
            categoriasAccor = [];
            console.log(`getCategoriasAccor() - ${error}`);
        }).finally(async () => {
            Loader.hide();
        });
}

 
    </script>

    <script>
        //Inventario
    $( function() {
     var availableTags = @JSON($inventario);
     $( "#inventario" ).autocomplete({
      source: availableTags
    });
    } );


    </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stop
