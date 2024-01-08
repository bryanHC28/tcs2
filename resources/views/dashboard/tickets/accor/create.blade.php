@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
    <h1>Abrir Ticket</h1>
@stop

@section('content')
    <div class="pb-2">
        <div class="card">

            <div class="card-body">
           
                <form action="{{ route('web.dashboard.accor.store') }}" method="POST" enctype="multipart/form-data"
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
                            <x-form.select label="Prioridad" model="prioridad" required>
                                <option value=""></option>
                                <option value="Alta">Alta</option>
                                <option value="Media">Media</option>
                                <option value="Baja">Baja</option>
                            </x-form.select>
                            </div>



 

                      
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select choices label="Area" model="area" onchange="getCategoriasAccor(this.value)" required>
                                <option value="">Elige una area</option>
                            </x-form.select>
                        </div>
                       
                       
                        
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.select label="Categoría" model="categoria" 
                                required>
                                <option value="">Elige una categorías</option>
                            </x-form.select>
                        </div>

                     
                      
                             <div class="col-12 col-md-6 mb-3" id="seccionhabitacion" style="display:none">

                                <x-form.input type="number" label="Habitacion" model="cuarto" placeholder="Ingresa el numero de habitacion..." />


                                </div>
                     

                  

                    
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.textarea label="Descripción" model="descripcion"
                                placeholder="Ingresa una descripción" />
                        </div>
                      
 

 
                       
                     
                        <div class="col-12 col-md-6 mb-3">
                            <x-form.inputfile capture="user" label="Evidencia de falla 1 (opcional)" model="evidencia0" accept=".jpg,.jpeg,.png" />



                        </div>


                        <div  class="col-12 col-md-6 mb-3">
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
 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stop
