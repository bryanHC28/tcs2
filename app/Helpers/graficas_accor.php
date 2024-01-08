<?php

namespace App\Helpers;
use App\Models\{  Tickets };
use Illuminate\Support\Facades\{DB};
class graficas_accor{


    public static function graficas($inicio,$fin){


        $tickets = Tickets::query()
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('id', 'DESC') 
            ->get();

       
            $status = (object) [
                
                'abiertos' => $tickets->where('estatus', 'Abierto')->whereBetween('created_at', [$inicio, $fin])->count(),
                'validado' => $tickets->where('estatus', 'Validado')->whereBetween('created_at', [$inicio, $fin])->count(),
                'cancelado' => $tickets->where('estatus', 'Cancelado')->whereBetween('created_at', [$inicio, $fin])->count(),
                'en_proceso' => $tickets->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
                'cerrados' => $tickets->where('estatus', 'Cerrado')->whereBetween('created_at', [$inicio, $fin])->count(),
                
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
        
            $prioridades = Tickets::SelectRaw('prioridad,COUNT(prioridad) as totalprioridad')->whereBetween('created_at', [$inicio, $fin])->groupBy('prioridad')->get();
            $realizo = DB::connection('tickets')->table('tickets')->SelectRaw('substr(realizo,1,9) as nombre,COUNT(realizo) as totalrealiza')->where('empresa', auth()->user()->empresa->c_nombre_empresa)->where('realizo', '!=', '')->whereBetween('created_at', [$inicio, $fin])->groupBy('realizo')->orderBy('totalrealiza', 'desc')->limit(10)->get();
        
        return view('dashboard.Accor', compact('status', 'abiertos', 'en_proceso', 'cerrados', 'cierrefinal', 'areas', 'prioridades', 'realizo'));
              
    
    }

    
}
 