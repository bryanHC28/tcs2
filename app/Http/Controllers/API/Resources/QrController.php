<?php

namespace App\Http\Controllers\API\Resources;

use App\Http\Controllers\Controller;
use App\Models\{Areas, Controlcorreo, Correo, TBEmpresa, TBInventario, TCSSubcategorias, TBUsuario, TCSCategorias, Tickets, TBSucursal, TCSSubareas};
use Illuminate\Support\Facades\DB;
use App\Mail\cron;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class QrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($var)
    {
        $sucursales = TBSucursal::where('id_empresa',$var)->get();
        return view('QR.ticket')->with('sucursales',$sucursales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


public function mails(){



$correos= TBUsuario::select('tb_usuario.correo','tickets.id')
           ->join('tickets.tickets','tb_usuario.complete_name','=','tickets.usuario')
           ->where('tickets.empresa','Pilotchemical')
           ->where('tickets.estatus','Cerrado')
           ->where('tickets.estado',null)
           ->get();


           foreach($correos as $correo){


            Mail::to($correo->correo)->queue(new cron($correo->id));
            Mail::to('bryaaan99@gmail.com')->queue(new cron($correo->id));

            echo 'correo enviado a:'.$correo->correo.'con exito';



           }

           return 'listo';




}

	 public function tickets_pilot(){

        $ticket = Tickets::query()
        ->where('empresa', 'Pilotchemical')
		->orderBy('id','ASC')
        ->get();

        $ticket = $ticket->map(function($item){
            return [
                'id' => $item->id,
                'empresa' => $item->empresa,
                'usuario' => $item->usuario,
                'area' => $item->area,
                'ticket_descripcion' => $item->ticket_descripcion,
                'observaciones' => $item->observaciones,
                'estatus' => $item->estatus,
                'fecha_estimada' => $item->fecha_estimada,
                'categoria' => $item->categoria,
                'prioridad' => $item->prioridad,
                'tipo_ticket' => $item->tipo_ticket,
                'inventario' => $item->inventario,
                'realizo' => $item->realizo,
				'estado'=> $item->estado,
				'created_at'=> $item->created_at,
				'fecha_estimada'=> $item->fecha_estimada,
				'close_at'=> $item->close_at

            ];
        });


        return response()->json($ticket);


    }

    public function cron(){

$cron = new Tickets();
return $cron->cron();
    }





    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
