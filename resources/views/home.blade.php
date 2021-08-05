@extends('adminlte::page')

@section('plugins.Sweetalert2', false)
    


@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
@role('operativo')
    I am a operativo!
@endrole
@role('visitante')
    I am a visitante...
@endrole
@role('admin')
 @livewire('dashboard.contenedor')
@endrole
@role('cliente')
    
   cliente
    

@endrole

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        Swal.fire(
  'Good job!',
  'You clicked the button!',
  'success'
)
    </script>
@stop