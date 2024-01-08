<?php

namespace App\Http\Controllers\Web\Resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Areas, TCSSubcategorias, TCSCategorias, Tickets, TBSucursal, TCSSubareas};
use Illuminate\Support\Facades\{DB, Mail, Storage};
use App\Helpers;
use App\Mail\{RespMail};
use Illuminate\Support\Str;

class EMSController extends Controller
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

    public function filtro(Request $request)
    {
        $estatus = $request->Estatus;
         
        return view('dashboard.tickets.ems.index', compact('estatus'));
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
            'area' => ['required', 'integer', 'exists:tickets.areas,id'],
            'subarea' => ['nullable', 'integer', 'exists:tickets.subareas,id'],
            'categoria' => ['nullable', 'integer', 'exists:tickets.tcs_categorias,id'],
            'subcategoria' => ['nullable', 'integer', 'exists:tickets.tcs_subcategorias,id'],
            'inventario' => ['nullable', 'string'],
            'transmitio' => ['nullable', 'string'],
            'cuarto' => ['nullable', 'string'],
            'accion_a_realizar' => ['nullable', 'string'],
            'descripcion' => ['nullable', 'string'],
            'observaciones' => ['nullable', 'string'],
            'costo_estimado' => ['nullable', 'numeric'],
            'fecha_estimada' => ['nullable', 'date']

        ]);

        $tb_sucursal = TBSucursal::where('id_sucursal', $request->sucursal)->first();
        $area = (Areas::where('id', $request->area)->first())->area_descripcion;
        if ($request->has('subarea') and $request->subarea != null) {
            $subarea = (TCSSubareas::where('id', $request->subarea)->first())->subarea_descripcion;
        }



        if (isset($request->categoria)) {
            $tcs_categoria = (TCSCategorias::where('id', $request->categoria)->first())->categoria_descripcion;
            if ($request->has('subcategoria') and $request->subcategoria != null) {
                $tcs_subcategoria = (TCSSubcategorias::where('id', $request->subcategoria)->first())->descripcion_subcategoria;
            }
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
            'subarea' => $subarea ?? null,
            'prioridad' => $request->prioridad,
            'tipo_ticket' => $request->tipo_ticket ?? null,
            'realizo' => $request->persona_realizo,
            'accion' => $request->accion_a_realizar,
            'fecha_estimada' => $request->fecha_estimada,
            'estatus' => 'Abierto',
            'fecha_cita' => $request->fecha_cita ?? null,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (auth()->user()->id_usuario == 407) {
            $ticket = DB::connection('tickets')->table('tickets')->where('empresa', 'EMS Soluciones')->where('id', $id)->first();

        } else {

            $ticket = Tickets::query()
                ->where('id', $id)
                ->firstOrFail();
        }
        $arrayPHP = json_decode($ticket->evidencia_inicial_multiple);
        $array_final = json_decode($ticket->evidencia_final_multiple);
        $array_proceso = json_decode($ticket->evidencia_proceso_multiple);


        return $ticket->efirma;
        return view('dashboard.tickets.ems.edit', compact('ticket', 'arrayPHP', 'array_final', 'array_proceso'));

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
            'estatus' => ['required', 'string'],
            'prioridad' => ['required', 'string'],
            'accion_a_realizar' => ['nullable', 'string'],
            'descripcion' => ['nullable', 'string'],
            'observaciones' => ['nullable', 'string'],
            'costo_estimado' => ['nullable', 'numeric'],
            'fecha_estimada' => ['nullable', 'date'],
            'fecha_estimada_proy9' => ['nullable', 'date'],
            'costo_real' => ['nullable', 'numeric'],
            'fecha_real' => ['nullable', 'date'],
            'persona_realizo' => ['nullable', 'string'],
            'tiempo_ejecucion' => ['nullable', 'string'],
            'evidencia_final' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png'],
        ]);
        
     
        $ticket = DB::connection('tickets')->table('tickets')->where('id', $id);
 

        if($request->estatus == 'Ejecutado')
        {
             
            $ticket->update([
           'estatus' => $request->estatus,
           'prioridad' => $request->prioridad,
           'tipo_ticket' => $request->tipo_ticket ?? null,
           'accion' => $request->accion_a_realizar,
           'observaciones' => $request->observaciones,
           'costo_estimado' => $request->costo_estimado,
           'fecha_estimada' => $request->fecha_estimada,
           'fecha_cita' => $request->fecha_cita ?? null,
           'realizo' => $request->persona_realizo,
           'fecha_tecnico' => date('Y-m-d H:i:s')

       ]);

        }elseif($request->estatus == 'Validado'){

            $ticket->update([
                'estatus' => $request->estatus,
                'prioridad' => $request->prioridad,
                'tipo_ticket' => $request->tipo_ticket ?? null,
                'accion' => $request->accion_a_realizar,
                'observaciones' => $request->observaciones,
                'costo_estimado' => $request->costo_estimado,
                'fecha_estimada' => $request->fecha_estimada,
                'fecha_cita' => $request->fecha_cita ?? null,
                'realizo' => $request->persona_realizo,
                'fecha' => date('Y-m-d H:i:s')
     
            ]);
        }elseif($request->estatus == 'Cerrado'){
            if(!empty($ticket->fecha_tecnico)){
            $ticket->update([
                'estatus' => $request->estatus,
                'prioridad' => $request->prioridad,
                'tipo_ticket' => $request->tipo_ticket ?? null,
                'accion' => $request->accion_a_realizar,
                'observaciones' => $request->observaciones,
                'costo_estimado' => $request->costo_estimado,
                'fecha_estimada' => $request->fecha_estimada,
                'fecha_cita' => $request->fecha_cita ?? null,
                'realizo' => $request->persona_realizo,
                'close_at' => date('Y-m-d H:i:s')
     
            ]);
        }else{
    
            return back()->with(Helpers\SweetAlert2::error("El ticket tiene que pasar por el estado ejecutado para poder cerrarlo"));
        }
    
        }else{

            $ticket->update([
                'estatus' => $request->estatus,
                'prioridad' => $request->prioridad,
                'tipo_ticket' => $request->tipo_ticket ?? null,
                'accion' => $request->accion_a_realizar,
                'observaciones' => $request->observaciones,
                'costo_estimado' => $request->costo_estimado,
                'fecha_estimada' => $request->fecha_estimada,
                'fecha_cita' => $request->fecha_cita ?? null,
                'realizo' => $request->persona_realizo,
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

    public function update_ajax_ems(Request $request){


        $ticket = DB::connection('tickets')->table('tickets')->where('id', $request->folio);
        $base64Image = $request->firma;
        $carpeta = auth()->user()->app->carpeta;
        if (Str::startsWith($base64Image, 'data:image')) {
            list($type, $data) = explode(';', $base64Image);
            list(, $data) = explode(',', $data);        
            // Decodificar la cadena base64
            $decodedData = base64_decode($data);            
            // Generar el nombre del archivo
            $imageName = Str::slug(config('app.name') . ' ' . now()).Str::random(10) . '.jpg'; 
            // Guardar en el disco FTP
            Storage::disk('ftp')->put($carpeta . '/' . $imageName, $decodedData);         
        }

        if( $request->edo == 'Ejecutado'){
        $ticket->update(['observaciones'=> $request->obs,'estatus' => $request->edo,'prioridad' => $request->priority,'tipo_ticket' => $request->type, 'realizo' => $request->realizo, 'fecha_cita' => $request->cita, 'costo_estimado' => $request->costo,'fecha_tecnico' => date('Y-m-d H:i:s'),'efirma' =>  $imageName]);
        }elseif($request->edo == 'Cerrado'){
            if (!empty($ticket->fecha_tecnico)) {
                $ticket->update(['observaciones'=> $request->obs,'estatus' => $request->edo,'prioridad' => $request->priority,'tipo_ticket' => $request->type, 'realizo' => $request->realizo, 'fecha_cita' => $request->cita, 'costo_estimado' => $request->costo,'close_at' => date('Y-m-d H:i:s'),'efirma' =>  $imageName]);
            } else {
                return response()->json(['error' => "Ocurrio un error"]);
            }
        }elseif($request->edo == 'Validado'){
        $ticket->update(['observaciones'=> $request->obs,'estatus' => $request->edo,'prioridad' => $request->priority,'tipo_ticket' => $request->type, 'realizo' => $request->realizo, 'fecha_cita' => $request->cita, 'costo_estimado' => $request->costo,'fecha' => date('Y-m-d H:i:s'),'efirma' =>  $imageName]);
    }else{
        $ticket->update(['observaciones'=> $request->obs,'estatus' => $request->edo,'prioridad' => $request->priority,'tipo_ticket' => $request->type, 'realizo' => $request->realizo, 'fecha_cita' => $request->cita, 'costo_estimado' => $request->costo,'efirma' =>  $imageName]);
    }


    if ($request->edo == "Cerrado") {
        $estado = '<span class="badge badge-pill badge-success">Cerrado</span>';
    } elseif ($request->edo == "Ejecutado") {
        $estado = '<span class="badge badge-pill badge-secondary">Ejecutado</span>';
    } elseif ($request->edo == "Abierto") {
        $estado = '<span class="badge badge-pill badge-primary">Abierto</span>';
    } elseif ($request->edo == "Cancelado") {
        $estado = '<span class="badge badge-pill badge-dark">Cancelado</span>';
    } elseif ($request->edo == "Validado") {
        $estado = '<span class="badge badge-pill badge-info">Validado</span>';
    }
    elseif ($request->edo == "Cancelado") {
        $estado = '<span class="badge badge-pill badge-dark">Suspendido</span>';
    } else {
        $estado = '<span class="badge badge-pill badge-danger">Sin regitro</span>';
    }


    if(!empty($request->priority)){
        if ($request->priority == "Critica") {
            $prioridad = '<span class="badge badge-pill badge-danger">Critica</span>';
        } elseif ($request->priority == "Urgente") {
            $prioridad = '<span class="badge badge-pill badge-warning">Urgente</span>';
        } elseif ($request->priority == "Media") {
            $prioridad = '<span class="badge badge-pill badge-success">Media</span>';
        }}else{
            $prioridad = '<span class="badge badge-pill badge-danger">Sin registro</span>';
        }



        if(!empty($request->type)){
            
                $type = '<span class="badge badge-pill badge-success">'.$request->type.'</span>';
            }else{
                $type = '<span class="badge badge-pill badge-danger">Sin registro</span>';
            }


            if(!empty($request->realizo)){

                $realizo='<span class="badge badge-pill badge-success">'.$request->realizo.'</span>';
            }else{
                $realizo='<span class="badge badge-pill badge-danger">Sin registro</span>';
            }

            if(!empty($request->costo)){

                $costo='<span class="badge badge-pill badge-success">$'.$request->costo.'</span>';
            }else{
                $costo='<span class="badge badge-pill badge-danger">Sin registro</span>';
            }
            
    return response()->json(['estado' => $estado, 'prioridad' => $prioridad, 'type' => $type, 'realizo' => $realizo, 'costo'=> $costo]);
    }



    public function destroy($id)
    {
        //
    }
}