@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')

    <h1>Ticket #{{ $data->id + 1 }}</h1>
@stop

@section('content')
    <div class="pb-2">
        <div class="card">

            <div class="card-body">
                <form id="miFormulario" action="{{ route('web.dashboard.workplay.store') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="Loader.show()">
                    @csrf
                    <div class="row">

                        
                        <div class="col-12 col-md-6 mb-3">

                            @if(auth()->user()->id_usuario == 496 || auth()->user()->id_usuario == 497 || auth()->user()->id_usuario == 433 || auth()->user()->id_usuario == 495)
                            <x-form.select label="Plaza comercial" model="sucursal"  required>
                                <option value="">Elige una sucursal</option>
                                @foreach ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id_sucursal }}"
                                        {{ old('sucursal') != $sucursal->id_sucursal ?: 'selected' }}>
                                        {{ $sucursal->sucursal }}
                                    </option>
                                @endforeach
                            </x-form.select>

                            @else

                            <label >Sucursal:</label>
                            <select class="form-control" name="sucursal" id="miSelect">
                                <option value="">Seleccione...</option>
                                <option selected value="{{ auth()->user()->id_sucursal}}">{{ auth()->user()->sucursal->sucursal }}</option> 
                              </select>
                          @endif

                        </div>

                       

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select onchange="getCategorias(this.value)" label="Tipo" model="area" required>
                                <option value="">Elige una area</option>
                            </x-form.select>
                        </div>
                        <div id="tcs_lsm" class="col-12 col-md-6 mb-3" style="display:none">


                          

                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Categoría ticket" model="categoria" required>
                                <option value="">Elige una categoría</option>
                            </x-form.select>
                        </div>
                        <div id="fecha_lsm" class="col-12 col-md-6 mb-3"  style="display:none">
                            


                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.textarea label="Descripción" model="ticket_descripcion"
                                placeholder="Ingresa la acción a realizar" required />
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile required capture="user" label="Evidencia de falla 1" model="evidencia0"
                                accept=".jpg,.jpeg,.png" />
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="Evidencia de falla 2 (opcional)" model="evidencia1"
                                accept=".jpg,.jpeg,.png" />
                        </div>
                        
                      
                        <hr>
                       
                        <div class="col-12">
                            <hr>
                            <div class="text-right">
                                <a href="{{ route('web.dashboard.tickets.index') }}"
                                    class="btn btn-outline-danger cancelar">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button id="enviarBoton" type="submit" class="btn btn-primary listo">
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
    <style>#miSelect {
        opacity: 0.7;
        background-color: #eee;
      }</style>
   
@stop

@section('js')

    <script>
        $(document).ready(function() {
             
   
            $(function() {
                $('#fecha').datepicker({
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
                $("#fecha").datepicker();
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
        integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const archivoInput = document.getElementById('evidencia0');
        const enviarBoton = document.getElementById('enviarBoton');
        const mensajeError = document.getElementById('mensajeError');

        enviarBoton.addEventListener('click', function() {
            if (archivoInput.files.length === 0) {
                mensajeError.textContent = 'Este campo es requerido. Por favor adjunte una evidencia';
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Por favor adjunte una evidencia"
                });
            } else {
                mensajeError.textContent = ''; // Borra el mensaje de error si se ha seleccionado un archivo
                // Aquí puedes realizar la acción de envío si el archivo está seleccionado
            }
        });
    </script>
    <script>
 

        let areas = [];

            console.log("areas");
            $('#area').html(new Option('Elige una opción...', ''));

            Loader.show();
            axios.get(`{{ url('api/resources/areas_lsm') }}`)
                .then(async (response) => {
                    $.each(areas = await response.data, (index, item) => {
                        $('#area').append(new Option(item.area_descripcion, item.id));
                    });
                }).catch((error) => {
                    areas = [];
                    console.log(`${error}`);
                }).finally(() => {
                    Loader.hide();
                });
     

    
     



        /**
         * Obtiene las areas y las coloca en el input area
         **/
        let niveles = [];

        function getCategorias(id_area) {
            var miDiv = document.getElementById("tcs_lsm");
            var fecha_lsm = document.getElementById("fecha_lsm");
            console.log("aqui" + id_area);

            if (id_area == 142 || id_area == 137 || id_area == 144 || id_area == 146 || id_area == 143) {
                $('#tcs_lsm').css('display', 'none');
                $('#fecha_lsm').css('display', 'none');
                miDiv.innerHTML = "";
                fecha_lsm.innerHTML = "";
                $('#categoria').html(new Option('Elige una opción...', ''));
                Loader.show();
                axios.get(`{{ url('api/resources/categorias_lsm') }}/${id_area}`)
                .then(async (response) => {
                    $.each(niveles = await response.data, (index, item) => {
                        $('#categoria').append(new Option(item.categoria_descripcion, item.id));
                    });
                }).catch((error) => {
                    niveles = [];
                    console.log(`getCategorias() - ${error}`);
                }).finally(() => {
                    Loader.hide();
                });
            }else{
                 

            // Contenido que deseas agregar
            var contenidoHTML = "<label>No. Ticket CPS: <span class='text-danger'>*</span></label><input class='form-control' required placeholder='Ingrese el fiolio del ticket. EJ: (TC230315A0046)' type='text' id='ticket_sumapp' name='ticket_sumapp' maxlength='13'>";
            var contenidoFECHA  = "<label> Fecha alta CPS <span class='text-danger'>*</span></label><input class='form-control' required placeholder='Fecha de alta en sistema SAMSUNG' type='date' id='fecha' name='fecha'  > ";

            // Llena el div con el contenido
            miDiv.innerHTML = contenidoHTML;
            fecha_lsm.innerHTML = contenidoFECHA;
            $('#tcs_lsm').css('display', 'block');
            $('#fecha_lsm').css('display', 'block');
            $('#categoria').html(new Option('Elige una opción...', ''));

            Loader.show();
            axios.get(`{{ url('api/resources/categorias_lsm') }}/${id_area}`)
                .then(async (response) => {
                    $.each(niveles = await response.data, (index, item) => {
                        $('#categoria').append(new Option(item.categoria_descripcion, item.id));
                    });
                }).catch((error) => {
                    niveles = [];
                    console.log(`getCategorias() - ${error}`);
                }).finally(() => {
                    Loader.hide();
                });
        }
    }

    $('#miFormulario').submit(function (event) {
            var longitudTexto = $('#ticket_sumapp').val().length;

            if (longitudTexto !== 13) {
                alert('Folio CPS invalido. Verifica que tenga 13 caracteres.');
                event.preventDefault(); // Evita que el formulario se envíe
                Loader.hide();
            }
        });
    </script>

    <script>
 
        //Inventario
        $(function() {
            var availableTags = @JSON($lsm);
            $("#ticket_descripcion").autocomplete({
                source: availableTags
            });
        });

        
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
            // Deshabilitar la edición del select
document.getElementById("miSelect").addEventListener("mousedown", function(e) {
  e.preventDefault();
  this.blur();
});

document.getElementById("miSelect").addEventListener("keydown", function(e) {
  e.preventDefault();
});
    </script>
@stop
