<?php

namespace App\Http\Controllers\Web\Resources;

use App\Http\Controllers\Controller;
use App\Models\{Areas, Controlcorreo, Correo, TBEmpresa, TBInventario, TCSSubcategorias, TBUsuario, TCSCategorias, Tickets, TBSucursal, TCSSubareas};
use Illuminate\Http\Request;
use App\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\{DB, File, Mail, Storage};

class FotosController extends Controller
{

 


    public function imagenes(Request $request)
    {

        if(auth()->user()->id_empresa==44){
            $ticket  = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('id',$request->id)->first();;
            
            
        }else{
        $ticket = Tickets::query()
            ->where('id', $request->id)
            ->firstOrFail();
        }
        $carpeta = auth()->user()->app->carpeta;

        $arrayPHP = json_decode($ticket->evidencia_inicial_multiple);


        if (!empty($arrayPHP)) {

            if (count($arrayPHP) > 1) {

                $foto1 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $arrayPHP[0] . '">
        <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $arrayPHP[0] . '" /></a></div>';

                $foto2 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $arrayPHP[1] . '">
        <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $arrayPHP[1] . '" /></a></div>';

                return response()->json(['foto1' => $foto1, 'foto2' => $foto2]);
            } elseif (count($arrayPHP) == 0) {
                $foto1 = '<h5>[Sin evidencia]</h5>';
                $foto2 = '<h5>[Sin evidencia]</h5>';
                return response()->json(['foto1' => $foto1, 'foto2' => $foto2]);
            } else


                $foto1 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $arrayPHP[0] . '">
    <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $arrayPHP[0] . '" /></a></div>';

            return response()->json(['foto1' => $foto1]);
        } else {
            $foto1 = '<h5>[Sin evidencia]</h5>';

            $foto2 = '<h5>[Sin evidencia]</h5>';

            return response()->json(['foto1' => $foto1, 'foto2' => $foto2]);
        }
    }
    public function imagenes_finales(Request $request)
    { 
        
        if(auth()->user()->id_empresa==44){
        $ticket  = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('id',$request->id)->first();
        
        

    }else{
        $ticket = Tickets::query()
            ->where('id', $request->id)
            ->firstOrFail();

        }
        $carpeta = auth()->user()->app->carpeta;
        $array_final = json_decode($ticket->evidencia_final_multiple);
        $comentario= $ticket->comentario_cliente ?? ' ';


        if (!empty($array_final)) {
            if (count($array_final) > 1) {

                $foto1 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_final[0] . '">
        <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_final[0] . '" /></a></div>';

                $foto2 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_final[1] . '">
        <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_final[1] . '" /></a></div>';

                return response()->json(['foto1' => $foto1, 'foto2' => $foto2]);
            } elseif (count($array_final) == 0) {

                $foto1 = '<h5>[Sin evidencia]</h5>';

                $foto2 = '<h5>[Sin evidencia]</h5>';

                return response()->json(['foto1' => $foto1, 'foto2' => $foto2]);
            } else


                $foto1 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_final[0] . '">
    <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_final[0] . '" /></a></div>';

            return response()->json(['foto1' => $foto1]);
        } else {
            $foto1 = '<h5>[Sin evidencia]</h5>';

            $foto2 = '<h5>[Sin evidencia]</h5>';

            return response()->json(['foto1' => $foto1, 'foto2' => $foto2,'comentario' => $comentario]);
        }
    }

