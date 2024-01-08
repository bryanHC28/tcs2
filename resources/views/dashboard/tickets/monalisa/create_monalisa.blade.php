@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
 
                            <a  class="btn btn-warning" href="https://checklist.sumapp.cloud/public/login?correo={{auth()->user()->correo}}&contrasena={{auth()->user()->contrasena}}" target="_blank">Equipos</a>
<br>
<br>
    <h1>Abrir Ticket</h1>
 
@stop

@section('content')
    <div class="pb-2">
        <div class="card">

            <div class="card-body">

                <form action="{{ route('web.dashboard.tcs_monalisa.store') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="Loader.show()">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">

                            <x-form.select   label="Sucursal" model="sucursal" onchange="getAreas(this.value)" required>
                                <option value="">Elige una sucursal</option>
                                @foreach ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id_sucursal }}"
                                        {{ old('sucursal') != $sucursal->id_sucursal ?: 'selected' }}>
                                        {{ $sucursal->sucursal }}
                                    </option>
                                @endforeach
                            </x-form.select>

                        </div>


                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select choices label="Area" model="area" onchange="getSubareas(this.value),getCategorias()" required>
                                <option value="">Elige una area</option>
                            </x-form.select>
                        </div>





                        <div class="col-12 col-md-6 mb-3" id="seccionsubarea"  @if(auth()->user()->id_empresa!=33)style="display: none"@endif>
                            <x-form.select label="Subarea" model="subarea"  >
                                <option value="">Elige una subarea</option>
                            </x-form.select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Categoría" model="categoria" onchange="getSubcategorias(this.value)" required>
                                <option value="">Elige una categoría</option>
                            </x-form.select>
                        </div>



                            <div class="col-12 col-md-6 mb-3" id="seccionsubcategoria" @if(auth()->user()->id_empresa!=33)style="display: none"@endif>
                            <x-form.select label="Subcategoría" model="subcategoria">
                                <option value="">Elige una subcategoría</option>
                            </x-form.select>
                            </div>




                         <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Responsable" model="persona_realizo" required>
                                <option value="">Elige un responsable</option>
                                @if (auth()->user()->id_usuario == 381 || auth()->user()->id_usuario == 382)
                                <option value="Tecnico 1">Tecnico 1</option>
                                <option value="Tecnico 2">Tecnico 2</option>
                                <option value="Tecnico 3">Tecnico 3</option>
                                <option value="Daniel Amaya">Daniel Amaya</option>
                                <option value="Auxiliar Sistemas">Auxiliar Sistemas</option>
                                @if (auth()->user()->id_usuario == 381)
                                <option value="Tecnico 3">Marco Dominguez</option>
                                @elseif (auth()->user()->id_usuario == 382)
                                <option value="Abel Gonzalez">Abel Gonzalez</option>
                                @endif
                                @else
                                <option value="Abel Gonzalez">Abel Gonzalez</option>
                                <option value="Marco Dominguez">Marco Dominguez</option>
                                @endif

                            </x-form.select>
                         </div>


<div class="col-12 col-md-6 mb-3"  >
                            <x-form.select label="Equipo" model="equipos"  >
                                <option value="">Elige un equipo</option>
                            </x-form.select>
                        </div>

                            <div class="col-12 col-md-6 mb-3">
                                <x-form.textarea label="Trabajo a realizar" model="accion_a_realizar" placeholder="Ingresa la acción a realizar" />
                            </div>




                        <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="Evidencia de falla 1 (opcional)" model="evidencia0" accept=".jpg,.jpeg,.png" />
                        </div>


                        <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="Evidencia de falla 2 (opcional)" model="evidencia1" accept=".jpg,.jpeg,.png" />
                        </div>
                        <div class="col-12">
                            <hr>
                            <div class="text-right">
                                <a href="{{ route('web.dashboard.tickets.index') }}" class="btn btn-outline-danger cancelar">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary listo">
                                    <i class="fas fa-check"></i> Listo
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
		  let equipo =[];
        axios.get(`https://checklist.sumapp.cloud/public/api/equipos`)
    .then(async (response) => {
        $.each(equipo = await response.data, (index, item) => {
            $('#equipos').append(new Option(item.nombre_equipo, item.nombre_equipo));
        });
    }).catch((error) => {
        equipo = [];
        console.log(`${error}`);
    }).finally(() => {
        // Código que se ejecutará siempre, incluso después de un error
    });
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
         * Obtiene los responzables y las coloca en el input responzable
         **/
         let responzables = [];

function getResponzables(id_sucursal) {
    id_sucursal_var = id_sucursal;
    $('#persona_realizo').html(new Option('Elige a un responzable...', ''));

    Loader.show();
    axios.get(`{{ url('api/resources/responzable') }}/${id_sucursal_var}`)
        .then(async (response) => {
            $.each(responzables = await response.data, (index, item) => {
                $('#persona_realizo').append(new Option(item.nombre, item.realizo));
            });
        }).catch((error) => {
            responzables = [];
            console.log(`getResponzables() - ${error}`);
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
<script>

$('#equipos').select2()
</script>
@stop
