@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')

    <h1>Ticket #{{ $data->id + 1 }}</h1>
@stop

@section('content')
    <div class="pb-2">
        <div class="card">

            <div class="card-body">
                <form action="{{ route('web.dashboard.ems.store') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="Loader.show()">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                           
                                <x-form.select label="Sucursal" model="sucursal"
                                    onchange="getAreas(this.value)" required>
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
                            <x-form.select label="Area" model="area" required>
                                <option value="">Elige una area</option>
                            </x-form.select>
                        </div>
                        

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Prioridad" model="prioridad" required>
                                <option value="">Elige una prioridad</option>
                                <option value="Critica">Critica</option>
                                <option value="Urgente">Urgente</option>
                                <option value="Media">Media</option>
                            </x-form.select>
                        </div>




                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Tipo ticket" model="tipo_ticket" required>
                                <option value="">Elige un un tipo de ticket</option>
                                <option value="Preventivo">Preventivo</option>
                                <option value="Correctivo">Correctivo</option>
                                <option value="Modificaciones">Modificaciones</option>
                                <option value="Rutinario">Rutinario</option>       
                            </x-form.select>
                        </div>



                        <div class="col-12 col-md-6 mb-3">
                           
                                    
                                   
                                <x-form.select label="Responsable" model="persona_realizo" required>
                                    <option value="">Elige responsable a este ticket...</option>
                                    @if(auth()->user()->id_empresa==40 && auth()->user()->tipo_cuenta =='cliente' )
                                    <option value="Giovanni de Jesus">Giovanni de Jesus</option>
                                    <option value="Jacqueline de Jesus">Jacqueline de Jesus</option>
                                    @elseif(auth()->user()->id_empresa==40 && auth()->user()->tipo_cuenta =='usuario')
                                    <option value="Leonel García">Leonel García</option>
                                    <option value="Salvador Valle">Salvador Valle</option>
                                    <option value="Horacio Garcia">Horacio Garcia</option>           
                                    <option value="Tecnico Ems">Tecnico Ems</option>                                
                                    @endif
                                </x-form.select>
                       

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
                        <hr>

<hr>
                        
<div class="contenedor">

    <div class="row">
        <div class="col-md-12">
             <canvas id="draw-canvas" width="620" height="360">
                 No tienes un buen navegador.
             </canvas>
         </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="button" class="button" id="draw-submitBtn" value="Firmar"></input>
            <input type="button" class="button" id="draw-clearBtn" value="Borrar Firma"></input>

                    <label>Color</label>
                    <input type="color" id="color">
                    <label>Tamaño Puntero</label>
                    <input type="range" id="puntero" min="1" default="1" max="5" width="10%">


        </div>

    </div>

    <br/>
    <div hidden class="row">
        <div class="col-md-12">
            <textarea name="firma" id="draw-dataUrl" class="form-control" rows="5">Para los que saben que es esto:</textarea>
        </div>
    </div>
    <br/>
    <div class="contenedor">
        <div class="col-md-12">
            <img id="draw-image" src="" alt="Tu Imagen aparecera Aqui!"/>
        </div>
    </div>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/efirma.css') }}">
@stop

@section('js')

<script src="{{ asset('js/firma.js') }}"></script>

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
        let id_sucursal_var;
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

    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stop
