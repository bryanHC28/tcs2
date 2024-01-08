<?php

namespace App\Http\Controllers\Web\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Areas,   Tickets, TBSucursal, TCSSubareas,TCSCategorias,TCSSubcategorias,TBUsuario,nivel};
use Illuminate\Support\Facades\{DB, File, Mail, Storage};
use Illuminate\Support\Str;
use App\Mail\{SendMail,getMail,RespMail,Ejecutado};
use App\Helpers;
 
class Proyectos9Controller extends Controller

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

    public function filtro(Request $request){

        
 
        $estatus = $request->Estatus;
        $estado=$request->estado;
        return view('dashboard.tickets.proyectos9.index', compact('estatus','estado' ));
           
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


        if(auth()->user()->id_sucursal == 200 ){

        $crear_ticket = Tickets::create([
            'estatus' => 'Abierto',
            'empresa' => $tb_sucursal->tb_empresa->c_nombre_empresa,
            'sucursal' => $tb_sucursal->sucursal ,
            'usuario' => auth()->user()->nombre . ' ' . auth()->user()->apellido,
            'area' => $area ?? $request->cuatemoc,
            'nivel'=>$request->nivel,
            'prioridad' => $request->prioridad,
            'tipo_ticket' => $request->tipo_ticket ?? null,
            'realizo' => $request->persona_realizo ?? null,
            'accion' => $request->accion_a_realizar ?? null,
            'fecha_estimada' => $request->fecha_estimada,
            'fecha_cita' => $request->fecha_cita ?? null,
            'evidencia_inicial_multiple' => json_encode($fotos) ?? null
        ]);

    }elseif(auth()->user()->id_sucursal == 201){
        $crear_ticket = Tickets::create([
            'estatus' => 'Abierto',
            'empresa' => $tb_sucursal->tb_empresa->c_nombre_empresa,
            'sucursal' => $tb_sucursal->sucursal,
            'usuario' => auth()->user()->nombre . ' ' . auth()->user()->apellido,
            'area' =>  $tb_sucursal->sucursal ,
            'nivel'=> $area,
            'prioridad' => $request->prioridad,
            'tipo_ticket' => $request->tipo_ticket,
            'realizo' => $request->persona_realizo,
            'accion' => $request->accion_a_realizar ?? null,
            'fecha_estimada' => $request->fecha_estimada,
            'fecha_cita' => $request->fecha_cita ?? null,
            'evidencia_inicial_multiple' => json_encode($fotos) ?? null
        ]);
    
    }elseif(auth()->user()->id_sucursal == 111)
    
    $crear_ticket = Tickets::create([
        'estatus' => 'Abierto',
        'empresa' => $tb_sucursal->tb_empresa->c_nombre_empresa,
        'sucursal' => $tb_sucursal->sucursal,
        'usuario' => auth()->user()->nombre . ' ' . auth()->user()->apellido,
        'area' => $area,
        'subarea' => $subarea ?? null,
        'nivel'=> $request->nivel ?? null,
        'categoria'=> $tcs_categoria,
        'prioridad' => $request->prioridad,
        'tipo_ticket' => $request->tipo_ticket,
        'realizo' => $request->persona_realizo,
        'accion' => $request->accion_a_realizar ?? null,
        'fecha_estimada' => $request->fecha_estimada,
        'fecha_cita' => $request->fecha_cita ?? null,
        'evidencia_inicial_multiple' => json_encode($fotos) ?? null
    ]);


        $get_id = Tickets::latest('id')->first()->id;
        $transmitio = $request->persona_realizo;
        $separador = " ";
        $separada = explode($separador, $transmitio);



        if (count($separada) == 3) {
            $correo = TBUsuario::select('correo')
                ->where('nombre', 'LIKE', "%$separada[1]%")
                ->where('apellido', 'LIKE', "%$separada[2]%")
                ->get();

        } else
            $correo = TBUsuario::select('correo')
                ->where('nombre', 'LIKE', "%$separada[0]%")
                ->where('apellido', 'LIKE', "%$separada[1]%")
                ->get();



   Mail::to($correo[0]->correo)->queue(new RespMail($get_id, $get_id)); 
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
        
        if(auth()->user()->id_sucursal==200){

            $ticket=DB::connection('tickets')->table('tickets')->where('id', $id)
            ->where('estatus', '!=', 'Cierre final')->first();

        }else

        $ticket = Tickets::query()
            ->where('id', $id)
            ->firstOrFail();

            $arrayPHP = json_decode($ticket->evidencia_inicial_multiple);
            $array_final = json_decode($ticket->evidencia_final_multiple);
            $array_proceso = json_decode($ticket->evidencia_proceso_multiple);
    
           
                return view('dashboard.tickets.proyectos9.edit', compact('ticket','arrayPHP','array_final','array_proceso'));

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
        $request->validate([
            'estatus'           => ['required', 'string'],
            'prioridad'         => ['required', 'string'],
            'cuarto'            => ['nullable', 'string'],
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
        $fecha_estimada=$request->fecha_estimada_proy9;
        if($request->estatus == 'Ejecutado')
        {

            $ticket->update([
                'estatus'            => $request->estatus,
                'inventario'         => $request->inventario ?? null,
                'prioridad'          => $request->prioridad,
                'habitacion'         => $request->cuarto,
                'accion'             => $request->accion_a_realizar,
                'ticket_descripcion' => $request->descripcion,
                'area'               => $request->area ?? null,
                'tipo_ticket'        => $request->tipo_ticket,
                'observaciones'      => $request->observaciones,
                'costo_estimado'     => $request->costo_estimado,
                'fecha_estimada'     => $fecha_estimada,
                'fecha_cita'         => $request->fecha_cita ?? null,
                'nivel'              => $request->nivel ?? null,
                'costo'              => $request->costo_real,
                'fecha'              => $request->fecha_real,
                'realizo'            => $request->persona_realizo,
                'tiempo_ejecucion'   => $request->tiempo_ejecucion,
                'fecha_tecnico'      => date('Y-m-d H:i:s')
            ]);

            
        if($request->sucursal=='Centro Cuauhtémoc'){


            if(auth()->user()->complete_name == 'Mariana Vazquez'){


            }else{


                Mail::to('administracioncuc@proyectos9.com')->queue(new Ejecutado($id, $id));
                Mail::to('administracionresidencialcuc@proyectos9.com')->queue(new Ejecutado($id, $id));
            }

        }else{

            Mail::to('eliasquinones@proyectos9.com')->queue(new Ejecutado($id, $id));
        }

        }

        elseif($request->estatus == 'Cerrado'){

            if(!empty($ticket->fecha_tecnico)){
    
            $ticket->update([
                'estatus'            => $request->estatus,
                'inventario'         => $request->inventario ?? null,
                'prioridad'          => $request->prioridad,
                'habitacion'         => $request->cuarto,
                'accion'             => $request->accion_a_realizar,
                'ticket_descripcion' => $request->descripcion,
                'area'               => $request->area ?? null,
                'tipo_ticket'        => $request->tipo_ticket,
                'observaciones'      => $request->observaciones,
                'costo_estimado'     => $request->costo_estimado,
                'fecha_estimada'     => $fecha_estimada,
                'nivel'              => $request->nivel ?? null,
                'costo'              => $request->costo_real,
                'fecha_cita'         => $request->fecha_cita ?? null,
                'fecha'              => $request->fecha_real,
                'realizo'            => $request->persona_realizo,
                'tiempo_ejecucion'   => $request->tiempo_ejecucion,
                'close_at'           => date('Y-m-d H:i:s')
            ]);
    
        }else{
    
            return back()->with(Helpers\SweetAlert2::error("El ticket tiene que pasar por el estado ejecutado para poder cerrarlo"));
        }
    
    
           }
           else {

            $ticket->update([
                'estatus'            => $request->estatus,
                'inventario'         => $request->inventario ?? null,
                'prioridad'          => $request->prioridad,
                'habitacion'         => $request->cuarto,
                'area'               => $request->area ?? null,
                'accion'             => $request->accion_a_realizar,
                'ticket_descripcion' => $request->descripcion,
                'nivel'              => $request->nivel ?? null,
                'tipo_ticket'        => $request->tipo_ticket ?? null,
                'observaciones'      => $request->observaciones,
                'costo_estimado'     => $request->costo_estimado,
                'fecha_estimada'     => $fecha_estimada,
                'costo'              => $request->costo_real,
                'fecha'              => $request->fecha_real,
                'realizo'            => $request->persona_realizo,
                'fecha_cita' => $request->fecha_cita ?? null,
                'tiempo_ejecucion'   => $request->tiempo_ejecucion
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
