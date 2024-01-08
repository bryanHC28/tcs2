@extends('layouts.auth')
@section('title', 'Inicia sesión')

@section('content')
 
<div class="card shadow-lg p-4">
    <div class="text-left">
        <b class="fs-3">@yield('title')</b>
    </div>
    <hr style="height: 2px">
    <form action="{{ route('web.auth.login.post') }}" method="POST">
        @csrf
        <div class="mt-2">
            <label for="email">Correo electrónico: <span class="text-danger">*</span></label>
            <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Ingrese su correo electrónico" value="{{ old('email') }}" required>
            @error('email') <span class="text-danger fst-italic">{{ $message }}</span> @enderror
        </div>
        <div class="mt-3">
            <label for="password">Contraseña: <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Ingresa su contraseña" required>
            @error('password') <span class="text-danger fst-italic">{{ $message }}</span> @enderror
        </div>
      

        <div class="text-end">
            @if (Route::has('web.auth.reset_password.view'))
            <div class="mt-2">
                <a href="{{ route('web.auth.reset_password.view') }}" class="btn btn-link">Reestablecer contraseña</a>
            </div>
            @endif
            <div class="mt-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Acceder</button>
            </div>
        </div>
    </form>
</div>
 










 <div class="modal fade" id="tutorialModal" tabindex="-1" role="dialog" aria-labelledby="tutorialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tutorialModalLabel">Tutorial</h5>
               
                </div>
                <div class="modal-body">
                
					<div id="imageCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('img/1.jpeg') }}" style="display: block; margin: 0 auto; max-width: 60%;" alt="Imagen 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('img/2.jpeg') }}" style="display: block; margin: 0 auto; max-width: 60%;" alt="Imagen 2">
        </div>
		<div class="carousel-item">
            <img src="{{ asset('img/3.jpeg') }}" style="display: block; margin: 0 auto; max-width: 60%;" alt="Imagen 2">
        </div>
		<div class="carousel-item">
            <img src="{{ asset('img/4.jpeg') }}" style="display: block; margin: 0 auto; max-width: 60%;" alt="Imagen 2">
        </div>
		<div class="carousel-item">
            <img src="{{ asset('img/5.jpeg') }}" style="display: block; margin: 0 auto; max-width: 60%;" alt="Imagen 2">
        </div>
		<div class="carousel-item">
            <img src="{{ asset('img/6.jpeg') }}" style="display: block; margin: 0 auto; max-width: 60%;" alt="Imagen 2">
        </div>
        <!-- Agrega más imágenes según sea necesario -->
    </div>
    <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" ariahidden="true"></span>
        <span class="sr-only">Siguiente</span>
    </a>
</div>

					
					
					
					
					
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

 

@endsection
