@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')

    <h1>Ticket #{{ $data->id + 1 }}</h1>
@stop

@section('content')
    <div class="pb-2">
        <div class="card">

            <div class="card-body">
                <form action="{{ route('web.dashboard.tcs_proyectos9.store') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="Loader.show()">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            @if (auth()->user()->id_sucursal == 200)

                                <div hidden>
                                    <x-form.select label="Sucursal" model="sucursal" required>
                                        <option selected value="200">Centro Cuauhtémoc</option>
                                    </x-form.select>
                                </div>
                                <x-form.select choices label="Plaza comercial" model="area"
                                    onchange="getNiveles(this.value)" required>
                                    <option value=""></option>
                                    <option value="106">Cuauhtémoc comercial</option>
                                    <option value="107">Cuauhtémoc residencial</option>
                                    @if (auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314)
                                        <option value="108">Almanara</option>
                                        <option value="125">Trebol Park</option>
                                    @endif
                                </x-form.select>
                            @elseif(auth()->user()->id_sucursal == 201)
                                <x-form.select label="Sucursal" model="sucursal"
                                    onchange="getAreas(this.value),getResponzables(this.value),getCategorias(this.value)" required> 
                                    <option value="">Elige una sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id_sucursal }}"
                                            {{ old('sucursal') != $sucursal->id_sucursal ?: 'selected' }}>
                                            {{ $sucursal->sucursal }}
                                        </option>
                                    @endforeach
                                </x-form.select>

                                @else

                                <x-form.select label="Sucursal" model="sucursal"
                                    onchange="getAreas(this.value),getCategorias(this.value)" required> 
                                    <option value="">Elige una sucursal</option>
                                    @foreach ($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id_sucursal }}"
                                            {{ old('sucursal') != $sucursal->id_sucursal ?: 'selected' }}>
                                            {{ $sucursal->sucursal }}
                                        </option>
                                    @endforeach
                                </x-form.select>

                            @endif
                        </div>



                        @if (auth()->user()->id_sucursal == 200)
                            <div class="col-12 col-md-6 mb-3">

                                <x-form.select label="Nivel" model="nivel" required>
                                    <option value=""></option>
                                </x-form.select>
                            </div>
                        @elseif (auth()->user()->id_sucursal == 201)
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.select label="Area" model="area" required>
                                    <option value=""></option>
                                </x-form.select>
                            </div>

                        @elseif (auth()->user()->id_sucursal == 111)
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select required onchange="getSubareas(this.value)" label="Area" model="area">
                                <option value="">Elige una area</option>
                            </x-form.select>
                        </div>


                        <div  class="col-12 col-md-6 mb-3"  id="seccionsubarea" >
               
                            <x-form.select onchange="getNivelTrbl(this.value)" label="Subarea" model="subarea"  >
                                <option value="">Elige una subarea</option>
                            </x-form.select>
                        </div>
                        
                        <div class="col-12 col-md-6 mb-3">

                            <x-form.select label="Nivel" model="nivel">
                                <option value="">Elige un nivel</option>
                            </x-form.select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">

                            <x-form.select required label=" Categoría" model="categoria">
                                <option value="">Elige una categoria..</option>
                            </x-form.select>
                        </div>
                        @endif

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Prioridad" model="prioridad" required>
                                <option value=""></option>
                                <option value="Alta">Alta</option>
                                <option value="Media">Media</option>
                                <option value="Baja">Baja</option>
                            </x-form.select>
                        </div>




                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Tipo ticket" model="tipo_ticket" required>
                                <option value=""></option>
                                <option value="Correctivo">Correctivo</option>
                                <option value="Preventivo">Preventivo</option>
                                <option value="Mejora continua">Mejora continua</option>
                            </x-form.select>
                        </div>



                        <div class="col-12 col-md-6 mb-3">
                            @if (auth()->user()->id_sucursal == 200)
                                <x-form.select label="Responsable" model="persona_realizo" required>
                                    <option value=""></option>
                                    @if (auth()->user()->id_usuario == 312)
                                        <option value="Juan Sauceda">Juan Sauceda</option>
                                        <option value="Harim Bustos">Harim Bustos</option>
                                        <option value="Juan de León">Juan de León</option>
                                        <option value="Jose Castillo">Jose Castillo</option>
                                    @endif
                                 
                                    @if (auth()->user()->id_usuario == 318 || auth()->user()->id_usuario == 445 )
                                    <option value="Jose Castillo">Jose Castillo</option>
                                    <option value="Mariana Vazquez">Mariana Vazquez</option>
                                    <option value="Cristina Herrera">Cristina Herrera</option>
                                    @endif
                                    @if (auth()->user()->id_usuario == 315  )
                                        <option value="Elias Quiñones">Elias Quiñones</option>
                                        <option value="Elias Quiñones">Ricardo Garza</option>
                                        <option value="Oscar Saucedo">Oscar Saucedo</option>
                                        <option value="Reynaldo García">Reynaldo García</option>
                                        <option value="Mariana Vazquez">Mariana Vazquez</option>
                                        <option value="Cristina Herrera">Cristina Herrera</option>
                                        <option value="Jose Castillo">Jose Castillo</option>
                                    @endif
                                    
                                    @if (auth()->user()->id_usuario == 314  )
                                    <option value="Elias Quiñones">Elias Quiñones</option>
                                    <option value="Elias Quiñones">Ricardo Garza</option>
                                    <option value="Oscar Saucedo">Oscar Saucedo</option>
                                    <option value="Reynaldo García">Reynaldo García</option>
                                    <option value="Mariana Vazquez">Mariana Vazquez</option>
                                    <option value="Cristina Herrera">Cristina Herrera</option>
                                    <option value="Jose Castillo">Jose Castillo</option>
                                    @endif


                                </x-form.select>
                            @elseif(auth()->user()->id_sucursal == 201)
                                <x-form.select label="Responsable" model="persona_realizo" required>
                                    <option value="">Elige responsable a este ticket...</option>
                                </x-form.select>

                                @else
                                <x-form.select label="Responsable" model="persona_realizo" required>
                                    <option value="">Elige responsable a este ticket...</option>
                                    <option value="Elias Quiñones">Ricardo Garza</option>
                                    <option value="Joaquin Sanchez">Joaquin Sanchez</option>
                                    <option value="Mantenimiento Trebol">Mantenimiento Trebol</option>
                                </x-form.select>

                            @endif

                        </div>



                        <div class="col-12 col-md-6 mb-3">
                            <x-form.textarea label="Trabajo a realizar" model="accion_a_realizar"
                                placeholder="Ingresa la acción a realizar" />
                        </div>



                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input autocomplete="false" required placeholder="Click aqui para ingresar fecha"
                                label="Fecha estimada" model="fecha_estimada" />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input type="datetime-local" autocomplete="false"
                                placeholder="Click aqui para ingresar fecha" label="Cita y hora" model="fecha_cita" />
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="Evidencia de falla 1 (opcional)" model="evidencia0"
                                accept=".jpg,.jpeg,.png" />
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="Evidencia de falla 2 (opcional)" model="evidencia1"
                                accept=".jpg,.jpeg,.png" />
                        </div>
                        <div class="col-12">
                            <hr>
                            <div class="text-right">
                                <a href="{{ route('web.dashboard.tickets.index') }}"
                                    class="btn btn-outline-danger cancelar">
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

    <link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />
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
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov',
                    'Dic'
                ],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['es']);
            $(function() {
                $("#fecha_estimada").datepicker();
            });
        });


        
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
        integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
 
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
        * Obtiene las subareas y las coloca en el input subareas
        **/
        let subareas = [];

        function getSubareas(id_area) {
        
            var elementoOculto = document.getElementById('seccionsubarea');
        $('#subarea').html(new Option('Elige una subarea', ''));

        Loader.show();
        axios.get(`{{ url('api/resources/subareas') }}/${id_sucursal_var}/${id_area}`)
        .then(async (response) => {
        if(response.data.length>0){
            elementoOculto.style.display = 'block';
        $.each(subareas = await response.data, (index, item) => {
        $('#subarea').append(new Option(item.subarea, item.id));
        });
        }else{
            elementoOculto.style.display = 'none';
        }
        }).catch((error) => {
        subareas = [];
        console.log(`getSubareas() - ${error}`);
        }).finally(async () => {
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
         * Obtiene las categorias y las coloca en el input categoria
         **/
         let nivel_trbl = [];

function getNivelTrbl(subarea) {
    $('#nivel').html(new Option('Elige un nivel', ''));

    Loader.show();
    axios.get(`{{ url('api/resources/tcs-nvl-trbl') }}/${subarea}`)
        .then(async (response) => {


            $.each(nivel_trbl = await response.data, (index, item) => {
                $('#nivel').append(new Option(item.nivel_descripcion,item.nivel_descripcion));
            });

        }).catch((error) => {
            nivel_trbl = [];
            console.log(`getNivelTrbl() - ${error}`);
        }).finally(async () => {
            Loader.hide();
        });
}





 
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stop
