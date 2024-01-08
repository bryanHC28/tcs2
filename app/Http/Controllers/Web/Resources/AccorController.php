<?php

namespace App\Http\Controllers\Web\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Areas, TCSSubcategorias, TCSCategorias, TBSucursal,Tickets,TCSSubareas};
use Illuminate\Support\Str;
use App\Helpers;
use Illuminate\Support\Facades\{DB, File, Mail, Storage};
use App\Mail\{ MonalisaMail,RespMail};
class AccorController extends Controller
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
        return view('dashboard.tickets.accor.index', compact('estatus' ));
           

        
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
        'empresa' => $tb_sucursal->tb_empresa->c_nombre_empresa,
        'sucursal' => $tb_sucursal->sucursal,
        'usuario' => auth()->user()->nombre . ' ' . auth()->user()->apellido,
        'area' => $area,
        'categoria' => $tcs_categoria,
        'transmitio' => $request->transmitio ?? null,
        'habitacion' => $request->cuarto,
        'accion' => $request->accion_a_realizar,
        'ticket_descripcion' => $request->descripcion,
        'observaciones' => $request->observaciones,
        'estatus' => 'Abierto',
        'prioridad' => $request->prioridad,
        'inventario' => $request->inventario ?? null,
        'evidencia_inicial_multiple' => json_encode($fotos) ?? null
    ]);

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
            ->where('estatus', '!=', 'Cierre final')
            ->firstOrFail();

        $arrayPHP = json_decode($ticket->evidencia_inicial_multiple);
        $array_final = json_decode($ticket->evidencia_final_multiple);
        $array_proceso = json_decode($ticket->evidencia_proceso_multiple);

       
            return view('dashboard.tickets.accor.edit', compact('ticket','arrayPHP','array_final','array_proceso'));
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
        if($request->estatus=='En proceso'){
            $ticket->update([
                'estatus'            => $request->estatus,             
                'prioridad'          => $request->prioridad,
                'habitacion'         => $request->cuarto ?? null,
                'accion'             => $request->accion_a_realizar ?? null,  
                'ticket_descripcion' => $request->descripcion,    
                'observaciones'      => $request->observaciones,
                'fecha_tecnico'           => date('Y-m-d H:i:s')
            ]);
           } 
           if($request->estatus=='Cerrado'){
            $ticket->update([
                'estatus'            => $request->estatus,             
                'prioridad'          => $request->prioridad,
                'habitacion'         => $request->cuarto ?? null,
                'accion'             => $request->accion_a_realizar ?? null,  
                'ticket_descripcion' => $request->descripcion,    
                'observaciones'      => $request->observaciones,
                'close_at'           => date('Y-m-d H:i:s')
            ]);
           }else
        $ticket->update([
            'estatus'            => $request->estatus,
            'prioridad'          => $request->prioridad,
            'habitacion'         => $request->cuarto,
            'accion'             => $request->accion_a_realizar,
            'ticket_descripcion' => $request->descripcion,
            'observaciones'      => $request->observaciones,             
        ]);

        
        $fotos = [];
		$carpeta = auth()->user()->app->carpeta;


        for($i=0; $i<2; $i++){

            if ($request->hasFile('evidencia'.$i)) {

                $evidencia = $request->file('evidencia'.$i);
                $iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia'.$i)->getClientOriginalName();
                Storage::disk('ftp')->put($carpeta.'/'.$iden, file_get_contents($evidencia));
                //$iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia'.$i)->getClientOriginalName();
                //Storage::disk('ftp')->put($carpeta.'/'.$iden, File::get($request->file('evidencia'.$i)));

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
                //$iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia'.$i)->getClientOriginalName();
                //Storage::disk('ftp')->put($carpeta.'/'.$iden, File::get($request->file('evidencia'.$i)));

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
                //$iden = Str::slug(config('app.name') . ' ' . now()) . $request->file('evidencia'.$i)->getClientOriginalName();
                //Storage::disk('ftp')->put($carpeta.'/'.$iden, File::get($request->file('evidencia'.$i)));

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
