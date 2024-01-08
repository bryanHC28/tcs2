@extends('layouts.clean')
@section('title', 'Invitado')

@section('content')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection



<div class="m-4">
    <h4>Ticket #{{$ticket->id}}</h4>
    <hr>
    <div class="pb-2">
        <div class="card">
            <div class="card-body">
                <div class="row">


                <div class="col-12 col-md-4 mb-3">
                    <input label="Folio" class="form-control" model="folio" value="#{{$ticket->id}}" disabled />
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <input label="Creación" class="form-control" value="{{$ticket->created_at ?? 'Desconocido'}}" disabled />
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <input label="Actualización" class="form-control" value="{{$ticket->updated_at ?? 'Ninguna'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Estado" class="form-control" value="{{$ticket->estatus ?? '[No hay información]'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Prioridad" class="form-control" value="{{$ticket->prioridad ?? '[No hay información]'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Sucursal" class="form-control" value="{{$ticket->sucursal ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Area" class="form-control" value="{{$ticket->area ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Subarea" class="form-control" value="{{$ticket->categoria ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Categoria" class="form-control" value="{{$ticket->nivel ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Subarea" class="form-control" value="{{$ticket->tipo_ticket ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Categoria" class="form-control" value="{{$ticket->accion ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <textarea class="form-control" value="{{$ticket->ticket_descripcion ?? 'No aplica'}}" disabled></textarea>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <textarea class="form-control" value="{{$ticket->observaciones ?? 'No aplica'}}" disabled></textarea>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Subarea" class="form-control" value="{{$ticket->costo_estimado ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Categoria" class="form-control" value="{{$ticket->fecha_estimada ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <input label="Subarea" class="form-control" value="{{$ticket->realizo ?? 'No aplica'}}" disabled />
                </div>



            


 

 
 
            <div class="col-12">
                        <hr>
                        <div style="text-align: center" class="text-left">
                            <a class="btn btn-info" href="https://tickets.sumapp.cloud/auth/login">
                                <i class="fas fa-angle-left"></i> Iniciar Sesión
                            </a>
                        </div>
				
				 
                    </div>

                </div>

            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


    @endsection


