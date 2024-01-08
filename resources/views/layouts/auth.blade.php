<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/sumapp.png') }}" />
    <link href="{{ asset('css/fontawesome5.css') }}" rel="stylesheet" />
	<link rel="shortcut icon" href="{{ asset('images/sumappen-g.png')}}">
     <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  
    <style>
        body,
        html {
            background: #F68D2C;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #F68D2C, #1E2945);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #F68D2C, #1E2945);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

        .card {
            border-radius: 15px;
            border-top: 3px solid rgb(6, 91, 250);
        }

        .brand-logo {
            max-height: 100px;
        }

        #g-recaptcha-response {
            display: block !important;
            position: absolute;
            margin: -78px 0 0 0 !important;
            width: 302px !important;
            height: 76px !important;
            z-index: -999999;
            opacity: 0;
        }
  /* Cambia el color de las flechas "Siguiente" y "Anterior" a negro */
  .carousel-control-prev-icon, .carousel-control-next-icon {
    background-color: #000; /* Cambia el color a negro (#000) */
  }
 
  
 .modal-dialog {
  max-width: 400px; /* Establece el ancho máximo deseado */
}
    </style>
    {!! htmlScriptTagJsApi() !!}
</head>

<body>
    <div class="container mt-4">
        <div class="pb-5">
            <div class="mx-auto" style="max-width: 600px">
                <div class="text-center text-light mb-2">
                    <div>
                        <img class="brand-logo" src="{{ asset('img/sumapp.png') }}" alt="SuMapp">
                    </div>
                    <div class="mt-2">
                        <h3 class="fw-bold">Sumapp</h3>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h3>{{ config('app.name') }}</h3>
                    </div>
                    @if (config('app.debug') == true)
                        <div class="my-3 p-2 alert alert-warning">
                            <h3>Modo de depuración activado</h3>
                        </div>
                    @endif
                </div>
                @yield('content')
            </div>
        </div>
    </div>

    @yield('scripts')
 
	
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
    <script src="{{ asset('/sw.js') }}"></script>
	
	<script>
	// Función para detectar si es un dispositivo iOS
function isIOS() {
    return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
}

// Ejemplo de uso
if (isIOS()) {
    Swal.fire({
                title: "Tutorial para la instalación de la app!",
                showCancelButton: true,
                confirmButtonText: "Ver tutorial",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#tutorialModal').modal('show');
                }
            });
} else {
    // Código para otros dispositivos
    console.log('Este dispositivo no es iOS');
}

	</script>
    <script>
 
       if ("serviceWorker" in navigator) {
          // Register a service worker hosted at the root of the
          // site using the default scope.
          navigator.serviceWorker.register("/sw.js").then(
          (registration) => {
             console.log("Service worker registration succeeded:", registration);
          },
          (error) => {
             console.error(`Service worker registration failed: ${error}`);
          },
        );
      } else {
         console.error("Service workers are not supported.");
      }
    </script>
	<script>     
		// Detecta el evento beforeinstallprompt
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
   e.preventDefault();
   deferredPrompt = e;

   // Muestra un SweetAlert2 personalizado para la instalación
   Swal.fire({
       title: 'Instalar Tickets',
       text: '¿Deseas instalar esta aplicación en tu dispositivo?',
       icon: 'question',
       showCancelButton: true,
       confirmButtonText: 'Sí, instalar',
       cancelButtonText: 'No, gracias',
   }).then((result) => {
       if (result.isConfirmed) {
           // El usuario confirmó la instalación, así que mostramos el cuadro de diálogo de instalación.
           deferredPrompt.prompt();

           // Maneja la respuesta del usuario
           deferredPrompt.userChoice.then((choiceResult) => {
               if (choiceResult.outcome === 'accepted') {
                   // La PWA se instaló correctamente
                   Swal.fire('Instalación Exitosa', '', 'success');
               } else {
                   // El usuario rechazó la instalación
                   Swal.fire('Instalación Cancelada', '', 'info');
               }
               deferredPrompt = null; // Restablece la variable para futuras solicitudes
           });
       }
   });
});
 
		 
	</script>
	 
    <script>
        window.onload = function() {
            var $recaptcha = document.querySelector('#g-recaptcha-response');

            if ($recaptcha) {
                $recaptcha.setAttribute("required", "required");
            }
        };
    </script>
    @include('components.SweetAlert2')
    @include('components.ConsoleLog')
</body>

</html>
