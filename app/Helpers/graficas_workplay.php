<?php

namespace App\Helpers;
use App\Models\{  Tickets };
use Illuminate\Support\Facades\{DB};
class graficas_workplay{


    public static function graficas($inicio,$fin){


          
            if(auth()->user()->id_usuario == 496 || auth()->user()->id_usuario == 497 || auth()->user()->id_usuario == 502 || auth()->user()->id_usuario == 503 || auth()->user()->id_usuario == 504){

            $distritos = DB::connection('tickets')->table('tickets')->join('EV_SUMAPP.tb_sucursal', 'tickets.tickets.sucursal', '=', 'EV_SUMAPP.tb_sucursal.sucursal')
            ->where('tickets.tickets.empresa', 'Workplay')
            ->groupBy('EV_SUMAPP.tb_sucursal.distrito')
            ->select('EV_SUMAPP.tb_sucursal.distrito', \DB::raw('COUNT(*) as conteo'))
            ->get();

     
            $resultados_lsm = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->select('sucursal','id', DB::raw('TIMESTAMPDIFF(DAY, created_at, close_at) AS dias_transcurridos'))
            ->whereNotNull('close_at')
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('dias_transcurridos', 'desc')
            ->limit(10)
            ->get();

            $areas_lsm = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->SelectRaw('substr(area,1,18) as area,COUNT(area) as totalareas')->whereBetween('created_at', [$inicio, $fin])->groupBy('area')->get();

           $sucursales_lsm = DB::connection('tickets')->table('tickets')->select('sucursal', \DB::raw('COUNT(*) as conteo'))
            ->where('empresa', 'Workplay')
            ->groupBy('sucursal')
            ->orderByDesc('conteo')
            ->limit(10)
            ->get();

            $sucursales_lsm_all = DB::connection('tickets')->table('tickets')->select('sucursal', \DB::raw('COUNT(*) as conteo'))
            ->where('empresa', 'Workplay')
            ->groupBy('sucursal')
            ->orderByDesc('conteo')
            ->get();


            $categorias_lsm = DB::connection('tickets')->table('tickets')->select('categoria', \DB::raw('COUNT(*) as conteo'))
            ->where('empresa', 'Workplay')
            ->groupBy('categoria')
            ->orderByDesc('conteo')
            ->limit(5)
            ->get();
 
            
            $categorias_all = DB::connection('tickets')->table('tickets')->select('categoria', \DB::raw('COUNT(*) as conteo'))
            ->where('empresa', 'Workplay')
            ->groupBy('categoria')
            ->orderByDesc('conteo')
            ->get();


            $status = (object) [
               
                'atendidos' => DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('estatus', 'Atendido')->whereBetween('created_at', [$inicio, $fin])->count(),
                'no_atendidos' => DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('estatus', 'No atendido')->whereBetween('created_at', [$inicio, $fin])->count(),
                'en_proceso_lsm' => DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
            ];
            return view('dashboard.tickets.WorkPlay.workplay', compact('status', 'sucursales_lsm', 'categorias_lsm', 'resultados_lsm', 'categorias_all', 'areas_lsm', 'sucursales_lsm_all','distritos'));
        }elseif (auth()->user()->id_usuario == 501){

            
            $status = (object) [
               
                'atendidos' => DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('distrito', 'SURESTE')->where('estatus', 'Atendido')->whereBetween('created_at', [$inicio, $fin])->count(),
                'no_atendidos' => DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('distrito', 'SURESTE')->where('estatus', 'No atendido')->whereBetween('created_at', [$inicio, $fin])->count(),
                'en_proceso_lsm' => DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('distrito', 'SURESTE')->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
            ];

            
            $sucursales_lsm = DB::connection('tickets')->table('tickets')->select('sucursal', \DB::raw('COUNT(*) as conteo'))
            ->where('empresa', 'Workplay')
            ->where('distrito', 'SURESTE')
            ->groupBy('sucursal')
            ->orderByDesc('conteo')
            ->limit(5)
            ->get();

            $categorias_lsm = DB::connection('tickets')->table('tickets')->select('categoria', \DB::raw('COUNT(*) as conteo'))
            ->where('empresa', 'Workplay')
            ->where('distrito', 'SURESTE')
            ->groupBy('categoria')
            ->orderByDesc('conteo')
            ->limit(5)
            ->get();

            $resultados_lsm = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('distrito', 'SURESTE')->select('sucursal','id', DB::raw('TIMESTAMPDIFF(DAY, created_at, close_at) AS dias_transcurridos'))
            ->whereNotNull('close_at')
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('dias_transcurridos', 'desc')
            ->limit(10)
            ->get();


            $categorias_all = DB::connection('tickets')->table('tickets')->select('categoria', \DB::raw('COUNT(*) as conteo'))
            ->where('empresa', 'Workplay')
            ->where('distrito', 'SURESTE')
            ->groupBy('categoria')
            ->orderByDesc('conteo')
            ->get();


            $areas_lsm = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('distrito', 'SURESTE')->SelectRaw('substr(area,1,18) as area,COUNT(area) as totalareas')->whereBetween('created_at', [$inicio, $fin])->groupBy('area')->get();
            $sucursales_lsm_all = DB::connection('tickets')->table('tickets')->select('sucursal', \DB::raw('COUNT(*) as conteo'))
            ->where('empresa', 'Workplay')
            ->where('distrito', 'SURESTE')
            ->groupBy('sucursal')
            ->orderByDesc('conteo')
            ->get();

            return view('dashboard.tickets.WorkPlay.workplay_distrital', compact('status','sucursales_lsm','categorias_lsm','resultados_lsm','categorias_all','areas_lsm','sucursales_lsm_all'));
        }else{
            $tickets = Tickets::query()
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('id', 'DESC') 
            ->get();

            $status = (object) [
               
                'atendidos' =>  $tickets->where('estatus', 'Atendido')->whereBetween('created_at', [$inicio, $fin])->count(),
                'no_atendidos' =>  $tickets->where('estatus', 'No atendido')->whereBetween('created_at', [$inicio, $fin])->count(),
                'en_proceso_lsm' =>  $tickets->where('estatus', 'En proceso')->whereBetween('created_at', [$inicio, $fin])->count(),
            ];

            $sucursales_lsm = DB::connection('tickets')->table('tickets')->select('sucursal', \DB::raw('COUNT(*) as conteo'))
            ->where('sucursal', auth()->user()->sucursal->sucursal)
            ->groupBy('sucursal')
            ->orderByDesc('conteo')
            ->limit(10)
            ->get();

            
            $categorias_lsm = DB::connection('tickets')->table('tickets')->select('categoria', \DB::raw('COUNT(*) as conteo'))
            ->where('sucursal', auth()->user()->sucursal->sucursal)
            ->groupBy('categoria')
            ->orderByDesc('conteo')
            ->limit(5)
            ->get();

            $resultados_lsm = DB::connection('tickets')->table('tickets')->where('sucursal', auth()->user()->sucursal->sucursal)->select('sucursal','id', DB::raw('TIMESTAMPDIFF(DAY, created_at, close_at) AS dias_transcurridos'))
            ->whereNotNull('close_at')
            ->whereBetween('created_at', [$inicio, $fin])
            ->orderBy('dias_transcurridos', 'desc')
            ->limit(10)
            ->get();
            $categorias_all = DB::connection('tickets')->table('tickets')->select('categoria', \DB::raw('COUNT(*) as conteo'))
            ->where('sucursal', auth()->user()->sucursal->sucursal)
            ->groupBy('categoria')
            ->orderByDesc('conteo')
            ->get();
            $areas_lsm = DB::connection('tickets')->table('tickets')->where('sucursal', auth()->user()->sucursal->sucursal)->SelectRaw('substr(area,1,18) as area,COUNT(area) as totalareas')->whereBetween('created_at', [$inicio, $fin])->groupBy('area')->get();

            return view('dashboard.tickets.WorkPlay.workplay_sucursales', compact('status','sucursales_lsm','categorias_lsm','resultados_lsm','categorias_all','areas_lsm' ));
        }
           
    }

    
}
 