    public function imagenes_proceso(Request $request)
    {

        if(auth()->user()->id_empresa==4){
            $ticket  = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('id',$request->id)->first();
            
        }else{
        $ticket = Tickets::query()
            ->where('id', $request->id)
            ->firstOrFail();
        }
        $carpeta = auth()->user()->app->carpeta;
        $array_proceso = json_decode($ticket->evidencia_proceso_multiple);


        if (!empty($array_proceso)) {
            if (count($array_proceso) > 1) {

                $foto1 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_proceso[0] . '">
        <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_proceso[0] . '" /></a></div>';

                $foto2 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_proceso[1] . '">
        <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_proceso[1] . '" /></a></div>';

                return response()->json(['foto1' => $foto1, 'foto2' => $foto2]);
            } elseif (count($array_proceso) == 0) {

                $foto1 = '<h5>[Sin evidencia]</h5>';

                $foto2 = '<h5>[Sin evidencia]</h5>';

                return response()->json(['foto1' => $foto1, 'foto2' => $foto2]);
            } else


                $foto1 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_proceso[0] . '">
    <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $array_proceso[0] . '" /></a></div>';

            return response()->json(['foto1' => $foto1]);
        } else {
            $foto1 = '<h5>[Sin evidencia]</h5>';

            $foto2 = '<h5>[Sin evidencia]</h5>';

            return response()->json(['foto1' => $foto1, 'foto2' => $foto2]);
        }
    }


    public function firmas(Request $request)
    {

        if(auth()->user()->id_empresa==40){
            $ticket  = DB::connection('tickets')->table('tickets')->where('empresa', 'EMS Soluciones')->where('id',$request->id)->first();
            
        }else{
        $ticket = Tickets::query()
            ->where('id', $request->id)
            ->firstOrFail();
        }
        $carpeta = auth()->user()->app->carpeta;
        
        if (!empty($ticket->efirma)) {
        
                $foto1 = '<div id="lightgallery"><a href="https://fotostickets.sumapp.cloud/' . $carpeta . '/' .$ticket->efirma . '">
        <img  width="200" height="200" src="https://fotostickets.sumapp.cloud/' . $carpeta . '/' . $ticket->efirma . '" /></a></div>';
                return response()->json(['foto1' => $foto1 ]);
            } else  {

                $foto1 = '<h5>[Sin firma]</h5>';
                return response()->json(['foto1' => $foto1 ]);
            } 
            
       
    }


    public function edit_ajax($id)
    {


        if(auth()->user()->id_empresa==44){
            $tcs  = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('id',$id)->first();
            
        }else
        $tcs = Tickets::findOrFail($id);

        return response()->json([$tcs]);
    }
    public function datatable($id)
    {

        if ($id == "inicial") {



            if (auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314) {
                $tickets = DB::connection('tickets')->table('tickets')->where('empresa', 'DemoProyectos9')->orderBy('id', 'DESC')->get();
            }else if(auth()->user()->id_usuario == 496 ||  auth()->user()->id_usuario == 497 || auth()->user()->id_usuario == 433 || auth()->user()->id_usuario == 495){


                $tickets = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->orderBy('id', 'DESC')->get();
            }else if(auth()->user()->id_usuario == 501){

                $tickets = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->where('distrito', 'SURESTE')->orderBy('id', 'DESC')->get();
            
            }else if(auth()->user()->id_usuario == 502 || auth()->user()->id_usuario == 503 || auth()->user()->id_usuario == 504){
                $tickets = DB::connection('tickets')->table('tickets')->where('empresa', 'Workplay')->orderBy('id', 'DESC')->get();
            
            }else {
                $tickets = Tickets::query()
                    ->orderBy('id', 'DESC')
                    ->get();
            }
        }elseif ($id == "orden" && auth()->user()->id_usuario == 315) {
            $tickets = DB::connection('tickets')->table('tickets')
            ->where('fecha_estimada', '>=', Carbon::now()->toDateString())
            ->where('prioridad', 'Alta')
            ->where('empresa', 'DemoProyectos9')
            ->where('estatus', 'Abierto')
            ->get();

        }
        elseif ($id == "orden" && auth()->user()->id_usuario == 314) {

            $tickets = DB::connection('tickets')->table('tickets')
            ->where('fecha_estimada', '>=', Carbon::now()->toDateString())
            ->where('prioridad', 'Alta')
            ->where('empresa', 'DemoProyectos9')
            ->where('estatus', 'Abierto')
            ->get();

            }
            elseif ($id == "vencio" && auth()->user()->id_usuario == 315) {

                $tickets = DB::connection('tickets')->table('tickets')
                ->where('fecha_estimada', '>=', Carbon::now()->subDays(8))->where('fecha_estimada', '<', Carbon::now())
                ->where('estado', 'Vencido')
                ->where('empresa', 'DemoProyectos9')
                ->get();

                }
            elseif ($id == "vencio" && auth()->user()->id_usuario == 314) {

                $tickets = DB::connection('tickets')->table('tickets')
                ->where('fecha_estimada', '>=', Carbon::now()->subDays(8))->where('fecha_estimada', '<', Carbon::now())
                ->where('estado', 'Vencido')
                ->where('empresa', 'DemoProyectos9')
                ->get();

                }


                elseif ($id == "ejecucion" && auth()->user()->id_usuario == 315) {

                    $tickets = DB::connection('tickets')->table('tickets')
                    ->where('fecha_tecnico', '>=', Carbon::now()->subDays(8))
                    ->where('fecha_tecnico', '<', Carbon::now())
                    ->where('estatus', 'Ejecutado')
                    ->where('empresa', 'DemoProyectos9')
                    ->get();

                    }
                elseif ($id == "ejecucion" && auth()->user()->id_usuario == 314) {

                    $tickets = DB::connection('tickets')->table('tickets')
                    ->where('fecha_tecnico', '>=', Carbon::now()->subDays(8))
                    ->where('fecha_tecnico', '<', Carbon::now())
                    ->where('estatus', 'Ejecutado')
                    ->where('empresa', 'DemoProyectos9')
                    ->get();

                    }


        elseif ($id == "orden") {
            $tickets = Tickets::whereDate('fecha_estimada', '>=', now()->toDateString())->where('estatus', 'Abierto')->where('prioridad', 'Alta')->get();
        }
        elseif ($id == "vencio") {
            $tickets = Tickets::where('fecha_estimada', '>=', Carbon::now()->subDays(8))->where('fecha_estimada', '<', Carbon::now())
            ->where('estado', 'Vencido')
            ->get();
        }
        elseif ($id == "ejecucion") {
            $tickets = Tickets::where('fecha_tecnico', '>=', Carbon::now()->subDays(8))
            ->where('fecha_tecnico', '<', Carbon::now())
            ->where('estatus', 'Ejecutado')
            ->get();
        }


        //  'DT_RowId'=>$idDelRegistro


        return response()->json($tickets);
    }


 


