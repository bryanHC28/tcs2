@extends('adminlte::page')

@section('plugins.Sweetalert2', false)
@section('plugins.Datatables', true)
    


@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Tickets</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <table id="example" class="display table-hover nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Fecha Hora</th>
                    <th>Sucursal</th>
                    <th>Area</th>
                    <th>Categoría</th>
                   
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $ticket)
                <tr>
                    <td><span>{{filtrar_fecha($ticket->updated_at)}}</span><a href="{{ route('tickets.edit', $ticket->id) }}" target="_blank"></a>
                        {{ formato_fecha($ticket->updated_at)}}</td>
                    <td>{{$ticket->sucursal}}</td>
                    <td>{{$ticket->area}}</td>
                    <td>{{$ticket->categoria}}</td>
                
                    <td>{{$ticket->estatus}}</td>
                </tr>  
                @endforeach
             
                
            </tbody>
            <tfoot>
                <tr>
                    <th>Fecha</th>
                    <th>Sucursal</th>
                    <th>Area</th>
                    <th>Categoría</th>
                   
                    <th>Estatus</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>





@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
   
    <link href="{{asset('vendor/tabulador/css/tabulator.min.css')}}" rel="stylesheet">
    <style>
        #example span {
    display:none; 
}
    </style>
@stop

@section('js')

<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>

<script>
    
    $(document).ready(function() {
    $('#example').DataTable({

    
        "order": [[ 0, "desc" ]],
        autoWidth: false,
        "scrollX": true,
        

        "language": {
            "lengthMenu": "Mostrar _MENU_ registros ",
            "zeroRecords": "No se encontraron datos",
            "info": "Página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay datos disponibles",
            "infoFiltered": "(filtrado de  _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
              "next": "Siguiente",
              "previous": "Anterior"
            }
        }
    });

} );

$('#example tr').click(function() {
        var href = $(this).find("a").attr("href");
        if(href) {
            window.open(href,
            '_blank');
        }
    });

</script>
<script type="text/javascript" src="{{asset('vendor/tabulador/js/tabulator.min.js')}}"></script>
    <script>
  

//define data
var tabledata = [
    {id:1, name:"Oli Bob", location:"United Kingdom", gender:"male", rating:1, col:"red", dob:"14/04/1984"},
    {id:2, name:"Mary May", location:"Germany", gender:"female", rating:2, col:"blue", dob:"14/05/1982"},
    {id:3, name:"Christine Lobowski", location:"France", gender:"female", rating:0, col:"green", dob:"22/05/1982"},
    {id:4, name:"Brendon Philips", location:"USA", gender:"male", rating:1, col:"orange", dob:"01/08/1980"},
    {id:5, name:"Margret Marmajuke", location:"Canada", gender:"female", rating:5, col:"yellow", dob:"31/01/1999"},
    {id:6, name:"Frank Harbours", location:"Russia", gender:"male", rating:4, col:"red", dob:"12/05/1966"},
    {id:7, name:"Jamie Newhart", location:"India", gender:"male", rating:3, col:"green", dob:"14/05/1985"},
    {id:8, name:"Gemma Jane", location:"China", gender:"female", rating:0, col:"red", dob:"22/05/1982"},
    {id:9, name:"Emily Sykes", location:"South Korea", gender:"female", rating:1, col:"maroon", dob:"11/11/1970"},
    {id:10, name:"James Newman", location:"Japan", gender:"male", rating:5, col:"red", dob:"22/03/1998"},
];

//define table
var table = new Tabulator("#example-table", {
    data:tabledata,
    autoColumns:true,
});
    </script>
@stop