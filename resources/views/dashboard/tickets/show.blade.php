@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Ver Ticket</h1>
@stop

@section('content')
    <div class="pb-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <x-form.input label="Folio" model="folio" :value="'#'.$ticket->id" disabled />
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <x-form.input label="Creación" model="creacion" :value="$ticket->created_at ?? 'Desconocido'" disabled />
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <x-form.input label="Actualización" model="actualizacion" :value="$ticket->updated_at ?? 'Ninguna'" disabled />
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Estado" model="estatus" :value="$ticket->estatus ?? '[No hay información]'" disabled />
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Prioridad" model="prioridad" :value="$ticket->prioridad ?? '[No hay información]'" disabled />
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Sucursal" model="sucursal" :value="$ticket->sucursal ?? 'No aplica'" disabled />
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Area" model="area" :value="$ticket->area ?? 'No aplica'" disabled />
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Subarea" model="subarea" :value="$ticket->subarea ?? 'No aplica'" disabled />
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Categoria" model="categoria" :value="$ticket->categoria ?? 'No aplica'" disabled />
                    </div>
                    @if (auth()->user()->id_empresa!=27)
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Subcategoria" model="subcategoria" :value="$ticket->subcategoria ?? 'No aplica'" disabled />
                    </div>
                    @else
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Equipo" model="inventario" :value="$ticket->inventario ?? 'Sin equipo'" disabled />
                    </div>
                    @endif
                    @if (auth()->user()->id_empresa==27 || auth()->user()->id_empresa==31)
                        <div class="col-12 col-md-6 mb-3">
                           <x-form.input label="Tipo ticket" model="tipo_ticket" :value="$ticket->tipo_ticket ?? 'Sin tipo'" disabled />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input type="text" label="Realizado por" model="persona_realizo" :value="$ticket->realizo ?? '[No hay información]'" disabled />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input type="text" label="Tiempo de ejecucion" model="tiempo_ejecucion" :value="$ticket->tiempo_ejecucion ?? '[No hay información]'" disabled />
                        </div>
                    @endif
                    @if (auth()->user()->id_empresa!=27 )
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Cuarto" model="cuarto" :value="$ticket->habitacion ?? '[No hay información]'" disabled />
                    </div>
                    @endif
                    @if (auth()->user()->id_empresa!=27)
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Acción a realizar" model="accion_a_realizar" :value="$ticket->accion ?? '[No hay información]'" disabled />
                    </div>
                    @endif
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.textarea label="Descripción" model="descripcion" disabled>{{ $ticket->ticket_descripcion ?? '[No hay información]' }}</x-form.textarea>
                    </div>
                    @if (auth()->user()->id_empresa!=27)
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.textarea label="Observaciones" model="observaciones" disabled>{{ $ticket->observaciones ?? '[No hay información]' }}</x-form.textarea>
                    </div>
                    @else
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.textarea label="Trabajo efectuado por ingenieria y mantenimiento" model="observaciones" disabled>{{ $ticket->observaciones ?? '[No hay
                            información]' }}</x-form.textarea>
                    </div>
                    @endif
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Costo estimado" model="costo_estimado" :value="$ticket->costo_estimado ?? '[No hay información]'" disabled />
                    </div>
                    @if (auth()->user()->id_empresa!=27)
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Fecha estimada" model="fecha_estimada" :value="$ticket->fecha_estimada ?? '[No hay información]'" disabled />
                    </div>
                    @else
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Fecha de entrega a mantenimiento" model="fecha_estimada"
                            :value="$ticket->fecha_estimada ?? '[No hay información]'" disabled />
                    </div>
                    @endif
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Costo real" model="costo_real" :value="$ticket->costo ?? '[No hay información]'" disabled />
                    </div>
                    @if (auth()->user()->id_empresa!=27)
                    <div class="col-12 col-md-6 mb-3">
                        <x-form.input label="Fecha real" model="fecha_real" :value="$ticket->fecha ?? '[No hay información]'" disabled />
                    </div>
                    @else
                    <div class="col-12 col-md-12 mb-3">
                        <x-form.input label="Fecha de entrega a usuario" model="fecha_real" :value="$ticket->fecha ?? '[No hay información]'" disabled />
                    </div>
                    @endif

                    @php
                        $carpeta=auth()->user()->app->carpeta;
                    @endphp




                    <div class="col-12 col-md-6 mb-3">
                        @if ($ticket->evidenciaInicial != null)
                            <div>
                                <label class="mb-2">Evidencia de falla:</label>
                       <img class="img-fluid rounded" src="{{"https://fotostickets.sumapp.cloud/$carpeta/".$ticket->evidenciaInicial}}">

                            </div>
                        @elseif($arrayPHP != null)
                            <div>
                                <label class="mb-2">Evidencias de falla:</label>
                                <br>
                                <div id="lightgallery">


                                    @foreach ($arrayPHP as $arrayPHP2)


                                    <a href="{{"https://fotostickets.sumapp.cloud/$carpeta/".$arrayPHP2}}">
                                        <img src="{{"https://fotostickets.sumapp.cloud/$carpeta/".$arrayPHP2}}" />
                                    </a>
                                @endforeach


                                </div>
                            </div>
                        @else
                        <label class="mb-2">Evidencias de falla:</label>
                        <div class="font-italic">[No hay evidencia]</div>
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
                                        <a href="{{"https://fotostickets.sumapp.cloud/$carpeta/".$arrayPHP2}}">
                                            <img src="{{"https://fotostickets.sumapp.cloud/$carpeta/".$arrayPHP2}}" />
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                        <label class="mb-2">Evidencias del proceso:</label>
                        <div class="font-italic">[No hay evidencia]</div>
                        @endif
                    </div>










                @endif



                                <div class="col-12 col-md-6 mb-3">
                    @if ($ticket->evidenciaFinal != null)
                        <div>
                            <label class="mb-2">Evidencia de solución:</label>

                            <img class="img-fluid rounded" src="{{"https://fotostickets.sumapp.cloud/$carpeta/".$ticket->evidenciaFinal}}">
                        </div>
                    @elseif($array_final != null)
                        <div>
                            <label class="mb-2">Evidencias de solución:</label>
                            <br>
                            <div id="lightgallery3">
                                @foreach ($array_final as $arrayPHP2)
                                    <a href="{{"https://fotostickets.sumapp.cloud/$carpeta/".$arrayPHP2}}">
                                        <img src="{{"https://fotostickets.sumapp.cloud/$carpeta/".$arrayPHP2}}" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                    <label class="mb-2">Evidencias de solución:</label>
                    <div class="font-italic">[No hay evidencia]</div>
                    @endif
                </div>





                    <div class="col-12">
                        <hr>
                        <div class="text-left">
                            <a class="btn btn-info" href="{{ route('web.dashboard.tickets.index') }}">
                                <i class="fas fa-angle-left"></i> Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
<link type="text/css" rel="stylesheet" href="{{ asset('css/lightgallery.css') }}" />
    <style>
        #lightgallery3 {
            display: flex;
        }

        #lightgallery2 {
            display: flex;
        }

        #lightgallery {
            display: flex;
        }

        a {
            display: inline-block;
        }

        a img {
            width: 100%;
        }


        .lg-actions .lg-prev:after {

            content: '↤' !important;
        }

        .lg-actions .lg-next:before {

            content: '↦' !important;
        }

        .lg-toolbar .lg-close:after {

            content: '✕' !important;
        }

        .lg-toolbar .lg-download:after {

            content: '⇊' !important;
        }
    </style>
@stop

@section('js')
<script src="{{ asset('js/lightgallery.min.js') }}"></script>
<script type="text/javascript">
    lightGallery(document.getElementById('lightgallery'));
    lightGallery(document.getElementById('lightgallery2'));
    lightGallery(document.getElementById('lightgallery3'));
</script>

@stop
