<script>
    $(window).on('load', function() {
        @if (session('ConsoleLog') xor isset($ConsoleLog))
            @if (config('app.debug') == true)
                const $ConsoleLog = {!! json_encode(session('ConsoleLog') ?? $ConsoleLog) !!};
                console.log("Backend ConsoleLog - '" + $ConsoleLog.title + "':\n\n" + $ConsoleLog.text);
            @else
                console.log('Se retorno un mensaje "Backend ConsoleLog" sin embargo no puede ser mostrado ya que no está activado el modo de depuración (APP_DEBUG)')
            @endif
        @endif
    });
</script>
