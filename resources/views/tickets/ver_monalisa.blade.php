@extends('layouts.clean')
@section('title', 'Invitado')

@section('content')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection



<div class="m-4">
    <h3>Sunset Monalisa</h3>
    <hr>
    <h4>Ticket #{{$ticket->id}}</h4>
    
    <hr>
    <div class="pb-2">
        <div class="card">
            <div class="card-body">
                <div class="row">


                    
                <div class="col-12 col-md-4 mb-3">
					<label >Folio</label>
                    <input label="Folio" class="form-control" model="folio" value="#{{$ticket->id}}" disabled />
                </div>
                <div class="col-12 col-md-4 mb-3">
					<label >Creación</label>
                    <input label="Creación" class="form-control" value="{{$ticket->created_at ?? 'Desconocido'}}" disabled />
                </div>
                <div class="col-12 col-md-4 mb-3">
					<label >Actualización</label>
                    <input label="Actualización" class="form-control" value="{{$ticket->updated_at ?? 'Ninguna'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Estado</label>
                    <input label="Estado" class="form-control" value="{{$ticket->estatus ?? '[No hay información]'}}" disabled />
                </div>
					 <div class="col-12 col-md-6 mb-3">
					<label >Autor</label>
                    <input label="Estado" class="form-control" value="{{$ticket->usuario ?? '[No hay información]'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Prioridad</label>
                    <input label="Prioridad" class="form-control" value="{{$ticket->prioridad ?? '[No hay información]'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Sucursal</label>
                    <input label="Sucursal" class="form-control" value="{{$ticket->sucursal ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Area</label>
                    <input label="Area" class="form-control" value="{{$ticket->area ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Subarea</label>
                    <input label="Subarea" class="form-control" value="{{$ticket->categoria ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Categoría</label>
                    <input label="Categoria" class="form-control" value="{{$ticket->categoria ?? 'No aplica'}}" disabled />
                </div>              
                <div class="col-12 col-md-6 mb-3">
						<label >Accion</label>
					<textarea label="Categoria" class="form-control" disabled>{{$ticket->accion ?? 'No aplica'}}</textarea>  
                </div>
                <div class="col-12 col-md-6 mb-3">
						<label >Descripcion</label>
                    <textarea class="form-control" disabled>{{$ticket->ticket_descripcion ?? 'No aplica'}}</textarea>
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Observaciones</label>
                    <textarea class="form-control" disabled>{{$ticket->observaciones ?? 'No aplica'}}</textarea>
                </div>
					 <div class="col-12 col-md-6 mb-3">
					<label >Comentarios cliente</label>
                    <textarea class="form-control" disabled>{{$ticket->comentario_cliente ?? 'No aplica'}}</textarea>
                </div>
					 <div class="col-12 col-md-6 mb-3">
					<label >Comentarios mantenimiento</label>
                    <textarea class="form-control" disabled>{{$ticket->comentario_mantto ?? 'No aplica'}}</textarea>
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Costo estimado</label>
                    <input label="Subarea" class="form-control" value="{{$ticket->costo_estimado ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Fecha estimada</label>
                    <input label="Categoria" class="form-control" value="{{$ticket->fecha_estimada ?? 'No aplica'}}" disabled />
                </div>
                <div class="col-12 col-md-6 mb-3">
					<label >Persona asignada</label>
                    <input label="Subarea" class="form-control" value="{{$ticket->realizo ?? 'No aplica'}}" disabled />
                </div>
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


