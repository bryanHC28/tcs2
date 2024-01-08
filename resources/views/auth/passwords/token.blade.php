@extends('layouts.auth')
@section('title', "Crea tu nueva contraseña $usuario->nombre")

@section('content')
<div class="card shadow-lg p-4">
    <div class="text-left">
        <b class="fs-3">@yield('title')</b>
    </div>
    <hr style="height: 2px">
    <form action="{{ route('web.auth.reset_password.token_post') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mt-2">
            <label for="password">Nueva Contraseña: <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="******" required>
            @error('password') <span class="text-danger fst-italic">{{ $message }}</span> @enderror
        </div>
        <div class="mt-3">
            <label for="password_confirmation">Confirma la contraseña: <span class="text-danger">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="******" required>
            @error('password_confirmation') <span class="text-danger fst-italic">{{ $message }}</span> @enderror
        </div>
        <div class="text-end mt-4">
            <a href="{{ route('web.auth.login.view') }}" class="btn btn-outline-danger"><i class="fas fa-times"></i> Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Finalizar</button>
        </div>
    </form>
</div>
@endsection
