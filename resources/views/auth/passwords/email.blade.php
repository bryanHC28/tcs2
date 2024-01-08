@extends('layouts.auth')
@section('title', 'Reestablecer contraseña')

@section('content')
<div class="card shadow-lg p-4">
    <div class="text-left">
        <b class="fs-3">@yield('title')</b>
    </div>
    <hr style="height: 2px">
    <form action="{{ route('web.auth.reset_password.post') }}" method="POST">
        @csrf
        <div class="mt-2">
            <label for="email">Correo electrónico: <span class="text-danger">*</span></label>
            <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="ingresa tu licencia de acceso" value="{{ old('email') }}" required>
            @error('email') <span class="text-danger fst-italic">{{ $message }}</span> @enderror
        </div>
        @if (config('app.debug') == false)
        <div class="mt-3">
            <div class="google-recaptcha">
                {!! htmlFormSnippet() !!}
            </div>
            @error('g-recaptcha-response') <span class="text-danger fst-italic">{{ $message }}</span> @enderror
        </div>
        @endif

        <div class="mt-4 text-end">
            <a href="{{ route('web.auth.login.view') }}" class="btn btn-outline-danger">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Enviar</button>
        </div>
    </form>
</div>
@endsection
