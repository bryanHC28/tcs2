@extends('layouts.clean')
@section('title', 'Invitado')

@section('content')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection



<div class="m-4">
    <h4>Genera un ticket</h4>
    <hr>
    <div class="p-2">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('web.invitado.generar') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="Loader.show()">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Sucursal" model="sucursal" readonly>
                                <option value="{{ $session['sucursal']['id_sucursal'] }}" selected>{{
                                    $session['sucursal']['sucursal'] }}</option>
                            </x-form.select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Prioridad" model="prioridad" required>
                                <option value="">Elige tipo de prioridad</option>
                                <option value="Alta">Alta</option>
                                <option value="Media">Media</option>
                                <option value="Baja">Baja</option>
                            </x-form.select>
                            </div>
                            @switch(auth()->user()->id_empresa)
                            @case(10)
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.select label="Transmitió" model="transmitio">
                                    <option value="">Elige una opción</option>
                                    @foreach ($transmitio as $tras)
                                    <option value="{{$tras->transmitio_descripcion}}">{{$tras->transmitio_descripcion}}
                                    </option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            @break

                            @default
                            @endswitch

                            @if (auth()->user()->id_empresa==10)

                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input label="Nombre" model="persona_realizo"
                                    placeholder="Ingrese su nombre" />
                            </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Area" model="area" onchange="getCategoriasAccor(this.value)" required>
                                <option value="">Elige una area</option>
                                @foreach ($areas as $item)
                                <option value="{{ $item->id }}">{{ $item->area }}</option>
                                @endforeach
                            </x-form.select>
                        </div>

                        <div class="col-12 col-md-6 mb-3" id="seccionhabitacion" style="display:none">

                            <x-form.input type="number" label="Numero de habitacion" model="cuarto" placeholder="Ingresa el numero de haitacion..." />


                            </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Categoría" model="categoria"
                                required>
                                <option value="">Elige una categoría</option>
                            </x-form.select>
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.textarea label="Descripción" model="descripcion"
                                placeholder="Ingresa una descripción" />
                        </div>
                        @else
                        <div class="col-12 col-md-6 mb-3" style="display: none" id="divsubcategoria">
                            <x-form.select label="Subcategoría" model="subcategoria">
                                <option value="">Elige una subcategoría</option>
                            </x-form.select>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input type="number" label="Cuarto" model="cuarto" placeholder="Ingresa el cuarto" />
                        </div>
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.input label="Acción a realizar" model="accion_a_realizar"
                                placeholder="Ingresa la acción a realizar" />
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <x-form.textarea label="Observaciones" model="observaciones"
                                placeholder="Ingresa algunas observaciones" />
                        </div>
                        @endif
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="Evidencia de falla 1 (opcional)" model="evidencia0" accept=".jpg,.jpeg,.png" />

                        </div>


                        <div  class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="Evidencia de falla 2 (opcional)" model="evidencia1" accept=".jpg,.jpeg,.png" />
                        </div>
                        {{-- <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile label="Evidencia de falla" capture="user" model="evidencia"
                                accept=".jpg,.jpeg,.png" />
                        </div> --}}
                        <div class="col-12">
                            <hr>
                            <div class="text-right">
                                <a href="{{ route('web.auth.logout') }}" class="btn btn-outline-danger">
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    <script>
        let id_sucursal_var = '{{ $session['sucursal']['id_sucursal'] }}';

        /**
         * Obtiene las categorias y las coloca en el input categoria
         **/
        // let categorias = [];

        // function getCategorias() {
        //     $('#categoria').html(new Option('Elige una categoría', ''));

        //     Loader.show();
        //     axios.get(`{{ url('api/resources/tcs-categorias') }}/${id_sucursal_var}`)
        //         .then(async (response) => {
        //             $.each(categorias = await response.data, (index, item) => {
        //                 $('#categoria').append(new Option(item.categoria, item.id));
        //             });
        //         }).catch((error) => {
        //             categorias = [];
        //             console.log(`getCategoria() - ${error}`);
        //         }).finally(async () => {
        //             Loader.hide();
        //         });
        // }

        /**
         * Obtiene las subcategorias y las coloca en el input subcategoria
         **/
        // let subcategorias = [];

        // function getSubcategorias(id_categoria) {
        //     $('#subcategoria').html(new Option('Elige una subcategoría', ''));

        //     Loader.show();
        //     axios.get(`{{ url('api/resources/tcs-subcategorias') }}/${id_sucursal_var}/${id_categoria}`)
        //         .then(async (response) => {
        //             if(response.data.length > '0'){
        //                  console.log(response.data.length)
        //                $('#divsubcategoria').css('display','block');
        //             $.each(subcategorias = await response.data, (index, item) => {
        //                 $('#subcategoria').append(new Option(item.subcategoria, item.id));
        //             });
        //         }
        //         }).catch((error) => {
        //             subcategorias = [];
        //             console.log(`getSubcategorias() - ${error}`);
        //         }).finally(async () => {
        //             Loader.hide();
        //         });
        // }



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
    @endsection