    public function update_ajax(Request $request)
    {


        $ticket = Tickets::where('id', $request->folio)->first();
        if ($request->edo == 'Cierre final') {
            if (!empty($ticket->fecha_tecnico)) {
                Tickets::findOrFail($request->folio)->update(['estatus' => $request->edo,'fecha_cita' => $request->fecha_cita2 , 'fecha_comienzo' => $request->fecha_comienzo2,'realizo' => $request->realizo2, 'prioridad' => $request->prority, 'tipo_ticket' => $request->type_tct, 'close_at' => date('Y-m-d H:i:s')]);
            } else {
                return response()->json(['error2' => "Ocurrio un error pilot"]);
            }
        } elseif (auth()->user()->id_empresa == 27 && $request->edo == 'Cerrado') {

            Tickets::findOrFail($request->folio)->update(['estatus' => $request->edo,'fecha_cita' => $request->fecha_cita2, 'fecha_comienzo' => $request->fecha_comienzo2, 'realizo' => $request->realizo2, 'prioridad' => $request->prority, 'tipo_ticket' => $request->type_tct, 'fecha_tecnico' => date('Y-m-d H:i:s')]);
        } elseif (auth()->user()->id_empresa == 33 && $request->edo == 'Ejecutado' ) {

            Tickets::findOrFail($request->folio)->update(['estatus' => $request->edo,'fecha_cita' => $request->fecha_cita2, 'fecha_comienzo' => $request->fecha_comienzo2,'realizo' => $request->realizo2, 'prioridad' => $request->prority, 'tipo_ticket' => $request->type_tct, 'fecha_tecnico' => date('Y-m-d H:i:s')]);
        } elseif (auth()->user()->id_empresa == 33 && $request->edo == 'Cerrado') {

            if (!empty($ticket->fecha_tecnico)) {
                Tickets::findOrFail($request->folio)->update(['estatus' => $request->edo,'fecha_comienzo' => $request->fecha_comienzo2,'fecha_cita' => $request->fecha_cita2, 'realizo' => $request->realizo2, 'prioridad' => $request->prority, 'tipo_ticket' => $request->type_tct, 'close_at' => date('Y-m-d H:i:s')]);
            } else {
                return response()->json(['error' => "Ocurrio un error"]);
            }
        }

        else {
            Tickets::findOrFail($request->folio)->update(['estatus' => $request->edo,'fecha_comienzo' => $request->fecha_comienzo2,'fecha_cita' => $request->fecha_cita2, 'realizo' => $request->realizo2, 'prioridad' => $request->prority, 'tipo_ticket' => $request->type_tct]);
        }



     if(!empty($request->fecha_cita2)){

        $cita='<span class="badge badge-pill badge-success">'.$request->fecha_cita2.'</span>';
    }else{
        $cita='<span class="badge badge-pill badge-danger">Sin registro</span>';
    }

    if(!empty($request->realizo2)){

        $realizo='<span class="badge badge-pill badge-success">'.$request->realizo2.'</span>';
    }else{
        $realizo='<span class="badge badge-pill badge-danger">Sin registro</span>';
    }


        if ($request->edo == "Cerrado") {
            $columna = '<span class="badge badge-pill badge-success">Cerrado</span>';
        } elseif ($request->edo == "Ejecutado") {
            $columna = '<span class="badge badge-pill badge-secondary">Ejecutado</span>';
        } elseif ($request->edo == "Abierto") {
            $columna = '<span class="badge badge-pill badge-primary">Abierto</span>';
        } elseif ($request->edo == "Cancelado") {
            $columna = '<span class="badge badge-pill badge-dark">Cancelado</span>';
        } elseif ($request->edo == "Cierre final") {
            $columna = '<span class="badge badge-pill badge-secondary">Cierre final</span>';
        } elseif ($request->edo == "En proceso") {
            $columna = '<span class="badge badge-pill badge-warning">En proceso</span>';
        } elseif ($request->edo == "Validado") {
            $columna = '<span class="badge badge-pill badge-info">Validado</span>';
        }
        elseif ($request->edo == "Suspendido") {
            $columna = '<span class="badge badge-pill badge-dark">Suspendido</span>';
        } else {
            $columna = '<span class="badge badge-pill badge-danger">Sin regitro</span>';
        }
        if ($request->prority == "Alta") {
            $prioridad = '<span class="badge badge-pill badge-danger">Alta</span>';
        } elseif ($request->prority == "Media") {
            $prioridad = '<span class="badge badge-pill badge-warning">Media</span>';
        } elseif ($request->prority == "Baja") {
            $prioridad = '<span class="badge badge-pill badge-success">Baja</span>';
        }

        if ($request->type_tct == "Preventivo") {
            $tipo_ticket = 'Preventivo';
        } elseif ($request->type_tct == "Correctivo") {
            $tipo_ticket = '<span class="badge badge-pill badge-danger">Correctivo</span>';
        } elseif ($request->type_tct == "Modificaciones") {
            $tipo_ticket = '<span class="badge badge-pill badge-dark">Modificaciones</span>';
        } elseif ($request->type_tct == "Preventivo") {
            $tipo_ticket = '<span class="badge badge-pill badge-info">Preventivo</span>';
        } elseif ($request->type_tct == "Mejora continua") {
            $tipo_ticket = '<span class="badge badge-pill badge-success">Mejora continua</span>';
        } elseif ($request->type_tct == "Rutinario") {
            $tipo_ticket = '<span class="badge badge-pill badge-warning">Rutinario</span>';
        }


        if (auth()->user()->id_empresa != 10) {
            return response()->json(['var' => $columna, 'prioridad' => $prioridad, 'tipo_tcs' => $tipo_ticket,'cita'=>$cita,'realizo'=>$realizo]);
        } else

            return response()->json(['var' => $columna, 'prioridad' => $prioridad]);
    }
}
