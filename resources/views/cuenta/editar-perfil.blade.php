@extends('layouts.reportes')

@section('content')
    @include('cuenta.navtab')
    <div class="row">
        <div class="col-12 col-md-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-user-circle"></i> Edita tu perfil
                    </h5>
                    <hr>
                    <p class="card-text text-justify">
                        Aquí puedes editar tu información, si deseas cambiar
                        algo más que no te sea posible, porfavor contacta al equipo de soporte.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 mb-2">
            <div class="card">
                <div class="card-header">
                    Esta es tu información actual
                </div>
                <div class="card-body">
                    <form action="{{ route('web.cuenta.editar-perfil.post') }}" method="POST">
                        <div class="card-text row">
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input model="first_name" label="Nombre" :value="auth()->user()->first_name"
                                    disabled />
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input model="last_name" label="Apellidos" :value="auth()->user()->last_name"
                                    disabled />
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input model="username" label="Usuario" :value="auth()->user()->username" disabled />
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input model="email" label="Correo" placeholder="Ingresa tu correo electrónico" :value="auth()->user()->email" required/>
                            </div>
                        </div>
                        <hr>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-redo"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
