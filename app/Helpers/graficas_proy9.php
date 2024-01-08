<?php

namespace App\Helpers;
use App\Models\{  Tickets };
use Illuminate\Support\Facades\{DB};
use Carbon\Carbon;
class graficas_proy9{


    public static function graficas($inicio,$fin){


        $tickets = Tickets::query()
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('id', 'DESC') 
            ->get();

            $status = (object) [
                 
                'abiertos' => $tickets->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
                'cancelado' => $tickets->where('estatus', 'Cancelado')->whereBetween('created_at', [$inicio, $fin])->count(),  
                'cerrados' => $tickets->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
                'ejecutado' => $tickets->where('estatus', 'Ejecutado')->whereBetween('created_at', [$inicio, $fin])->count(),
                'vencido' => $tickets->where('estado', 'Vencido')->whereBetween('created_at', [$inicio, $fin])->count(),
            ];
    
 
            $rey = (object) [
                'abiertos' => $tickets->where('usuario', 'Reynaldo García')->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
                'en_proceso' => $tickets->where('usuario', 'Reynaldo García')->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
                'cerrado' => $tickets->where('usuario', 'Reynaldo García')->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
                'cancelado' => $tickets->where('usuario', 'Reynaldo García')->where('estatus', 'Cancelado')->whereBetween('created_at', [$inicio, $fin])->count(),
                'terminado' => $tickets->where('usuario', 'Reynaldo García')->where('estatus', 'Terminado')->whereBetween('created_at', [$inicio, $fin])->count(),
                'pausado' => $tickets->where('usuario', 'Reynaldo García')->where('estatus', 'Pausado')->whereBetween('created_at', [$inicio, $fin])->count(),
            ];

            if (auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314) {
                $orden = DB::connection('tickets')->table('tickets')
                    ->where('fecha_estimada', '>=', Carbon::now()->toDateString())
                    ->where('prioridad', 'Alta')
                    ->where('empresa', 'DemoProyectos9')
                    ->where('estatus', 'Abierto')
                    ->limit(5)
                    ->get();
                $vencidos = DB::connection('tickets')->table('tickets')
                    ->where('fecha_estimada', '>=', Carbon::now()->subDays(8))->where('fecha_estimada', '<', Carbon::now())
                    ->where('estado', 'Vencido')
                    ->where('empresa', 'DemoProyectos9')
                    ->limit(5)
                    ->get();
                $totales = (object) [
                    'orden' => DB::connection('tickets')->table('tickets')->where('empresa', 'DemoProyectos9')->whereDate('fecha_estimada', '>=', now()->toDateString())->where('estatus', 'Abierto')->where('prioridad', 'Alta')->count(),
                    'vencidos' => DB::connection('tickets')->table('tickets')->where('empresa', 'DemoProyectos9')->where('fecha_estimada', '>=', Carbon::now()->subDays(8))->where('fecha_estimada', '<', Carbon::now())
                        ->where('estado', 'Vencido')
                        ->count()
                ];
    
    
            } else {
                $orden = Tickets::whereDate('fecha_estimada', '>=', now()->toDateString())->where('estatus', 'Abierto')->limit(5)->get();
                $vencidos = Tickets::where('fecha_estimada', '>=', Carbon::now()->subDays(8))->where('fecha_estimada', '<', Carbon::now())
                    ->where('estado', 'Vencido')
                    ->limit(5)
                    ->get();
    
                $totales = (object) [
                    'orden' => Tickets::whereDate('fecha_estimada', '>=', now()->toDateString())->where('estatus', 'Abierto')->count(),
                    'vencidos' => Tickets::where('fecha_estimada', '>=', Carbon::now()->subDays(8))->where('fecha_estimada', '<', Carbon::now())
                        ->where('estado', 'Vencido')
                        ->count()
    
                ];
    
    
            }

            $promedio = Tickets::select(DB::raw('SUM(TIMESTAMPDIFF(DAY, created_at, fecha_tecnico))/COUNT(TIMESTAMPDIFF(DAY, created_at, fecha_tecnico)) AS promedio'), 'realizo')
            ->whereNotNull('close_at')
            ->whereNotNull('realizo')
            ->where('realizo', 'Jose Castillo')
            ->orWhere('realizo', 'Oscar Saucedo')
            ->orWhere('realizo', 'Rocio Salazar')
            ->groupBy('realizo')
            ->orderByDesc('promedio')
            ->get();

            $resultados = Tickets::select('id', DB::raw('TIMESTAMPDIFF(DAY, created_at, fecha_tecnico) AS dias_transcurridos'))
            ->whereNotNull('fecha_tecnico')
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('dias_transcurridos', 'desc')
            ->limit(10)
            ->get();

             $personal_proyectos9 = (object) [
            'cristina_herrera' => DB::connection('tickets')->table('tickets')->where('usuario', 'Cristina Herrera')->whereBetween('created_at', [$inicio, $fin])->count(),
            'rocio_salazar' => DB::connection('tickets')->table('tickets')->where('usuario', 'Rocio Salazar')->whereBetween('created_at', [$inicio, $fin])->count(),
            'elias' => DB::connection('tickets')->table('tickets')->where('usuario', 'Elias Quiñones')->whereBetween('created_at', [$inicio, $fin])->count(),
            'rey' => DB::connection('tickets')->table('tickets')->where('usuario', 'Reynaldo García')->whereBetween('created_at', [$inicio, $fin])->count(),

        ];

        $elias = (object) [
            'abiertos' => DB::connection('tickets')->table('tickets')->where('usuario', 'Elias Quiñones')->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
            'en_proceso' => DB::connection('tickets')->table('tickets')->where('usuario', 'Elias Quiñones')->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cerrado' => DB::connection('tickets')->table('tickets')->where('usuario', 'Elias Quiñones')->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cancelado' => DB::connection('tickets')->table('tickets')->where('usuario', 'Elias Quiñones')->where('estatus', 'Cancelado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'terminado' => DB::connection('tickets')->table('tickets')->where('usuario', 'Elias Quiñones')->where('estatus', 'Terminado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'pausado' => DB::connection('tickets')->table('tickets')->where('usuario', 'Elias Quiñones')->where('estatus', 'Pausado')->whereBetween('created_at', [$inicio, $fin])->count(),
        ];

   $rocio_salazar = (object) [
            'abiertos' => $tickets->where('usuario', 'Rocio Salazar')->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
            'en_proceso' => $tickets->where('usuario', 'Rocio Salazar')->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cerrado' => $tickets->where('usuario', 'Rocio Salazar')->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cancelado' => $tickets->where('usuario', 'Rocio Salazar')->where('estatus', 'Cancelado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'terminado' => $tickets->where('usuario', 'Rocio Salazar')->where('estatus', 'Terminado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'pausado' => $tickets->where('usuario', 'Rocio Salazar')->where('estatus', 'Pausado')->whereBetween('created_at', [$inicio, $fin])->count(),
        ];

        $cristina_herrera = (object) [
            'abiertos' => $tickets->where('usuario', 'Cristina Herrera')->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
            'en_proceso' => $tickets->where('usuario', 'Cristina Herrera')->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cerrado' => $tickets->where('usuario', 'Cristina Herrera')->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cancelado' => $tickets->where('usuario', 'Cristina Herrera')->where('estatus', 'Cancelado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'terminado' => $tickets->where('usuario', 'Cristina Herrera')->where('estatus', 'Terminado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'pausado' => $tickets->where('usuario', 'Cristina Herrera')->where('estatus', 'Pausado')->whereBetween('created_at', [$inicio, $fin])->count(),
        ];

        $areas_proyectos9 = (object) [
            'plaza_comercial' => $tickets->where('area', 'Cuauhtémoc comercial')->whereBetween('created_at', [$inicio, $fin])->count(),
            'residencial' => $tickets->where('area', 'Cuauhtémoc residencial')->whereBetween('created_at', [$inicio, $fin])->count(),
            'estacionamientos' => $tickets->where('area', 'ESTACIONAMIENTOS')->whereBetween('created_at', [$inicio, $fin])->count()
        ];

        $plaza_comercial = (object) [
            'abiertos' => $tickets->where('area', 'Cuauhtémoc comercial')->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
            'en_proceso' => $tickets->where('area', 'Cuauhtémoc comercial')->where('estatus', 'Ejecutado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cerrado' => $tickets->where('area', 'Cuauhtémoc comercial')->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cancelado' => $tickets->where('area', 'Cuauhtémoc comercial')->where('estatus', 'Cancelado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'terminado' => $tickets->where('area', 'Cuauhtémoc comercial')->where('estatus', 'Terminado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'pausado' => $tickets->where('area', 'Cuauhtémoc comercial')->where('estatus', 'Pausado')->whereBetween('created_at', [$inicio, $fin])->count(),
        ];
        $residencial = (object) [
            'abiertos' => $tickets->where('area', 'Cuauhtémoc residencial')->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
            'en_proceso' => $tickets->where('area', 'Cuauhtémoc residencial')->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cerrado' => $tickets->where('area', 'Cuauhtémoc residencial')->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'cancelado' => $tickets->where('area', 'Cuauhtémoc residencial')->where('estatus', 'Cancelado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'terminado' => $tickets->where('area', 'Cuauhtémoc residencial')->where('estatus', 'Terminado')->whereBetween('created_at', [$inicio, $fin])->count(),
            'pausado' => $tickets->where('area', 'Cuauhtémoc residencial')->where('estatus', 'Pausado')->whereBetween('created_at', [$inicio, $fin])->count(),
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
        $equipos = Tickets::SelectRaw('inventario,COUNT(inventario) as totalequipos')->whereBetween('created_at', [$inicio, $fin])->groupBy('inventario')->orderBy('totalequipos', 'desc')->limit(10)->get();
        $prioridades = Tickets::SelectRaw('prioridad,COUNT(prioridad) as totalprioridad')->whereBetween('created_at', [$inicio, $fin])->groupBy('prioridad')->get();
        $personales = Tickets::SelectRaw('usuario,COUNT(usuario) as totalpersonal')->whereBetween('created_at', [$inicio, $fin])->groupBy('usuario')->get();
        
        return view('dashboard.proyectos9', compact('status', 'rey', 'totales', 'orden', 'vencidos', 'promedio', 'resultados', 'personal_proyectos9', 'elias', 'rocio_salazar', 'cristina_herrera', 'areas_proyectos9', 'plaza_comercial', 'residencial' , 'abiertos', 'en_proceso', 'realizo', 'cerrados', 'areas', 'equipos', 'prioridades', 'personales'));
              
    
    }

    
}
 