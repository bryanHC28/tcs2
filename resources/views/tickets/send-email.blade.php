<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</head>

<body>
     @if ($ticket['estatus'] == 'Cerrado' && $ticket['empresa'] == 'Pilotchemical')

    <div class="container p-3 mb-2 bg-light text-dark">
        <hr>
        <h3 style="color: gray"><strong>¡Hola!</strong></h3>
        <p><strong>{{ $ticket->usuario }},</strong> solicitamos tu autorizacion para el ticket.</p>
        <p>Número de Ticket #<strong>{{ $ticket->id }}</strong></p>
        <p>Estatus: <strong>{{ $ticket['estatus'] }}</strong></p>
        <p>Prioridad: <strong>{{$ticket['prioridad']}}</strong> </p>
        {{-- <p>Actualizado por: <strong>{{ $userAuth }}</strong></p> --}}
        <p>Descripcion: <strong>{{ $ticket['ticket_descripcion'] }}</strong></p>


        <div style="width: 100%; text-align: center">
            <a style="text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #08a139" href="https://tickets.sumapp.cloud/auth/login">CONTINUAR</a>
        </div>
        <p>Gracias por utilizar nuestra app</p>
        <hr>
    </div>

    @elseif ($ticket['estatus'] == 'Cerrado' && $ticket['empresa'] == 'DemoProyectos9')


    <div class="container p-3 mb-2 bg-light text-dark">
        <hr>
        <h3 style="color: gray"><strong>¡Hola!</strong></h3>
        <p><strong>Administrador@,</strong> Notificamos que el ticket #{{$ticket->id}} ha sido terminado</p>
        <p>Número de Ticket #<strong>{{ $ticket->id }}</strong></p>
        <p>Estatus: <strong>{{ $ticket['estatus'] }}</strong></p>
        <p>Prioridad: <strong>{{$ticket['prioridad']}}</strong> </p>
        {{-- <p>Actualizado por: <strong>{{ $userAuth }}</strong></p> --}}

        <div style="width: 100%; text-align: center">
            <a style="text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #08a139" href="https://tickets.sumapp.cloud/auth/login">CONTINUAR</a>
        </div>
        <p>Gracias por utilizar nuestra app</p>
        <hr>
    </div>



    @elseif ($ticket['estatus'] == 'Cierre final')


    <div class="container p-3 mb-2 bg-light text-dark">
        <hr>
        <h3 style="color: gray"><strong>¡Hola!</strong></h3>
        <p><strong>{{ $ticket->usuario }}</strong> Su ticket con No. #{{ $ticket->id }} ha cambiado a Cierre final exitosamente.</p>
        <p>Descripcion: <strong>{{ $ticket['ticket_descripcion'] }}</strong></p>

        <p>Gracias por utilizar nuestra app</p>
        <hr>
    </div>


@elseif ($ticket['estatus'] == 'Cancelado')


<div class="container p-3 mb-2 bg-light text-dark">
    <hr>
    <h3 style="color: gray"><strong>¡Hola!</strong></h3>
    <p><strong>{{ $ticket->usuario }}</strong> Su ticket con No. #{{ $ticket->id }} ha sido Cancelado.</p>
    <p>Descripcion: <strong>{{ $ticket['ticket_descripcion'] }}</strong></p>

    <p>Gracias por utilizar nuestra app</p>
    <hr>
</div>


@endif


</body>

</html>
