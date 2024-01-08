
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

<title>Tickets Qr</title>


    <!-- Icons font CSS-->
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">
<link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
<!-- Font special for pages-->
<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Vendor CSS-->
<link href="{{ asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
<link href="{{ asset('vendor/datepicker/daterangepicker.css')}}" rel="stylesheet" media="all">

<!-- Main CSS-->
<link href="{{ asset('css/main.css')}}" rel="stylesheet" media="all">

<style>
.bg-gra-07 {

    background: -webkit-gradient(linear, left bottom, right top, from(#c5c9df), to(#d7beaf));
  background: -webkit-linear-gradient(bottom left, #c5c9df 0%, #d7beaf 100%);
  background: -moz-linear-gradient(bottom left, #c5c9df 0%, #d7beaf 100%);
  background: -o-linear-gradient(bottom left, #c5c9df 0%, #d7beaf 100%);
  background: linear-gradient(to top right, #b3b4bf 0%, #b3b4bf 100%);
}
</style>
</head>

<body>
    <div class="page-wrapper bg-gra-07 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Nuevo ticket</h2>

                    <h6>Los campos con <i style="color: red">*</i> son obligatorios para levantar un ticket</h6>

                    <br>
                    <br>
                    <form action="{{ route('api.resources.ticket_qr.store') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="Loader.show()">
                    @csrf
                        <div class="row row-space">

                            <div class="col-2">
                                <label class="label">Sucursal: <i style="color: red">*</i></label>
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select required onchange="getAreas(this.value),getCategorias(this.value)"  name="sucursal">
                                        <option value="">Elige una sucursal</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id_sucursal }}"
                                                {{ old('sucursal') != $sucursal->id_sucursal ?: 'selected' }}>
                                                {{ $sucursal->sucursal }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Nombre del usuario:<i style="color: red">*</i></label>
                                    <input required name="nombre" class="input--style-4" type="text"  >
                                </div>
                            </div>

                        </div>

                        <div class="row row-space">
                            <div class="col-2">
                                <label   required class="label">Area:<i style="color: red">*</i> </label>
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select name="area" id="area">
                                        <option value="">Elige una area...</option>

                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>
                            <div class="col-2">
                                <label  class="label">Categoria: <i style="color: red">*</i></label>
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select required onchange="getSubcategorias(this.value)"   name="categoria" id="categoria"  >
                                        <option value="">Elige una categoria...</option>

                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>

                        </div>

                        <br>
                        <div class="row row-space">
                            <div class="col-2"  id="seccionsubcategoria" style="display:none">
                                <label class="label">Subcategoria</label>
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select name="subarea" name="subcategoria" id="subcategoria">
                                        <option value="">Elige una Subcategoria...</option>

                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>
                            <div class="col-2">
                                <label  class="label">Prioridad</label>
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select id="categoria" name="prioridad">
                                        <option value="">Elige tipo de prioridad</option>
                                        <option value="Alta">Alta</option>
                                        <option value="Media">Media</option>
                                        <option value="Baja">Baja</option>

                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>



                        </div>
<br>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Cuarto:</label>
                                    <input name="cuarto" class="input--style-4" type="text" >
                                </div>
                            </div><div class="col-2">
                                <div class="input-group">
                                    <label class="label">Acción a realizar:</label>
                                    <input name="accion_a_realizar" class="input--style-4" type="text" >
                                </div>
                            </div>


                        </div>

                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Descripcion:</label>
                                    <textarea name="descripcion" class="input--style-4" type="text" ></textarea>
                                </div>
                            </div><div class="col-2">
                                <div class="input-group">
                                    <label class="label">Observaciones:</label>
                                    <textarea name="observaciones" class="input--style-4" type="text" ></textarea>
                                </div>
                            </div>


                        </div>

                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Costo estimado:</label>
                                    <input name="costo_estimado" class="input--style-4" type="number" >
                                </div>
                            </div><div class="col-2">
                                <div class="input-group">
                                    <label class="label">Fecha estimada:</label>
                                    <input name="fecha_estimada" class="input--style-4" type="date" >
                                </div>
                            </div>


                        </div>


                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">



                                    <input type="file" capture="user" label="Evidencia de falla" name="evidencia" accept=".jpg,.jpeg,.png" />
                                </div>



                        </div>
                    </div>
                        <div style="text-align: center" class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Jquery JS-->

    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
    <!-- Vendor JS-->
    <script src="{{ asset('vendor/select2/select2.min.js')}}"></script>
    <script src="{{ asset('vendor/datepicker/moment.min.js')}}"></script>
    <script src="{{ asset('vendor/datepicker/daterangepicker.js')}}"></script>

    <!-- Main JS-->
    <script src="{{ asset('js/global.js')}}"></script>
    <script src="{{ asset('js/loader.js') }}"></script>

    <script>
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


let categorias = [];

function getCategorias(id_sucursal) {
    id_sucursal_var = id_sucursal;
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
    </script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->
