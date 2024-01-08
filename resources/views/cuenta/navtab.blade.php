<div>
    @section('title', 'Cuenta')

    <ul id="navtabCuenta" class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('web.cuenta.editar-perfil.view') }}">Editar Perfil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('web.cuenta.cambiar-contraseña.view') }}">Cambiar contraseña</a>
        </li>
    </ul>

    @section('scripts')
        <script>
            $(window).ready(() => {
                $('#navtabCuenta > .nav-item > .nav-link').each((index, item) => {
                    if (item.href === window.location.href) {
                        $(item).addClass('active');
                    }
                });
            });
        </script>
    @endsection
</div>
