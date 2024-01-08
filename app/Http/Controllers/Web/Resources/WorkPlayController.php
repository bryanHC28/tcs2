<?php

namespace App\Http\Controllers\Web\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Areas, TCSSubcategorias, TCSCategorias, Tickets, TBSucursal, TCSSubareas};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{DB, Mail, Storage};
use App\Mail\{RespMail};
use App\Helpers;
class WorkPlayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
      
        $self = new self;
        $request->validate([
            'sucursal' => ['required', 'integer', 'exists:EV_SUMAPP.tb_sucursal,id_sucursal'],
            'ticket_sumapp' => ['nullable', 'string'],
            'area' => ['required', 'integer', 'exists:tickets.areas,id'],
            'categoria' => ['nullable', 'integer', 'exists:tickets.tcs_categorias,id'],
            'fecha' => ['nullable', 'date'],
            'ticket_descripcion' => ['nullable', 'string'],
        ]);
        $tb_sucursal = TBSucursal::where('id_sucursal', $request->sucursal)->first();
        $area = (Areas::where('id', $request->area)->first())->area_descripcion;
        if (isset($request->categoria)) {
            $tcs_categoria = (TCSCategorias::where('id', $request->categoria)->first())->categoria_descripcion;
        }
        $fotos = [];
        
        $carpeta = auth()->user()->app->carpeta;
        for ($i = 0; $i < 2; $i++) {

            if ($request->hasFile('evidencia' . $i)) {

                $evidencia = $request->file('evidencia' . $i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia' . $i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta . '/' . $iden, file_get_contents($evidencia));
                array_push($fotos, $iden);
            }
        }

        $crear_ticket = Tickets::create([
            'empresa' => $tb_sucursal->tb_empresa->c_nombre_empresa,
            'sucursal' => $tb_sucursal->sucursal,
            'usuario' => auth()->user()->nombre . ' ' . auth()->user()->apellido,
            'area' => $area,
            'categoria' => $tcs_categoria,
            'prioridad' => $request->prioridad ?? null,
            'ticket_descripcion' => $request->ticket_descripcion,
            'ticket_sumapp' => $request->ticket_sumapp ?? null,
            'fecha' => $request->fecha,
            'estatus' => 'No atendido',
            'distrito' => $tb_sucursal->distrito,
            'evidencia_inicial_multiple' => json_encode($fotos) ?? null,
        ]);

 


        Mail::to('bhilario@empresavirtual.mx')->queue(new RespMail($crear_ticket->id, $crear_ticket->id));

        return back()->with(Helpers\SweetAlert2::success("El ticket ha sido registrado con folio #{$crear_ticket->id}"));
        
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
    public function filtro(Request $request)
    {
        $estatus = $request->Estatus;
         
        return view('dashboard.tickets.WorkPlay.index', compact('estatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $ticket = DB::connection('tickets')->table('tickets')->where('empresa', 'WorkPlay')->where('id', $id)->first();
        $arrayPHP = json_decode($ticket->evidencia_inicial_multiple);
        $array_final = json_decode($ticket->evidencia_final_multiple);
        $array_proceso = json_decode($ticket->evidencia_proceso_multiple);


         
        return view('dashboard.tickets.WorkPlay.edit', compact('ticket', 'arrayPHP', 'array_final', 'array_proceso'));

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


 
     
        $ticket = DB::connection('tickets')->table('tickets')->where('id', $id);
        if (isset($request->area)) {
        $area = (Areas::where('id', $request->area)->first())->area_descripcion;
        }
        if (isset($request->categoria)) {
            $tcs_categoria = (TCSCategorias::where('id', $request->categoria)->first())->categoria_descripcion;
        }
  

        if($request->estatus == 'En proceso')
        {
             
            $ticket->update([
           'estatus' => $request->estatus,
           'prioridad' => $request->prioridad,
           'ticket_descripcion' => $request->ticket_descripcion,
           'ticket_sumapp' => $request->ticket_sumapp,
           'area'=> $area ?? 'No aplica',
           'categoria'=> $tcs_categoria ?? 'No aplica',
           'fecha_tecnico' => date('Y-m-d H:i:s')

       ]);

        } elseif($request->estatus == 'Atendido'){
            $tcs_lsm= $ticket->first();
        
            if(!empty($request->evidencia_final0)  || !empty($request->evidencia_final1) || !empty($tcs_lsm->evidencia_final_multiple)   ){
            $ticket->update([
                'estatus' => $request->estatus,
                'prioridad' => $request->prioridad,
                'ticket_descripcion' => $request->ticket_descripcion,
                'ticket_sumapp' => $request->ticket_sumapp,
                'area'=> $area ?? 'No aplica',
                'categoria'=> $tcs_categoria ?? 'No aplica',
                'close_at' => date('Y-m-d H:i:s')
     
            ]);
        }else{
    
            return back()->with(Helpers\SweetAlert2::error("El ticket tiene que tener evidencias finales para poder pasar Atendido"));
        }

      




    
        }else{

            $ticket->update([
                'estatus' => $request->estatus,
                'prioridad' => $request->prioridad,
                'ticket_descripcion' => $request->ticket_descripcion,
                'ticket_sumapp' => $request->ticket_sumapp,
                'area'=> $area ?? 'No aplica',
                'categoria'=> $tcs_categoria ?? 'No aplica'
            ]);
        }
         
        $fotos = [];
        $carpeta = auth()->user()->app->carpeta;


        for ($i = 0; $i < 2; $i++) {

            if ($request->hasFile('evidencia' . $i)) {

                $evidencia = $request->file('evidencia' . $i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia' . $i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta . '/' . $iden, file_get_contents($evidencia));

                array_push($fotos, $iden);


                $ticket->update([
                    'evidencia_inicial_multiple' => json_encode($fotos) ?? null

                ]);
            }
        }


        $fotos1 = [];


        for ($i = 0; $i < 2; $i++) {

            if ($request->hasFile('evidencia_proceso' . $i)) {


                $evidencia = $request->file('evidencia_proceso' . $i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia_proceso' . $i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta . '/' . $iden, file_get_contents($evidencia));

                array_push($fotos1, $iden);



                $ticket->update([
                    'evidencia_proceso_multiple' => json_encode($fotos1) ?? null

                ]);

            }
        }






        $fotos2 = [];


        for ($i = 0; $i < 2; $i++) {

            if ($request->hasFile('evidencia_final' . $i)) {



                $evidencia = $request->file('evidencia_final' . $i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia_final' . $i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta . '/' . $iden, file_get_contents($evidencia));

                array_push($fotos2, $iden);



                $ticket->update([
                    'evidencia_final_multiple' => json_encode($fotos2) ?? null

                ]);

            }
        }

        return redirect()->route('web.dashboard.tickets.index')->with(Helpers\SweetAlert2::success("Se actualizó el ticket"));
    }



    public function update_fotos(Request $request, $id){

     
        $ticket = DB::connection('tickets')->table('tickets')->where('id', $id);
        $carpeta = auth()->user()->app->carpeta;
        $fotos1 = [];


        for ($i = 0; $i < 2; $i++) {

            if ($request->hasFile('evidencia_proceso' . $i)) {


                $evidencia = $request->file('evidencia_proceso' . $i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia_proceso' . $i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta . '/' . $iden, file_get_contents($evidencia));

                array_push($fotos1, $iden);



                $ticket->update([
                    'evidencia_proceso_multiple' => json_encode($fotos1) ?? null,
                    'estatus' => "En proceso",
                    'comentario_cliente'=> $request->myText
                ]);

            }
        }


        $fotos2 = [];


        for ($i = 0; $i < 2; $i++) {

            if ($request->hasFile('evidencia_final' . $i)) {



                $evidencia = $request->file('evidencia_final' . $i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia_final' . $i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta . '/' . $iden, file_get_contents($evidencia));

                array_push($fotos2, $iden);



                $ticket->update([
                    'evidencia_final_multiple' => json_encode($fotos2) ?? null,
                    'estatus' => "Atendido",
                    'comentario_cliente'=> $request->myText
                ]);

            }
        }



        if(!empty($request->myText)){
            
            $ticket->update([
            'comentario_cliente'=> $request->myText
        ]);
        }
        
        if(!empty($request->evidencia_final0) || !empty($request->evidencia_final1)){
        $tcs_lsm = $ticket->first();    
        $destinatario = 'miguel@workplay.mx'; // Valor predeterminado
        switch ($tcs_lsm->area) {
            case "GM3":
            case "Display":
            case "Evidencias":
                $destinatario = 'anapatricia@workplay.mx';
                break;
        }
        
        Mail::to($destinatario)->queue(new RespMail($id, $id));
           
        }
        








        return redirect()->route('web.dashboard.tickets.index')->with(Helpers\SweetAlert2::success("Evidencias agregadas con exito"));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $ticket = DB::connection('tickets')->table('tickets')->find($id);

        if ($ticket) {
            // El ticket se encontró, puedes proceder con la eliminación
            DB::connection('tickets')->table('tickets')->where('id', $id)->delete();
            return response()->json(['message' => 'Ticket eliminado correctamente']);
        } else {
            // El ticket no se encontró
            return response()->json(['message' => 'Ticket no encontrado'], 404);
        }
  
    }

    public function update_ajax_lsm(Request $request){
        $ticket = DB::connection('tickets')->table('tickets')->where('id', $request->folio);
        if( $request->edo == 'En proceso'){
            $ticket->update([  'estatus' => $request->edo,'prioridad' => $request->prority, 'ticket_descripcion' => $request->descripcion,'ticket_sumapp' => $request->cps,'fecha_tecnico' => date('Y-m-d H:i:s')]);
            }elseif($request->edo == 'Atendido'){
                $tcs_lsm= $ticket->first();
                if (!empty($tcs_lsm->evidencia_final_multiple)) {
                    $ticket->update(['estatus' => $request->edo,'prioridad' => $request->prority, 'ticket_descripcion' => $request->descripcion,'ticket_sumapp' => $request->cps,  'close_at' => date('Y-m-d H:i:s')]);
                } else {
                    return response()->json(['error' => "Ocurrio un error"]);
                }
            }else{
            $ticket->update(['estatus' => $request->edo,'prioridad' => $request->prority, 'ticket_descripcion' => $request->descripcion,'ticket_sumapp' => $request->cps]);
        }



        if ($request->edo == "Abierto") {
            $estado = '<span class="badge badge-pill badge-primary">Abierto</span>';
        } elseif ($request->edo == "En proceso") {
            $estado = '<span class="badge badge-pill badge-warning">En proceso</span>';
        } elseif ($request->edo == "No atendido") {
            $estado = '<span class="badge badge-pill badge-dark">No atendido</span>';
        } elseif ($request->edo == "Atendido") {
            $estado = '<span class="badge badge-pill badge-success">Atendido</span>';
        } else {
            $estado = '<span class="badge badge-pill badge-danger">Sin regitro</span>';
        }



        if(!empty($request->prority)){
            if ($request->prority == "Alta") {
                $prioridad = '<span class="badge badge-pill badge-danger">Alta</span>';
            } elseif ($request->prority == "Media") {
                $prioridad = '<span class="badge badge-pill badge-warning">Media</span>';
            } elseif ($request->prority == "Baja") {
                $prioridad = '<span class="badge badge-pill badge-success">Baja</span>';
            }}else{
                $prioridad = '<span class="badge badge-pill badge-dark">Sin registro</span>';
            }




            if(!empty($request->descripcion)){
                $descripcion = '<span class="badge badge-pill badge-success">'.$request->descripcion.'</span>';
 
            }else{
                $descripcion = '<span class="badge badge-pill badge-dark">Sin registro</span>';
            }



            if(!empty($request->cps)){
                $cps = '<span class="badge badge-pill badge-success">'.$request->cps.'</span>';
 
            }else{
                $cps = '<span class="badge badge-pill badge-dark">Sin registro</span>';
            }
        


            return response()->json(['estado' => $estado, 'prioridad' => $prioridad, 'descripcion' => $descripcion, 'cps' => $cps]);
    
    }
}
