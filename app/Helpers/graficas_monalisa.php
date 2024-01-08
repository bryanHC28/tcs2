<?php

namespace App\Helpers;
use App\Models\{  Tickets };
use Illuminate\Support\Facades\{DB};
class graficas_monalisa{


    public static function graficas($inicio,$fin){


        $tickets = Tickets::query()
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('id', 'DESC') 
            ->get();

       


            $status = (object) [
              
                'abiertos' => $tickets->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
                'suspendido' => $tickets->where('estatus', 'Suspendido')->whereBetween('created_at', [$inicio, $fin])->count(),
                'en_proceso' => $tickets->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
                'cerrados' => $tickets->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
                'ejecutado' => $tickets->where('estatus', 'Ejecutado')->whereBetween('created_at', [$inicio, $fin])->count(),
               
                
            ];
            $promedio_monalisa = Tickets::select(DB::raw('SUM(TIMESTAMPDIFF(DAY, created_at, fecha_tecnico))/COUNT(TIMESTAMPDIFF(DAY, created_at, fecha_tecnico)) AS promedio'), 'realizo')
            ->whereNotNull('close_at')
            ->whereNotNull('realizo')
            ->where('realizo', 'Cabos Monalisa')
            ->groupBy('realizo')
            ->orderByDesc('promedio')
            ->get();

            $resultados = Tickets::select('id', DB::raw('TIMESTAMPDIFF(DAY, created_at, fecha_tecnico) AS dias_transcurridos'))
            ->whereNotNull('fecha_tecnico')
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('dias_transcurridos', 'desc')
            ->limit(10)
            ->get();
            $personal_monalisa = (object) [
                'Cabos_Monalisa' => $tickets->where('usuario', 'Emiliano  Papalardo')->whereBetween('created_at', [$inicio, $fin])->count()
            ];
            
        $Cabos_Monalisa = (object) [
            'abiertos' => $tickets->where('usuario', 'Emiliano  Papalardo')->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
            'en_proceso' => $tickets->where('usuario', 'Emiliano  Papalardo')->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cerrado' => $tickets->where('usuario', 'Emiliano  Papalardo')->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'suspendido' => $tickets->where('usuario', 'Emiliano  Papalardo')->where('estatus', 'Suspendido')->whereBetween('created_at', [$inicio, $fin])->count(),
            'ejecutado' => $tickets->where('usuario', 'Emiliano  Papalardo')->where('estatus', 'Ejecutado')->whereBetween('created_at', [$inicio, $fin])->count(),

        ];

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
        $areas = Tickets::SelectRaw('substr(area,1,9) as area,COUNT(area) as totalareas')->whereBetween('created_at', [$inicio, $fin])->groupBy('area')->get();
        $prioridades = Tickets::SelectRaw('prioridad,COUNT(prioridad) as totalprioridad')->whereBetween('created_at', [$inicio, $fin])->groupBy('prioridad')->get();
       
            return view('dashboard.monalisa', compact('status', 'promedio_monalisa', 'resultados', 'personal_monalisa', 'Cabos_Monalisa', 'abiertos', 'en_proceso', 'realizo', 'cerrados', 'areas', 'prioridades'));
              
    
    }

    
}
 