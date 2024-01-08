<?php

namespace App\Http\Controllers\Web\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Areas, TCSSubcategorias, TCSCategorias, TBSucursal,Tickets,TCSSubareas,TBUsuario};
use Illuminate\Support\Str;
use App\Helpers;
use Illuminate\Support\Facades\{DB, File, Mail, Storage};
use App\Mail\{ MonalisaMail,MonalisaReasignacionMail,EstatusMail,ComentarioMail };

class Tcs_Monalisa_Controller extends Controller
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

    public function remember( ){

        $ticket=Tickets::where('estatus','Abierto')->get();
        foreach($ticket as $tcs){
            echo '<br>';
            echo($tcs->id);
            Mail::to('bhilario@empresavirtual.mx')->queue(new MonalisaMail($tcs->id, $tcs->id));
            Mail::to('sistemas@sunsetmonalisa.com')->queue(new MonalisaMail($tcs->id, $tcs->id));
            Mail::to('mantenimiento@sunsetmonalisa.com')->queue(new MonalisaMail($tcs->id, $tcs->id));    
        }
        return true;
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $self = new Self;
        $request->validate([
            'sucursal'          => ['required', 'integer', 'exists:EV_SUMAPP.tb_sucursal,id_sucursal'],
            'area'              => ['required', 'integer', 'exists:tickets.areas,id'],
            'subarea'      => ['nullable', 'integer', 'exists:tickets.subareas,id'],
            'categoria'         => ['nullable', 'integer', 'exists:tickets.tcs_categorias,id'],
            'subcategoria'      => ['nullable', 'integer', 'exists:tickets.tcs_subcategorias,id'],
            'inventario'        => ['nullable', 'string'],
            'transmitio'        => ['nullable', 'string'],
            'cuarto'            => ['nullable', 'string'],
            'accion_a_realizar' => ['nullable', 'string'],
            'descripcion'       => ['nullable', 'string'],
            'observaciones'     => ['nullable', 'string'],
            'costo_estimado'    => ['nullable', 'numeric'],
            'fecha_estimada'    => ['nullable', 'date']

        ]);

        $tb_sucursal = TBSucursal::where('id_sucursal', $request->sucursal)->first();
        $area = (Areas::where('id', $request->area)->first())->area_descripcion;
        if ($request->has('subarea') and $request->subarea != null) {
            $subarea = (TCSSubareas::where('id', $request->subarea)->first())->subarea_descripcion;
        }



        if(isset($request->categoria)){
        $tcs_categoria = (TCSCategorias::where('id', $request->categoria)->first())->categoria_descripcion;
        if ($request->has('subcategoria') and $request->subcategoria != null) {
            $tcs_subcategoria = (TCSSubcategorias::where('id', $request->subcategoria)->first())->descripcion_subcategoria;
        }
    }




    $fotos = [];

 $carpeta = auth()->user()->app->carpeta;
    for($i=0; $i<2; $i++){

        if ($request->hasFile('evidencia'.$i)) {

          $evidencia = $request->file('evidencia'.$i);
            $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia'.$i)->getClientOriginalName();
            Storage::disk('ftp')->put($carpeta.'/'.$iden, file_get_contents($evidencia));
            array_push($fotos,$iden);

        }



    }
    


    $crear_ticket = Tickets::create([
        
        'sucursal' => $tb_sucursal->sucursal,
        'empresa' => $tb_sucursal->tb_empresa->c_nombre_empresa,
        'usuario' => auth()->user()->nombre . ' ' . auth()->user()->apellido,
        'area' => $area,
        'subarea' => $subarea ?? null,
        'categoria' => $tcs_categoria,
        'subcategoria' => $tcs_subcategoria ?? null,
		'inventario' =>$request->equipos ?? null,
        'realizo' => $request->persona_realizo,
        'accion' => $request->accion_a_realizar,
        'estatus' => 'Abierto',
        'evidencia_inicial_multiple' => json_encode($fotos) ?? null
    ]);

    Mail::to('sistemas@sunsetmonalisa.com')->queue(new MonalisaMail($crear_ticket->id, $crear_ticket->id));
    Mail::to('mantenimiento@sunsetmonalisa.com')->queue(new MonalisaMail($crear_ticket->id, $crear_ticket->id));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = Tickets::query()
        ->where('id', $id)
        ->firstOrFail();
        $arrayPHP = json_decode($ticket->evidencia_inicial_multiple);
        $array_final = json_decode($ticket->evidencia_final_multiple);
        $array_proceso = json_decode($ticket->evidencia_proceso_multiple);
        return view('dashboard.tickets.monalisa.edit_monalisa', compact('ticket','arrayPHP','array_final','array_proceso'));
    }
 

    public function filtro(Request $request)
    {
     
        $estatus = $request->Estatus;
        return view('dashboard.tickets.monalisa.monalisa', compact('estatus'));      
    
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'estatus'           => ['required', 'string'],
            'prioridad'         => ['required', 'string'],
            'accion_a_realizar' => ['nullable', 'string'],
            'descripcion'       => ['nullable', 'string'],
            'observaciones'     => ['nullable', 'string'],
            'costo_estimado'    => ['nullable', 'numeric'],
            'fecha_estimada'    => ['nullable', 'date'],
            'fecha_estimada_proy9'=>['nullable', 'date'],
            'costo_real'        => ['nullable', 'numeric'],
            'fecha_real'        => ['nullable', 'date'],
            'persona_realizo'   => ['nullable', 'string'],
            'tiempo_ejecucion'  => ['nullable', 'string'],
            'evidencia_final'   => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png'],
        ]);


        $ticket = Tickets::where('id', $id)->first();

        if($ticket->estatus != $request->estatus){
            $transmitio = $ticket->usuario;
            $separador = " ";
            $separada = explode($separador, $transmitio);
            if (count($separada) == 3) {
                $usuario = TBUsuario::where('nombre', 'LIKE', "%$separada[1]%")
                    ->where('apellido', 'LIKE', "%$separada[2]%")
                    ->where('id_empresa',39)
                    ->get();
    
            } else
            $usuario = TBUsuario::where('nombre', 'LIKE', "%$separada[0]%")
                    ->where('apellido', 'LIKE', "%$separada[1]%")
                    ->where('id_empresa',39)
                    ->get();        
                    Mail::to($usuario[0]->correo)->queue(new EstatusMail(auth()->user()->nombre, $ticket->id,$request->estatus));
                 
        }

  
       
       if($request->estatus=='Ejecutado'){
        $ticket->update([
            'estatus'            => $request->estatus,             
            'prioridad'          => $request->prioridad ?? null,
            'accion'             => $request->accion_a_realizar,  
            'ticket_descripcion' => $request->descripcion,    
            'observaciones'      => $request->observaciones,
            'costo_estimado'     => $request->costo_estimado,
            'fecha_estimada'     => $request->fecha_estimada ?? null,
            'realizo'            => $request->persona_realizo,
            'fecha_tecnico'           => date('Y-m-d H:i:s')
        ]);
     
  
 
       } 
       if($request->estatus=='Cerrado'){
        if(!empty($ticket->fecha_tecnico)){
            $ticket->update([
                'estatus'            => $request->estatus,             
                'prioridad'          => $request->prioridad ?? null,
                'accion'             => $request->accion_a_realizar,  
                'ticket_descripcion' => $request->descripcion,    
                'observaciones'      => $request->observaciones,
                'costo_estimado'     => $request->costo_estimado,
                'fecha_estimada'     => $request->fecha_estimada ?? null,
                'realizo'            => $request->persona_realizo,
                'close_at'           => date('Y-m-d H:i:s')
                
            ]);
         
    
        }else{
            
        return back()->with(Helpers\SweetAlert2::error("El ticket tiene que pasar por el estado ejecutado para poder cerrarlo"));
        }
        
       }else{

       $ticket->update([
            'estatus'            => $request->estatus,             
            'prioridad'          => $request->prioridad ?? null,
            'accion'             => $request->accion_a_realizar,  
            'ticket_descripcion' => $request->descripcion,    
            'observaciones'      => $request->observaciones,
            'costo_estimado'     => $request->costo_estimado,
            'fecha_estimada'     => $request->fecha_estimada ?? null,
            'realizo'            => $request->persona_realizo,
    ]);           
}

        $fotos = [];
		$carpeta = auth()->user()->app->carpeta;


        for($i=0; $i<2; $i++){

            if ($request->hasFile('evidencia'.$i)) {

                $evidencia = $request->file('evidencia'.$i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia'.$i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta.'/'.$iden, file_get_contents($evidencia));
                array_push($fotos,$iden);


        $ticket->update([
            'evidencia_inicial_multiple' => json_encode($fotos) ?? null

        ]);
            }
        }


        $fotos1 = [];


        for($i=0; $i<2; $i++){

            if ($request->hasFile('evidencia_proceso'.$i)) {


                $evidencia = $request->file('evidencia_proceso'.$i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia_proceso'.$i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta.'/'.$iden, file_get_contents($evidencia));
                array_push($fotos1,$iden);
                $ticket->update([
                    'evidencia_proceso_multiple' => json_encode($fotos1) ?? null

                ]);

            }
        }






        $fotos2 = [];


        for($i=0; $i<2; $i++){

            if ($request->hasFile('evidencia_final'.$i)) {



                $evidencia = $request->file('evidencia_final'.$i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia_final'.$i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta.'/'.$iden, file_get_contents($evidencia));
                array_push($fotos2,$iden);



                $ticket->update([
                    'evidencia_final_multiple' => json_encode($fotos2) ?? null

                ]);

            }
        }
 
      
 
        return redirect()->route('web.dashboard.tickets.index')->with(Helpers\SweetAlert2::success("Se actualizó el ticket #{$ticket->id}"));
    }


    public function update_ajax_comentario(Request $request){

        $ticket = Tickets::where('id', $request->folio_idd)->first();
        if($ticket->comentario_cliente != $request->comentario_idd){
            Mail::to('sistemas@sunsetmonalisa.com')->queue(new EstatusMail(auth()->user()->nombre, $ticket->id,$request->comentario_idd));
            Mail::to('mantenimiento@sunsetmonalisa.com')->queue(new EstatusMail(auth()->user()->nombre, $ticket->id,$request->comentario_idd));
        }

        Tickets::findOrFail($request->folio_idd)->update(['comentario_cliente' => $request->comentario_idd]);
    
    
            if(!empty($request->comentario_idd)){
                $comenta=$request->comentario_idd;
            }else{
                $comenta='<span class="badge badge-pill badge-danger">Sin comentarios</span>';
            }
            return response()->json(['comentario' => $comenta]);
     }


     public function update_ajax_monalisa(Request $request)
     {

        
        $ticket = Tickets::where('id', $request->folio)->first();
        if($ticket->comentario_mantto != $request->comentario_mantto){

            $transmitio = $ticket->usuario;
            $separador = " ";
            $separada = explode($separador, $transmitio);
            if (count($separada) == 3) {
                $usuario = TBUsuario::where('nombre', 'LIKE', "%$separada[1]%")
                    ->where('apellido', 'LIKE', "%$separada[2]%")
                    ->where('id_empresa',39)
                    ->get();
    
            } else
            $usuario = TBUsuario::where('nombre', 'LIKE', "%$separada[0]%")
                    ->where('apellido', 'LIKE', "%$separada[1]%")
                    ->where('id_empresa',39)
                    ->get();        
                  
            Mail::to($usuario[0]->correo)->queue(new ComentarioMail(auth()->user()->nombre, $ticket->id,$request->comentario_mantto));
        } 
        if($ticket->estatus != $request->edo){
            $transmitio = $ticket->usuario;
            $separador = " ";
            $separada = explode($separador, $transmitio);
            if (count($separada) == 3) {
                $usuario = TBUsuario::where('nombre', 'LIKE', "%$separada[1]%")
                    ->where('apellido', 'LIKE', "%$separada[2]%")
                    ->where('id_empresa',39)
                    ->get();
    
            } else
            $usuario = TBUsuario::where('nombre', 'LIKE', "%$separada[0]%")
                    ->where('apellido', 'LIKE', "%$separada[1]%")
                    ->where('id_empresa',39)
                    ->get();        
                    Mail::to($usuario[0]->correo)->queue(new EstatusMail(auth()->user()->nombre, $ticket->id,$request->edo));
        }


        if( $request->edo == 'Ejecutado'){
            Tickets::findOrFail($request->folio)->update(['comentario_mantto' => $request->comentario_mantto,'costo_estimado' => $request->costo,'fecha_estimada' => $request->fecha_estimada,'estatus' => $request->edo,'realizo' => $request->realizo2, 'prioridad' => $request->prority, 'ticket_descripcion'=>$request->tics_descripcion,'fecha_tecnico' => date('Y-m-d H:i:s')]);
        }elseif($request->edo == 'Cerrado'){
            if (!empty($ticket->fecha_tecnico)) {
            Tickets::findOrFail($request->folio)->update(['comentario_mantto' => $request->comentario_mantto,'costo_estimado' => $request->costo,'fecha_estimada' => $request->fecha_estimada,'estatus' => $request->edo, 'realizo' => $request->realizo2, 'prioridad' => $request->prority, 'ticket_descripcion'=>$request->tics_descripcion,'close_at' => date('Y-m-d H:i:s')]);
            } else {
                return response()->json(['error' => "Ocurrio un error"]);
            }
        }else
            Tickets::findOrFail($request->folio)->update(['comentario_mantto' => $request->comentario_mantto,'costo_estimado' => $request->costo,'fecha_estimada' => $request->fecha_estimada,'estatus' => $request->edo,'realizo' => $request->realizo2, 'prioridad' => $request->prority,'ticket_descripcion'=>$request->tics_descripcion]);
    
    


           
         if(!empty($request->realizo2)){

             $realizo='<span class="badge badge-pill badge-success">'.$request->realizo2.'</span>';
             if($ticket->realizo != $request->realizo2){
                $transmitio = $ticket->usuario;
                $separador = " ";
                $separada = explode($separador, $transmitio);
                if (count($separada) == 3) {
                    $usuario = TBUsuario::where('nombre', 'LIKE', "%$separada[1]%")
                        ->where('apellido', 'LIKE', "%$separada[2]%")
                        ->where('id_empresa',39)
                        ->get();
        
                } else
                $usuario = TBUsuario::where('nombre', 'LIKE', "%$separada[0]%")
                        ->where('apellido', 'LIKE', "%$separada[1]%")
                        ->where('id_empresa',39)
                        ->get();        
                
                Mail::to($usuario[0]->correo)->queue(new MonalisaReasignacionMail($request->realizo2, $ticket->id ));
             }

         }else{
             $realizo='<span class="badge badge-pill badge-danger">Sin registro</span>';
         }
         if(!empty($request->tics_descripcion)){
             $motivo=$request->tics_descripcion;
         }else{
             $motivo='<span class="badge badge-pill badge-danger">Sin motivos</span>';
         }
         if(!empty($request->fecha_estimada)){
    
            $fech_estimada ='<span class="badge badge-pill badge-success">'.$request->fecha_estimada.'</span>';
        }else{
            $fech_estimada ='<span class="badge badge-pill badge-danger">Sin fecha</span>';
        }
    
        if($request->edo == "Cerrado")   {
            $columna = '<span class="badge badge-pill badge-success">Cerrado</span>';
           
        } elseif ($request->edo == "Ejecutado") {
            $columna = '<span class="badge badge-pill badge-secondary">Ejecutado</span>';
            
        } elseif ($request->edo == "Abierto")   {
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
    
    
        if(!empty($request->prority)){
        if ($request->prority == "Alta") {
            $prioridad = '<span class="badge badge-pill badge-danger">Alta</span>';
        } elseif ($request->prority == "Media") {
            $prioridad = '<span class="badge badge-pill badge-warning">Media</span>';
        } elseif ($request->prority == "Baja") {
            $prioridad = '<span class="badge badge-pill badge-success">Baja</span>';
        }}else{
            $prioridad = '<span class="badge badge-pill badge-danger">Sin registro</span>';
        }
    
        return response()->json(['var' => $columna, 'prioridad' => $prioridad, 'realizo' => $realizo, 'motivo' => $motivo, 'fech_estimada'=> $fech_estimada]);
    
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
