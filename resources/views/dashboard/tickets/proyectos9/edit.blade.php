@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Ticket</h1>
@stop


@section('content')
    <div class="pb-2">
        <div class="card">
            <div class="card-body">
              
                <div class="col-12 col-md-12 mb-3">
                    <button class="button button5" onclick="myFunction(1)">Descripción</button>
                    <button class="button button5" onclick="myFunction(2)">Observaciones</button>
                    <button class="button button5" onclick="myFunction(3)">Costo estimado</button>
                    <button class="button button5" onclick="myFunction(4)">Tiempo de ejecución</button>
                </div>
              
                <form action="{{ route('web.dashboard.tcs_proyectos9.update', $ticket->id) }}" method="POST"
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
                                        {{ (old('estatus') != 'Ejecutado' and $ticket->estatus != 'Ejecutado') ?: 'selected' }}>
                                        Ejecutado</option>

                                        <option hidden
                                        {{ (old('estatus') != 'Cerrado' and $ticket->estatus != 'Cerrado') ?: 'selected' }}>
                                        Cerrado</option>
                                <option
                                    {{ (old('estatus') != 'Cancelado' and $ticket->estatus != 'Cancelado') ?: 'selected' }}>
                                    Cancelado</option>
                            
                                @if (
                                    (auth()->user()->rol_tickets == 'gerente' && auth()->user()->id_empresa == 33) ||
                                        (auth()->user()->rol_tickets == 'Administrador' && auth()->user()->id_empresa == 33))
                                    <option
                                        {{ (old('estatus') != 'Cerrado' and $ticket->estatus != 'Cerrado') ?: 'selected' }}>
                                        Cerrado</option>
                                @endif

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

                        
                        @php
                            if ((auth()->user()->id_sucursal == 200 )) {
                                $hidden = '';
                            } else {
                                $hidden = 'hidden';
                            }
                        @endphp



                        <div {{ $hidden }} class="col-12 col-md-6 mb-3">
                            <x-form.input label="Area" model="area" :value="$ticket->area ?? 'No aplica'" readonly />
                        </div>
                        
                 


                        @if (auth()->user()->id_sucursal == 200)
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.select label="Nivel" model="nivel" required>
                                    <option value="">Elige el nivel</option>
                                    <option {{ (old('tipo_ticket') != 'N1' and $ticket->nivel != 'N1') ?: 'selected' }}>
                                        N1</option>
                                    <option {{ (old('tipo_ticket') != 'N2' and $ticket->nivel != 'N2') ?: 'selected' }}>
                                        N2</option>
                                    <option {{ (old('tipo_ticket') != 'N3' and $ticket->nivel != 'N3') ?: 'selected' }}>
                                        N3</option>
                                    <option {{ (old('tipo_ticket') != 'N4' and $ticket->nivel != 'N4') ?: 'selected' }}>
                                        N4</option>
                                    <option {{ (old('tipo_ticket') != 'N5' and $ticket->nivel != 'N5') ?: 'selected' }}>
                                        N5</option>
                                    <option {{ (old('tipo_ticket') != 'N6' and $ticket->nivel != 'N6') ?: 'selected' }}>
                                        N6</option>
                                    <option {{ (old('tipo_ticket') != 'N7' and $ticket->nivel != 'N7') ?: 'selected' }}>
                                        N7</option>
                                    <option {{ (old('tipo_ticket') != 'N8' and $ticket->nivel != 'N8') ?: 'selected' }}>
                                        N8</option>

                                    <option
                                        {{ (old('tipo_ticket') != 'E1-A' and $ticket->nivel != 'E1-A') ?: 'selected' }}>
                                        E1-A</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'E1-B' and $ticket->nivel != 'E1-B') ?: 'selected' }}>
                                        E1-B</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'E2-A' and $ticket->nivel != 'E2-A') ?: 'selected' }}>
                                        E2-A</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'E2-B' and $ticket->nivel != 'E2-B') ?: 'selected' }}>
                                        E2-B</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'E3-A' and $ticket->nivel != 'E3-A') ?: 'selected' }}>
                                        E3-A</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'E3-B' and $ticket->nivel != 'E3-B') ?: 'selected' }}>
                                        E3-B</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'E4-A' and $ticket->nivel != 'E4-A') ?: 'selected' }}>
                                        E4-A</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'E4-B' and $ticket->nivel != 'E4-B') ?: 'selected' }}>
                                        E4-B</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'Planta Baja' and $ticket->nivel != 'Planta Baja') ?: 'selected' }}>
                                        Planta Baja</option>


                                    <option {{ (old('tipo_ticket') != 'P8' and $ticket->nivel != 'P8') ?: 'selected' }}>
                                        P8</option>
                                    <option {{ (old('tipo_ticket') != 'P9' and $ticket->nivel != 'P9') ?: 'selected' }}>
                                        P9</option>
                                    <option {{ (old('tipo_ticket') != 'P10' and $ticket->nivel != 'P10') ?: 'selected' }}>
                                        P10</option>
                                    <option {{ (old('tipo_ticket') != 'P11' and $ticket->nivel != 'P11') ?: 'selected' }}>
                                        P11</option>
                                    <option {{ (old('tipo_ticket') != 'P12' and $ticket->nivel != 'P12') ?: 'selected' }}>
                                        P12</option>
                                    <option {{ (old('tipo_ticket') != 'P14' and $ticket->nivel != 'P14') ?: 'selected' }}>
                                        P14</option>
                                    <option {{ (old('tipo_ticket') != 'P15' and $ticket->nivel != 'P15') ?: 'selected' }}>
                                        P15</option>
                                    <option {{ (old('tipo_ticket') != 'P16' and $ticket->nivel != 'P16') ?: 'selected' }}>
                                        P16</option>


                                    <option
                                        {{ (old('tipo_ticket') != 'Terraza jardín' and $ticket->nivel != 'Terraza jardín') ?: 'selected' }}>
                                        Terraza jardín</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'Gimnasio' and $ticket->nivel != 'Gimnasio') ?: 'selected' }}>
                                        Gimnasio</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'Area infantil' and $ticket->nivel != 'Area infantil') ?: 'selected' }}>
                                        Area infantil</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'Terraza asador Cuauhtémoc' and $ticket->nivel != 'Terraza asador Cuauhtémoc') ?: 'selected' }}>
                                        Terraza asador Cuauhtémoc</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'Terraza asador Pino Suárez' and $ticket->nivel != 'Terraza asador Pino Suárez') ?: 'selected' }}>
                                        Terraza asador Pino Suárez</option>

                                </x-form.select>


                            </div>
                        @elseif (auth()->user()->id_sucursal == 201)
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.select label="Area" model="nivel" required>
                                    <option value="">Elige el nivel</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'PASILLOS' and $ticket->nivel != 'PASILLOS') ?: 'selected' }}>
                                        PASILLOS</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'ESTACIONAMIENTO' and $ticket->nivel != 'ESTACIONAMIENTO') ?: 'selected' }}>
                                        ESTACIONAMIENTO</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'MODULO 1' and $ticket->nivel != 'MODULO 1') ?: 'selected' }}>
                                        MODULO 1</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'MODULO 2' and $ticket->nivel != 'MODULO 2') ?: 'selected' }}>
                                        MODULO 2</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'MODULO 3' and $ticket->nivel != 'MODULO 3') ?: 'selected' }}>
                                        MODULO 3</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'MODULO 4' and $ticket->nivel != 'MODULO 4') ?: 'selected' }}>
                                        MODULO 4</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'MODULO 5' and $ticket->nivel != 'MODULO 5') ?: 'selected' }}>
                                        MODULO 5</option>
                                    <option
                                        {{ (old('tipo_ticket') != 'MODULO 6' and $ticket->nivel != 'MODULO 6') ?: 'selected' }}>
                                        MODULO 6</option>


                                </x-form.select>


                            </div>

                            @elseif (auth()->user()->id_sucursal == 111)
                            <div class="col-12 col-md-6 mb-3">

                                <x-form.input label="Area" model="area" :value="$ticket->area ?? 'No aplica'" readonly />
                            </div>
                            <div class="col-12 col-md-6 mb-3">

                                <x-form.input label="Subarea" model="subarea" :value="$ticket->subarea ?? 'No aplica'" readonly />
                            </div>
                            <div class="col-12 col-md-6 mb-3">

                                <x-form.input label="Categoria" model="categoria" :value="$ticket->categoria ?? 'No aplica'" readonly />
                            </div>
                            
                        @endif

  
                                <div class="col-12 col-md-6 mb-3">
                                    <x-form.select label="Tipo ticket" model="tipo_ticket" required>
                                        <option value="">Elige tipo de ticket</option>
                                        <option
                                            {{ (old('tipo_ticket') != 'Preventivo' and $ticket->tipo_ticket != 'Preventivo') ?: 'selected' }}>
                                            Preventivo</option>
                                        <option
                                            {{ (old('tipo_ticket') != 'Correctivo' and $ticket->tipo_ticket != 'Correctivo') ?: 'selected' }}>
                                            Correctivo</option>                                
                                        <option
                                            {{ (old('tipo_ticket') != 'Mejora continua' and $ticket->tipo_ticket != 'Mejora continua') ?: 'selected' }}>
                                            Mejora continua</option>
                                    </x-form.select>


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
                      
                             
                        <div id="Costo estimado" class="col-12 col-md-6 mb-3">
                            <x-form.input type="number" label="Costo estimado" model="costo_estimado"
                                placeholder="Ingresa el costo estimado" :value="$ticket->costo_estimado" />
                        </div>



                        @if (auth()->user()->id_usuario==445 || auth()->user()->id_usuario==318 || auth()->user()->id_usuario==321 || auth()->user()->id_usuario==300)
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input type="date" label="Fecha estimada" model="fecha_estimada_proy9"
                                    :value="$ticket->fecha_estimada" />
                            </div>

                           

                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input type="datetime-local" autocomplete="false"  placeholder="Click aqui para ingresar fecha" label="Cita y hora"  model="fecha_cita" :value="$ticket->fecha_cita " />
                            </div>

                            @else
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input readonly type="date" label="Fecha estimada" model="fecha_estimada_proy9"
                                    :value="$ticket->fecha_estimada" />
                            </div>


                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input type="datetime-local" readonly autocomplete="false"  placeholder="Click aqui para ingresar fecha" label="Cita y hora"  model="fecha_cita" :value="$ticket->fecha_cita " />
                            </div>

                         
                           

                        @endif

                     

                     
                        @php
                            if ((auth()->user()->id_sucursal == 200 && auth()->user()->rol_tickets == 'Administrador') || auth()->user()->rol_tickets == 'coordinador' || auth()->user()->rol_tickets == 'gerente') {
                                $var = '';
                            } else {
                                $var = 'hidden';
                            }
                        @endphp



                        <div {{ $var }} class="col-12 col-md-6 mb-3">
                            <x-form.select label="Responsable" model="persona_realizo">
                                <option value="">Elige a un responsable...</option>
 
                                

                           @if (auth()->user()->id_usuario == 318 || auth()->user()->id_usuario == 445)

                                <option
                                    {{ (old('persona_realizo') != 'Jose Castillo' and $ticket->realizo != 'Jose Castillo') ?: 'selected' }}>
                                    Jose Castillo</option>
                                <option
                                    {{ (old('persona_realizo') != 'Mariana Vazquez' and $ticket->realizo != 'Mariana Vazquez') ?: 'selected' }}>
                                    Mariana Vazquez</option>
                                <option hidden
                                    {{ (old('persona_realizo') != 'Ricardo Garza' and $ticket->realizo != 'Ricardo Garza') ?: 'selected' }}>
                                    Ricardo Garza</option>
                                <option hidden
                                    {{ (old('persona_realizo') != 'Joaquin Sanchez' and $ticket->realizo != 'Joaquin Sanchez') ?: 'selected' }}>
                                    Joaquin Sanchez</option>
                                <option
                                    {{ (old('persona_realizo') != 'Cristina Herrera' and $ticket->realizo != 'Cristina Herrera') ?: 'selected' }}>
                                    Cristina Herrera</option>
                                    <option hidden
                                    {{ (old('persona_realizo') != 'Harim Bustos' and $ticket->realizo != 'Harim Bustos') ?: 'selected' }}>
                                    Harim Bustos</option>
                                <option hidden
                                    {{ (old('persona_realizo') != 'Juan de León' and $ticket->realizo != 'Juan de León') ?: 'selected' }}>
                                    Juan de León</option>
                                    <option hidden
                                    {{ (old('persona_realizo') != 'Harim Bustos' and $ticket->realizo != 'Harim Bustos') ?: 'selected' }}>
                                    Harim Bustos</option>
                                <option hidden
                                    {{ (old('persona_realizo') != 'Juan Sauceda' and $ticket->realizo != 'Juan Sauceda') ?: 'selected' }}>
                                    Juan Sauceda</option>
                                    
                                    @elseif(auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314)
                                    <option
                                    {{ (old('persona_realizo') != 'Jose Castillo' and $ticket->realizo != 'Jose Castillo') ?: 'selected' }}>
                                    Jose Castillo</option>
                                <option
                                    {{ (old('persona_realizo') != 'Mariana Vazquez' and $ticket->realizo != 'Mariana Vazquez') ?: 'selected' }}>
                                    Mariana Vazquez</option>
                                <option 
                                    {{ (old('persona_realizo') != 'Ricardo Garza' and $ticket->realizo != 'Ricardo Garza') ?: 'selected' }}>
                                    Ricardo Garza</option>
                                <option 
                                    {{ (old('persona_realizo') != 'Joaquin Sanchez' and $ticket->realizo != 'Joaquin Sanchez') ?: 'selected' }}>
                                    Joaquin Sanchez</option>
                                <option
                                    {{ (old('persona_realizo') != 'Cristina Herrera' and $ticket->realizo != 'Cristina Herrera') ?: 'selected' }}>
                                    Cristina Herrera</option>
                                    <option
                                    {{ (old('persona_realizo') != 'Elias Quiñones' and $ticket->realizo != 'Elias Quiñones') ?: 'selected' }}>
                                    Elias Quiñones</option>
                                    <option
                                    {{ (old('Oscar Saucedo') != 'Oscar Saucedo' and $ticket->realizo != 'Oscar Saucedo') ?: 'selected' }}>
                                    Oscar Saucedo</option>
                                    
                                <option hidden
                                    {{ (old('persona_realizo') != 'Juan de León' and $ticket->realizo != 'Juan de León') ?: 'selected' }}>
                                    Juan de León</option>
                                    <option hidden
                                    {{ (old('persona_realizo') != 'Harim Bustos' and $ticket->realizo != 'Harim Bustos') ?: 'selected' }}>
                                    Harim Bustos</option>
                                <option hidden
                                    {{ (old('persona_realizo') != 'Juan Sauceda' and $ticket->realizo != 'Juan Sauceda') ?: 'selected' }}>
                                    Juan Sauceda</option>

                                    @elseif(auth()->user()->id_usuario == 312)
                                    <option
                                    {{ (old('persona_realizo') != 'Jose Castillo' and $ticket->realizo != 'Jose Castillo') ?: 'selected' }}>
                                    Jose Castillo</option>
                                    <option
                                    {{ (old('persona_realizo') != 'Juan Sauceda' and $ticket->realizo != 'Juan Sauceda') ?: 'selected' }}>
                                    Juan Sauceda</option>
                                    <option
                                    {{ (old('persona_realizo') != 'Harim Bustos' and $ticket->realizo != 'Harim Bustos') ?: 'selected' }}>
                                    Harim Bustos</option>
                                    <option
                                    {{ (old('persona_realizo') != 'Juan de León' and $ticket->realizo != 'Juan de León') ?: 'selected' }}>
                                    Juan de León</option>
                                    <option hidden
                                    {{ (old('persona_realizo') != 'Mariana Vazquez' and $ticket->realizo != 'Mariana Vazquez') ?: 'selected' }}>
                                    Mariana Vazquez</option>
                                    <option hidden
                                    {{ (old('persona_realizo') != 'Cristina Herrera' and $ticket->realizo != 'Cristina Herrera') ?: 'selected' }}>
                                    Cristina Herrera</option>

                                  @endif
                            </x-form.select>
                        </div>

                        <div id="ejecucion" class="col-12 col-md-6 mb-3">
                            <x-form.input type="text" label="Tiempo de ejecucion" model="tiempo_ejecucion"
                                :value="$ticket->tiempo_ejecucion" />
                        </div>

                        @if (auth()->user()->id_sucursal == 201  )
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.select label="Responsable" model="persona_realizo" required>
                                    <option value="">Elige a un responsable...</option>
                                    <option
                                        {{ (old('persona_realizo') != 'Elias Quiñones' and $ticket->realizo != 'Elias Quiñones') ?: 'selected' }}>
                                        Elias Quiñones</option>
                                    <option
                                        {{ (old('persona_realizo') != 'Oscar Saucedo' and $ticket->realizo != 'Oscar Saucedo') ?: 'selected' }}>
                                        Oscar Saucedo</option>

                                </x-form.select>
                            </div>

                            @elseif(auth()->user()->id_sucursal == 111)
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.select label="Responsable" model="persona_realizo" required>
                                    <option value="">Elige a un responsable...</option>
                                    <option
                                        {{ (old('persona_realizo') != 'Reynaldo García' and $ticket->realizo != 'Reynaldo García') ?: 'selected' }}>
                                        Reynaldo García</option>
                                    

                                </x-form.select>
                            </div>
                        @endif





                       
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


@if (auth()->user()->id_empresa==33)
<script src="{{ asset('js/menu.js') }}"></script>
@endif
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
