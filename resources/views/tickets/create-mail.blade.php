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

 


    <div class="container p-3 mb-2 bg-light text-dark">
        <hr>
        <h3 style="color: gray"><strong>¡Hola Administrador@!</strong></h3>
        <p><strong></strong>El usuario {{ $usuario ?? "No aplica" }} a creado un nuevo Ticket</p>
        <p>Folio:<strong>#{{ $ticket ?? "No aplica"}}</strong></p>
        <p>Area: <strong>{{ $area ?? "No aplica" }}</strong></p>
        <p>Descripcion: <strong>{{ $descripcion ?? "Sin descripcion" }}</strong></p>
        <p>Equipo: <strong>{{ $equipo ?? "No aplica" }}</strong></p>
        <hr>
        <br>
        <div style="width: 100%; text-align: center">
            <a style="text-decoration: none; border-radius: 5px; padding: 11px 23px; color: white; background-color: #08a139" href="https://tickets.sumapp.cloud/auth/login">CONTINUAR</a>
        </div>

        <p>Gracias por utilizar nuestra app</p>
        <hr>

        


    </div>



</body>

</html>
