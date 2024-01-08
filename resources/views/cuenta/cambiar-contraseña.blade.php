@extends('layouts.reportes')

@section('content')
    @include('cuenta.navtab')
    <div class="row">
        <div class="col-12 col-md-4 mb-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-key"></i> Cambia tu contraseña
                    </h5>
                    <hr>
                    <p class="card-text text-justify">
                        Aquí puedes cambiar tu contraseña, recuerda que en caso de olvidar tu actual
                        contraseña puedes reestablecerla en cualquier momento a través del enlace ubicado
                        en la página de inicio de sesión.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 mb-2">
            <div class="card">
                <div class="card-header">
                    Ingresa la información solicitada
                </div>
                <div class="card-body">
                    <form action="{{ route('web.cuenta.cambiar-contraseña.post') }}" method="POST">
                        <div class="card-text row">
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input type="password" model="current_password"
                                    placeholder="Ingresa tu actual contraseña" label="Contraseña actual" required />
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input type="password" model="new_password" placeholder="Ingresa la nueva contraseña"
                                    label="Nueva contraseña" required />
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <x-form.input type="password" model="new_password_confirmation"
                                    placeholder="Ingresa la nueva contraseña otra vez" label="Confirma la nueva contraseña"
                                    required />
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
