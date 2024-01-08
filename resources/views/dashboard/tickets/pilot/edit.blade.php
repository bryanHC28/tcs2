@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ trans('messages.edit') }}</h1>
@stop


@section('content')
    <div class="pb-2">
        <div class="card">
            <div class="card-body">
               
                <form action="{{ route('web.dashboard.tickets.update', ['ticket' => $ticket->id]) }}" method="POST"
                    enctype="multipart/form-data" onsubmit="Loader.show()">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <x-form.input label="{{ trans('messages.folio') }}" model="folio" :value="'#' . $ticket->id" readonly />
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <x-form.input label="{{ trans('messages.creacion') }}" model="creacion" :value="$ticket->created_at ?? 'Desconocido'" readonly />
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <x-form.input label="{{ trans('messages.actualizacion') }}" model="actualizacion" :value="$ticket->updated_at ?? 'Ninguna'" readonly />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select   label="{{ trans('messages.estado') }}" model="estatus" required>
                                <option value="">  {{ trans('messages.select_edo') }}</option>
                                    <option {{ (old('estatus') != 'Abierto' and $ticket->estatus != 'Abierto') ?: 'selected' }}>
                                        {{ trans('messages.abierto') }}</option>                    
                                    <option
                                        {{ (old('estatus') != 'En proceso' and $ticket->estatus != 'En proceso') ?: 'selected' }}>
                                        {{ trans('messages.tickets_process') }}</option>                    
                                    <option
                                        {{ (old('estatus') != 'Cerrado' and $ticket->estatus != 'Cerrado') ?: 'selected' }}>
                                        {{ trans('messages.cerrado') }}</option>                                
                                    <option
                                    {{ (old('estatus') != 'Cancelado' and $ticket->estatus != 'Cancelado') ?: 'selected' }}>
                                    {{ trans('messages.cancelado') }}</option><option
                                        {{ (old('estatus') != 'Cierre final' and $ticket->estatus != 'Cierre final') ?: 'selected' }}>
                                        {{ trans('messages.tickets_close_final') }}</option>                        
                            </x-form.select>
                        </div>


                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="{{ trans('messages.prioridad') }}" model="prioridad" required>
                                <option value="">{{ trans('messages.elige_prioridad') }}</option>
                                <option {{ (old('prioridad') != 'Baja' and $ticket->prioridad != 'Baja') ?: 'selected' }}>
                                    {{ trans('messages.baja') }}</option>
                                <option {{ (old('prioridad') != 'Media' and $ticket->prioridad != 'Media') ?: 'selected' }}>
                                    {{ trans('messages.media') }}</option>
                                <option {{ (old('prioridad') != 'Alta' and $ticket->prioridad != 'Alta') ?: 'selected' }}>
                                    {{ trans('messages.alta') }}</option>
                            </x-form.select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input label="{{ trans('messages.branch') }}" model="sucursal" :value="$ticket->sucursal ?? 'No aplica'" readonly />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input label="Area" model="area" :value="$ticket->area ?? 'No aplica'" readonly />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input label="{{ trans('messages.categoria') }}" model="categoria" :value="$ticket->categoria ?? 'No aplica'" readonly />
                        </div>


                                <div class="col-12 col-md-6 mb-3 ui-widget">
                                    <x-form.input label="{{ trans('messages.equipo') }}" model="inventario" id="inventario" :value="$ticket->inventario" />

                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <x-form.select label="{{ trans('messages.tipo_ticket') }}" model="tipo_ticket" required>
                                        <option value="">{{ trans('messages.elige_tipo_ticket') }}</option>
                                        <option
                                            {{ (old('tipo_ticket') != 'Preventivo' and $ticket->tipo_ticket != 'Preventivo') ?: 'selected' }}>
                                            {{ trans('messages.preventivo') }}</option>
                                        <option
                                            {{ (old('tipo_ticket') != 'Correctivo' and $ticket->tipo_ticket != 'Correctivo') ?: 'selected' }}>
                                            {{ trans('messages.correctivo') }}</option>
                                        <option
                                            {{ (old('tipo_ticket') != 'Modificaciones' and $ticket->tipo_ticket != 'Modificaciones') ?: 'selected' }}>
                                            {{ trans('messages.modificaciones') }}</option>
                                        <option
                                            {{ (old('tipo_ticket') != 'Rutinario' and $ticket->tipo_ticket != 'Rutinario') ?: 'selected' }}>
                                            {{ trans('messages.rutinario') }}</option>

                                    </x-form.select>
                                </div>

                        <div id="desc" class="col-12 col-md-6 mb-3">
                            <x-form.textarea label="{{ trans('messages.descripcion') }}" model="descripcion" placeholder="Ingresa una descripción">
                                {{ $ticket->ticket_descripcion }}</x-form.textarea>
                        </div>
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.textarea label="{{ trans('messages.trabajo_efectuado') }}"
                                    model="observaciones" placeholder="{{ trans('messages.ingrese') }}">
                                    {{ $ticket->observaciones }}</x-form.textarea>
                            </div>
                        
                        <div id="Costo estimado" class="col-12 col-md-6 mb-3">
                            <x-form.input type="number" label="{{ trans('messages.costo') }}" model="costo_estimado"
                                placeholder="{{ trans('messages.ingresa_costo') }}" :value="$ticket->costo_estimado" />
                        </div>



                                <div class="col-12 col-md-6 mb-3">
                                    <x-form.input label="{{ trans('messages.fecha_entrega') }}" model="fecha_estimada"
                                        :value="$ticket->fecha_estimada" />
                                </div>

                                <div class="col-12 col-md-6 mb-3">
                                    <x-form.input type="number" label="{{ trans('messages.real') }}" model="costo_real"
                                        placeholder="{{ trans('messages.ingresa_costo_real') }}" :value="$ticket->costo" />
                                </div>
                                    <div class="col-12 col-md-12 mb-3">
                                        <x-form.input label="{{ trans('messages.fecha_usuario') }}" model="fecha_real"
                                            :value="$ticket->fecha" />
                                    </div>



 

                        @if (auth()->user()->rol_tickets == 'Administrador')
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.textarea label="{{ trans('messages.realizado') }}" model="persona_realizo"
                                    placeholder="{{ trans('messages.ingresa_nombre') }}" required>{{ $ticket->realizo }}</x-form.textarea>
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input type="text" label="{{ trans('messages.tiempo') }}" model="tiempo_ejecucion"
                                    :value="$ticket->tiempo_ejecucion" />
                            </div>
                        @endif
                        @php
                            $carpeta = auth()->user()->app->carpeta;
                        @endphp



                        <div class="col-12 col-md-6 mb-3">
                            @if ($ticket->evidenciaInicial != null)
                                <div>
                                    <label class="mb-2">{{ trans('messages.ef') }}:</label>
                                    <img class="img-fluid rounded"
                                        src="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $ticket->evidenciaInicial }}">

                                </div>
                            @elseif($arrayPHP != null)
                                <div>
                                    <label class="mb-2">{{ trans('messages.ef') }}:</label>
                                    <br>
                                    <div id="lightgallery">
                                        @foreach ($arrayPHP as $arrayPHP2)
                                            <a href="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $arrayPHP2 }}">
                                                <img
                                                    src="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $arrayPHP2 }}" />
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <x-form.inputfile capture="user" label="Evidencia de falla 1 (opcional)"
                                    model="evidencia0" accept=".jpg,.jpeg,.png" />

                                <x-form.inputfile capture="user" label="Evidencia de falla 2 (opcional)"
                                    model="evidencia1" accept=".jpg,.jpeg,.png" />
                            @endif
                        </div>



 

                        <div class="col-12 col-md-6 mb-3">
                            @if ($ticket->evidenciaFinal != null)
                                <div>
                                    <label class="mb-2">{{ trans('messages.es') }}:</label>

                                    <img class="img-fluid rounded"
                                        src="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $ticket->evidenciaFinal }}">
                                </div>
                            @elseif($array_final != null)
                                <div>
                                    <label class="mb-2">{{ trans('messages.es') }}:</label>
                                    <br>
                                    <div id="lightgallery3">
                                        @foreach ($array_final as $arrayPHP2)
                                            <a href="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $arrayPHP2 }}">
                                                <img
                                                    src="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $arrayPHP2 }}" />
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <x-form.inputfile capture="user" label="{{ trans('messages.es1') }}"
                                    model="evidencia_final0" accept=".jpg,.jpeg,.png" />
                                <x-form.inputfile capture="user" label="{{ trans('messages.es2') }}"
                                    model="evidencia_final1" accept=".jpg,.jpeg,.png" />
                            @endif
                        </div>




                        <div class="col-12">
                            <hr>
                            <div class="text-right">
                                <a href="{{ route('web.dashboard.tickets.index') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-times"></i> {{ trans('messages.cancelar') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i>  {{ trans('messages.listo') }}
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
    <link type="text/css" rel="stylesheet" href="{{ asset('css/lightgallery.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/estilos.css') }}" />

@stop

@section('js')


    <script src="{{ asset('js/lightgallery.min.js') }}"></script>
    <script type="text/javascript">
        lightGallery(document.getElementById('lightgallery'));
        lightGallery(document.getElementById('lightgallery2'));
        lightGallery(document.getElementById('lightgallery3'));
    </script>
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
            $(function() {
                $('#fecha_real').datepicker({
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
            $(function() {
                $("#fecha_real").datepicker();
            });
        });


        function tutorial() {
            introJs().setOptions({
                nextLabel: 'Siguiente',
                prevLabel: 'Anterior',
                doneLabel: 'Terminar',
                skipLabel: 'Omitir',
                steps: [{
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
        integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let id_sucursal_var;

        /**
         * Obtiene las areas y las coloca en el input area
         **/
        let areas = [];

        function getAreas(id_sucursal) {
            id_sucursal_var = id_sucursal;
            $('#area').html(new Option('Elige una area', ''));

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
                    $.each(subcategorias = await response.data, (index, item) => {
                        $('#subcategoria').append(new Option(item.subcategoria, item.id));
                    });
                }).catch((error) => {
                    subcategorias = [];
                    console.log(`getSubcategorias() - ${error}`);
                }).finally(async () => {
                    Loader.hide();
                });
        }
    </script>


@stop
