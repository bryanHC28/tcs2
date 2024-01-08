<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.1/howler.min.js"></script>

@if (session('SweetAlert2') xor isset($SweetAlert2))
    <script>
        $(window).on('load', function() {
            let $SweetAlert2 = {!! json_encode(session('SweetAlert2') ?? $SweetAlert2) !!};
            Swal.fire({
                icon: $SweetAlert2.icon,
                title: $SweetAlert2.title,
                text: $SweetAlert2.text,
                confirmButtonText: 'Aceptar'
            });

            let sound = new Howl({
              src: ["{{ asset('audio/alert.mp3') }}"],
              volume: 1.0
            });

            sound.play()
        });
    </script>
@endif
