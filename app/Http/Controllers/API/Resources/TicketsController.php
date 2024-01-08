<?php

namespace App\Http\Controllers\API\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Tickets,TBUsuario};
use Illuminate\Support\Facades\{DB,Storage};
use Illuminate\Support\Str;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ticket = Tickets::query()
        ->where('empresa', 'Accor-Ibis')
		->orderBy('id','ASC')
        ->get();

        return response()->json($ticket);


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

     public function offline(Request $request){

        $data = $request->all();
        $carpeta =  "proyectos9";
        
        $datos = [
            'message' => 'Ticket created successfully',
            'ticket' =>  $data,
             'contador' => count($data),
         
        ];

 
       foreach($data as $ticket){
        $base64Image=$ticket['imageData'];
        
     
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


        DB::beginTransaction();
        try {

        
            Tickets::create([
            'estatus' => 'Abierto',
            'empresa' => $ticket['empresa'],
            'sucursal' => $ticket['sucursal'],
            'usuario' => "offline user",
            'area' => $ticket['area'],
            'nivel'=>$ticket['nivel'],
            'prioridad' => $ticket['prioridad'],
            'tipo_ticket' => $ticket['tipo_tcs'] ?? null,
            'realizo' => $ticket['responsable'] ?? null,
            'accion' => $ticket['descripcion'] ?? null,
            'fecha_estimada' => $ticket['fecha_estimada'],
            'fecha_cita' => $ticket['fecha_cita'] ?? null,
            'evidencia_inicial_multiple' => json_encode(array($imageName))
        ]);
      DB::commit();

    } catch (\Exception $e) {
        DB::rollback();
        return response()->json($e);
    }
 
       }
       return response()->json($datos);



     }
    public function store(Request $request)
    {
 
       



        $ticket = new Tickets;
        $ticket->empresa = $request->empresa;
        $ticket->sucursal = $request->sucursal; //IMP
        $ticket->usuario = $request->usuario; //IMP por nomenclatura
        $ticket->area = $request->area;
        $ticket->subarea = $request->subarea ?? null;
        $ticket->categoria = $request->categoria;
        $ticket->subcategoria = $request->subcategoria ?? null;
        $ticket->transmitio = $request->transmitio ?? null;
        $ticket->habitacion = $request->habitacion ?? null;
        $ticket->accion = $request->accion ?? null;
        $ticket->ticket_descripcion = $request->ticket_descripcion ?? null;
        $ticket->observaciones = $request->observaciones ?? null;
        $ticket->costo_estimado = $request->costo_estimado ?? null;
        $ticket->fecha_estimada = $request->fecha_estimada ?? null;
        $ticket->estatus = 'Abierto';
        $ticket->realizo = $request->realizo ?? null;
        $ticket->prioridad = $request->prioridad;
        $ticket->inventario = $request->inventario ?? null;
        $ticket->tipo_ticket = $request->tipo_ticket ?? null;
		$ticket->evidencia_inicial_multiple = json_encode($request->evidencia_inicial_multiple) ?? null;
        $ticket->save();
        $data = [
            'message' => 'Ticket created successfully',
            'ticket' => $ticket
        ];

        return response()->json($data);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $ticket = Tickets::query()
        ->where('sucursal', $id)
		->orderBy('id','ASC')
        ->get();

        return response()->json($ticket);

    }



    public function mostrar_ticket(Tickets $ticket)
    {



        return response()->json($ticket);

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
        $ticket=Tickets::find($id);
        $ticket->update($request->all());
        $data = [
            'message' => 'Ticket updated successfully',
            'ticket' => $ticket
        ];

        return response()->json($data);
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

    public function show_9($id){

        $ticket = DB::connection('tickets')
        ->table('tickets')
        ->where('id', $id)
        ->first();
        
        return view('tickets.ver', compact('ticket'));
   

    }
    public function show_monalisa($id){

        $ticket = DB::connection('tickets')
        ->table('tickets')
        ->where('id', $id)
        ->first();
    return view('tickets.ver_monalisa', compact('ticket' ));


    }
}
