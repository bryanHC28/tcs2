<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Helpers\SweetAlert2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tickets;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Retorna la vista de inicio
     *
     * @return View dashboard.inicio
     */
    public function inicio()
    {
           
        return view('dashboard.inicio');
    }

    public function pdf(){

    $startDate = Carbon::now()->subWeek();
    $endDate = Carbon::now();
    $tickets = Tickets::get();

    $status = (object) [
        'abiertos'    => $tickets->where('estatus', 'Abierto')->where('created_at', '>=', $startDate)->where('created_at', '<=', $endDate),
        'cerrados'    => $tickets->where('estatus', 'Cerrado')->where('close_at', '>=', $startDate)->where('close_at', '<=', $endDate),
        'ejecutado'    => $tickets->where('estatus', 'Ejecutado')->where('fecha_tecnico', '>=', $startDate)->where('fecha_tecnico', '<=', $endDate),
        'vencidos'    => $tickets->where('estado', 'Vencido')->where('fecha_estimada', '>=', $startDate)->where('fecha_estimada', '<=', $endDate)

    ];


    $resultado = Tickets::select('estatus', DB::raw('COUNT(estatus) as conteo'))->where('close_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 1 WEEK)'))
    ->where('close_at', '<=', DB::raw('CURDATE()'))
    ->where('estatus', '=', 'Cerrado')
    ->groupBy('estatus')
    ->get();

    $Abierto = Tickets::select('estatus', DB::raw('COUNT(estatus) as conteo'))->where('created_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 1 WEEK)'))
    ->where('created_at', '<=', DB::raw('CURDATE()'))
    ->where('estatus', '=', 'Abierto')
    ->groupBy('estatus')
    ->get();

    $Ejecutado = Tickets::select('estatus', DB::raw('COUNT(estatus) as conteo'))->where('fecha_tecnico', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 1 WEEK)'))
    ->where('fecha_tecnico', '<=', DB::raw('CURDATE()'))
    ->where('estatus', '=', 'Ejecutado')
    ->groupBy('estatus')
    ->get();

    $vencidos = Tickets::select('estado', DB::raw('COUNT(estado) as conteo'))->where('fecha_estimada', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 1 WEEK)'))
    ->where('fecha_estimada', '<=', DB::raw('CURDATE()'))
    ->where('estado', '=', 'Vencido')
    ->groupBy('estado')
    ->get();


    $fechaActual = date('Y-m-d');
    $pdf= \PDF::loadView('tickets.pdf',compact('fechaActual','status','resultado','Abierto','Ejecutado','vencidos'));

    $data["title"] = "Reporte semanal de ".auth()->user()->sucursal->sucursal;

    if(auth()->user()->id_sucursal==200){
    $correo="Rociosalazar@proyectos9.com";
    }elseif(auth()->user()->id_sucursal==201){
    $correo="eliasquinones@proyectos9.com";
    }
    $datas=[];
    $correo2="Joaquinsanchez@proyectos9.com";

     Mail::send('tickets.reporte_proy9', $datas ,function ($message) use ($data,$pdf,$correo) {
         $message->from('soporte@empresavirtual.mx')->to($correo)
             ->subject($data["title"])
             ->attachData($pdf->output(), "reporte.pdf");
     });

     Mail::send('tickets.reporte_proy9', $datas ,function ($message) use ($data,$pdf,$correo2) {
        $message->from('soporte@empresavirtual.mx')->to($correo2)
            ->subject($data["title"])
            ->attachData($pdf->output(), "reporte.pdf");
    });

    return $pdf->stream();



    }

    public function pdf_lsm(Request $request)
	{
	   
        $status = isset($request->status) ? $miArray3 = explode(',', $request->status) : ['En procceso','No atendido','Atendido'];
        $sucursal = isset($request->sucursal) ? $miArray4 = explode(',', $request->sucursal) : ['AGO','AGS','ALT','CIB','DOR','GUA','MOR','TLA','ZAC','ARA','ATI','BUE','CAR','COS','CUL','ECA','INT','MUE','REF','SER','TEP','ANT','COA','INS','MAD','MET','OAS','PAC','PAT','PLV','PSA','TEZ','TOL','CFM','CUM','DUR','GVO','LAG','SAL','SFD','TAM','AFM','TAB','CAN','PDC','CTZ','MER','OFI','HCAR','HAGS','HCAN','HGVO'];
        $categoria = isset($request->categoria) ? $miArray4 = explode(',', $request->categoria):['Otros','Implementación de display','Cambio de artes en pantalla de exhibición','Cambio de precios','Falta de exhibición','Problema de alarmado','Baterias infladas','Robo de accesorios / partes equipo de exhibición','Daño a equipo en exhibición','Robo de equipos de exhibición','Pinturas y acabados','Incidencias','Punto de venta','Impresoras y escaners','Laptop','Plomería y fugas','Otras','Electricidad','Plomería','Aire acondicionado','Cortina','Audio','Detección de humo','Cámaras','Telefonía e internet','Electroimanes','Pantallas','Alarmado y seguridad','Mobiliarios','Pisos, muros y plafones','Puertas y cerraduras','Equipos de cómputo','Plagas','Señalización','Letreros luminosos']; 
        $area = isset($request->area) ? $miArray = explode(',', $request->area) : ['Evidencias','Display','GM3','Seguridad','Cuarto Custumer Service','Piso de venta','Patio de venta','Áreas comunes','Site','Bodega','Laboratorío','Bodega Costumer Service','Fachada','Pasillo de servicio','Computo y sistemas'];
        $prioridad = isset($request->prioridad) ? $miArray2 = explode(',', $request->prioridad) : ['Alta', 'Media', 'Baja', ''];

        
 
        $resultado = DB::table('tickets.tickets')
        ->where('tickets.empresa','=','Workplay')
        ->whereIn('tickets.estatus', $status)
        ->whereIn('tickets.sucursal', $sucursal)
        ->whereIn('tickets.categoria', $categoria)
        ->whereIn('tickets.area', $area)
        ->where(function ($query) use ($prioridad) {
            if (count($prioridad)==4) {
                $query->whereIn('tickets.prioridad', ['Alta', 'Media', 'Baja'])
                    ->orWhereNull('tickets.prioridad');
                
            } else {
                $query->whereIn('tickets.prioridad', $prioridad);
            }
        })
        ->get();
        $pdf= \PDF::loadView('tickets.pdf_lsm',compact('resultado'));
        return $pdf->stream('workplay.pdf');
		
		
		
	
    }
}
