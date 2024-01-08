@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Ticket</h1>
@stop


@section('content')
    <div class="pb-2">
        <div class="card">
            <div class="card-body">
                 

                <form action="{{ route('web.dashboard.accor.update', $ticket->id) }}" method="POST"
                    enctype="multipart/form-data" onsubmit="Loader.show()">
                    @csrf @method('PUT')
                    <div class="row">




                        <div class="col-12 col-md-4 mb-3">
                            <x-form.input label="Folio" model="folio" :value="'#' . $ticket->id" readonly />
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <x-form.input label="Creación" model="creacion" :value="$ticket->created_at ?? 'Desconocido'" readonly />
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <x-form.input label="Actualización" model="actualizacion" :value="$ticket->updated_at ?? 'Ninguna'" readonly />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select   label="Estado" model="estatus" required>
                                <option value="">Elige un estado</option>
                                <option {{ (old('estatus') != 'Abierto' and $ticket->estatus != 'Abierto') ?: 'selected' }}>
                                    Abierto</option>
                                    <option
                                        {{ (old('estatus') != 'En proceso' and $ticket->estatus != 'En proceso') ?: 'selected' }}>
                                        En proceso</option>                                                 
                                    <option
                                        {{ (old('estatus') != 'Cerrado' and $ticket->estatus != 'Cerrado') ?: 'selected' }}>
                                        Cerrado</option>
                                <option
                                    {{ (old('estatus') != 'Cancelado' and $ticket->estatus != 'Cancelado') ?: 'selected' }}>
                                    Cancelado</option>
                                 
                                    <option
                                    {{ (old('estatus') != 'Validado' and $ticket->estatus != 'Validado') ?: 'selected' }}>
                                    Validado</option>
                                
                            </x-form.select>
                        </div>


                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Prioridad" model="prioridad" required>
                                <option value="">Elige una prioridad</option>
                                <option {{ (old('prioridad') != 'Baja' and $ticket->prioridad != 'Baja') ?: 'selected' }}>
                                    Baja</option>
                                <option {{ (old('prioridad') != 'Media' and $ticket->prioridad != 'Media') ?: 'selected' }}>
                                    Media</option>
                                <option {{ (old('prioridad') != 'Alta' and $ticket->prioridad != 'Alta') ?: 'selected' }}>
                                    Alta</option>
                            </x-form.select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input label="Sucursal" model="sucursal" :value="$ticket->sucursal ?? 'No aplica'" readonly />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input label="Area" model="area" :value="$ticket->area ?? 'No aplica'" readonly />
                        </div>
                       
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input label="Categoria" model="categoria" :value="$ticket->categoria ?? 'No aplica'" readonly />
                        </div>

                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input label="Cuarto" model="cuarto" placeholder="Ingresa el cuarto" :value="$ticket->habitacion" />
                            </div>
                         
                     
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input label="Acción a realizar" model="accion_a_realizar"
                                    placeholder="Ingresa la acción a realizar" :value="$ticket->accion" />
                            </div>
                    
                        <div id="desc" class="col-12 col-md-6 mb-3">
                            <x-form.textarea label="Descripción" model="descripcion" placeholder="Ingresa una descripción">
                                {{ $ticket->ticket_descripcion }}</x-form.textarea>
                        </div>
                       
                            <div id="obs" class="col-12 col-md-6 mb-3">
                                <x-form.textarea label="Observaciones" model="observaciones"
                                    placeholder="Ingresa algunas observaciones">{{ $ticket->observaciones }}
                                </x-form.textarea>
                            </div>
                       
                        @php
                            $carpeta = auth()->user()->app->carpeta;
                        @endphp



                        <div class="col-12 col-md-6 mb-3">
                            @if ($ticket->evidenciaInicial != null)
                                <div>
                                    <label class="mb-2">Evidencia de falla:</label>
                                    <img class="img-fluid rounded"
                                        src="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $ticket->evidenciaInicial }}">

                                </div>
                            @elseif($arrayPHP != null)
                                <div>
                                    <label class="mb-2">Evidencias de falla:</label>
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




                        @if (auth()->user()->id_empresa == 33)





                            <div class="col-12 col-md-6 mb-3">


                                @if ($array_proceso != null)

                                    <div>
                                        <label class="mb-2">Evidencias del proceso:</label>
                                        <br>
                                        <div id="lightgallery2">
                                            @foreach ($array_proceso as $arrayPHP2)
                                                <a href="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $arrayPHP2 }}">
                                                    <img
                                                        src="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $arrayPHP2 }}" />
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <x-form.inputfile capture="user" label="Evidencia del proceso 1 (opcional)"
                                        model="evidencia_proceso0" accept=".jpg,.jpeg,.png" />
                                    <x-form.inputfile capture="user" label="Evidencia del proceso 2 (opcional)"
                                        model="evidencia_proceso1" accept=".jpg,.jpeg,.png" />
                                @endif
                            </div>











                        @endif





















                        <div class="col-12 col-md-6 mb-3">
                            @if ($ticket->evidenciaFinal != null)
                                <div>
                                    <label class="mb-2">Evidencia de solución:</label>

                                    <img class="img-fluid rounded"
                                        src="{{ "https://fotostickets.sumapp.cloud/$carpeta/" . $ticket->evidenciaFinal }}">
                                </div>
                            @elseif($array_final != null)
                                <div>
                                    <label class="mb-2">Evidencias de solución:</label>
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
                                <x-form.inputfile capture="user" label="Evidencia de solución 1 (opcional)"
                                    model="evidencia_final0" accept=".jpg,.jpeg,.png" />
                                <x-form.inputfile capture="user" label="Evidencia de solución 2 (opcional)"
                                    model="evidencia_final1" accept=".jpg,.jpeg,.png" />
                            @endif
                        </div>




                        <div class="col-12">
                            <hr>
                            <div class="text-right">
                                <a href="{{ route('web.dashboard.tickets.index') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
        integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@stop
