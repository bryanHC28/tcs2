<?php

namespace App\Helpers;
use App\Models\{  Tickets };
use Illuminate\Support\Facades\{DB};
class graficas_pilot{


    public static function graficas($inicio,$fin){


        $tickets = Tickets::query()
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('id', 'DESC') 
            ->get();

        $status = (object) [
            
            'abiertos' => $tickets->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
            'en_proceso' => $tickets->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cerrados' => $tickets->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cierrefinal' => $tickets->where('estatus', 'Cierre final')->whereBetween('created_at', [$inicio, $fin])->count(),
            'preventivos' => $tickets->where('tipo_ticket', 'Preventivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'correctivos' => $tickets->where('tipo_ticket', 'Correctivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'modificaciones' => $tickets->where('tipo_ticket', 'Modificaciones')->whereBetween('created_at', [$inicio, $fin])->count(),
            'rutinario' => $tickets->where('tipo_ticket', 'Rutinario')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cancelado' => $tickets->where('estatus', 'Cancelado')->whereBetween('created_at', [$inicio, $fin])->count(),
            
        ];

        $resultados = Tickets::select('id', DB::raw('TIMESTAMPDIFF(DAY, created_at, fecha_tecnico) AS dias_transcurridos'))
        ->whereNotNull('fecha_tecnico')
        ->whereBetween('created_at', [$inicio, $fin])
        ->orderBy('dias_transcurridos', 'desc')
        ->limit(10)
        ->get();
        $aceptados = Tickets::SelectRaw('usuario,COUNT(usuario) as totalusuario')->where('estado', 'Aceptado')->whereBetween('created_at', [$inicio, $fin])->groupBy('usuario')->get();
        $rechazados = Tickets::SelectRaw('usuario,COUNT(usuario) as totalusuario')->where('estado', 'Rechazado')->whereBetween('created_at', [$inicio, $fin])->groupBy('usuario')->get();
        $abiertos = (object) [
            'correctivos' => $tickets->where('estatus', 'Abierto')->where('tipo_ticket', 'Correctivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'preventivos' => $tickets->where('estatus', 'Abierto')->where('tipo_ticket', 'Preventivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'modificaciones' => $tickets->where('estatus', 'Abierto')->where('tipo_ticket', 'Modificaciones')->whereBetween('created_at', [$inicio, $fin])->count(),
            'mejora_continua' => $tickets->where('estatus', 'Abierto')->where('tipo_ticket', 'Mejora continua')->whereBetween('created_at', [$inicio, $fin])->count(),
        ];

        $en_proceso = (object) [
            'correctivos' => $tickets->where('estatus', 'En proceso')->where('tipo_ticket', 'Correctivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'preventivos' => $tickets->where('estatus', 'En proceso')->where('tipo_ticket', 'Preventivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'modificaciones' => $tickets->where('estatus', 'En proceso')->where('tipo_ticket', 'Modificaciones')->whereBetween('created_at', [$inicio, $fin])->count(),
        ];
        $realizo = DB::connection('tickets')->table('tickets')->SelectRaw('substr(realizo,1,9) as nombre,COUNT(realizo) as totalrealiza')->where('empresa', auth()->user()->empresa->c_nombre_empresa)->where('realizo', '!=', '')->whereBetween('created_at', [$inicio, $fin])->groupBy('realizo')->orderBy('totalrealiza', 'desc')->limit(10)->get();
        $cerrados = (object) [
            'correctivos' => $tickets->where('estatus', 'Cerrado')->where('tipo_ticket', 'Correctivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'preventivos' => $tickets->where('estatus', 'Cerrado')->where('tipo_ticket', 'Preventivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'modificaciones' => $tickets->where('estatus', 'Cerrado')->where('tipo_ticket', 'Modificaciones')->whereBetween('created_at', [$inicio, $fin])->count(),
        ];

        $cierrefinal = (object) [
            'correctivos' => $tickets->where('estatus', 'Cierre final')->where('tipo_ticket', 'Correctivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'preventivos' => $tickets->where('estatus', 'Cierre final')->where('tipo_ticket', 'Preventivo')->whereBetween('created_at', [$inicio, $fin])->count(),
            'modificaciones' => $tickets->where('estatus', 'Cierre final')->where('tipo_ticket', 'Modificaciones')->whereBetween('created_at', [$inicio, $fin])->count(),
        ];
        
        $areas = Tickets::SelectRaw('substr(area,1,9) as area,COUNT(area) as totalareas')->whereBetween('created_at', [$inicio, $fin])->groupBy('area')->get();
        
        $categorias = Tickets::SelectRaw('categoria,COUNT(categoria) as totalcategorias')->whereBetween('created_at', [$inicio, $fin])->groupBy('categoria')->get();
        $equipos = Tickets::SelectRaw('inventario,COUNT(inventario) as totalequipos')->whereBetween('created_at', [$inicio, $fin])->groupBy('inventario')->orderBy('totalequipos', 'desc')->limit(10)->get();
        $prioridades = Tickets::SelectRaw('prioridad,COUNT(prioridad) as totalprioridad')->whereBetween('created_at', [$inicio, $fin])->groupBy('prioridad')->get();
        $personales = Tickets::SelectRaw('usuario,COUNT(usuario) as totalpersonal')->whereBetween('created_at', [$inicio, $fin])->groupBy('usuario')->get();

        return view('dashboard.graficas', compact('status',  'resultados', 'aceptados', 'rechazados', 'abiertos' , 'en_proceso', 'realizo', 'cerrados', 'cierrefinal', 'areas', 'categorias', 'equipos', 'prioridades', 'personales'));
              
    
    }

    
}
 