
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkPlay</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        .imagen {
            width: 150px;
            height: 120px;
        }

    </style>
</head>
<body>
 
    <table>
        <thead>
            <tr>
                <th>Datos</th>
                <th>Antes</th>
                <th>Despues</th>
             
            </tr>
        </thead>
        <tbody>

 
@foreach( $resultado as $r)
    
            <tr>
                <td>Descripción: {{ $r->ticket_descripcion }}<br>
                    Fecha de ticket: {{ $r->fecha }}<br>
                    Ticket CPS: {{ $r->ticket_sumapp }}<br>
                    Estado: {{ $r->estatus }}<br>
                    Sucursal: {{ $r->sucursal }}<br>
                    Area/Tipo: {{ $r->area }}</td>
                    <td> 
                        
                        
    @if($r->evidencia_inicial_multiple)
    @php
        $evidenciaInicialMultiple = json_decode($r->evidencia_inicial_multiple);
    @endphp

    @if($evidenciaInicialMultiple)
      
        @php
            // Seleccionar solo la primera imagen
            $imagenSeleccionada = reset($evidenciaInicialMultiple);
        @endphp

        @if($imagenSeleccionada)
            <img src="{{"https://fotostickets.sumapp.cloud/Workplay/".$imagenSeleccionada}}" class="imagen">
        @endif
    @endif
@endif
                    </td>
           
                    <td>

                        














                    
    @if($r->evidencia_final_multiple)
    @php
        $evidenciaFinalMultiple = json_decode($r->evidencia_final_multiple);
    @endphp

    @if($evidenciaFinalMultiple)
      
        @php
            // Seleccionar solo la primera imagen
            $imagenSeleccionada = reset($evidenciaFinalMultiple);
        @endphp

        @if($imagenSeleccionada)
            <img src="{{"https://fotostickets.sumapp.cloud/Workplay/".$imagenSeleccionada}}" class="imagen">
        @endif
    @endif
@endif


                    </td>
            </tr>

@endforeach
        </tbody>
    </table>
</body>
</html>
