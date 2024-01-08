<?php

namespace App\Http\Controllers\Web\Resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Areas, Controlcorreo, Correo, TBEmpresa, TBInventario, TCSSubcategorias, TBUsuario, TCSCategorias, Tickets, TBSucursal, TCSSubareas};
use Illuminate\Support\Facades\{DB, File, Mail, Storage};
use App\Helpers\{graficas_pilot,graficas_proy9,graficas_accor,graficas_monalisa,graficas_workplay};
use App\Jobs\SendEmail;
use App\Mail\TicketcloseMail;
use Carbon\Carbon;
use App\Mail\{SendMail, getMail, RespMail, Ejecutado, TicketcreateMail};
use App\Rules\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Contracts\View\Factory;
use JeroenNoten\LaravelAdminLte\View\Components\Form\Select;

class TicketsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function UpdateStatusNoti($id)
    {
        $ticket = Tickets::where('id', $id)->first();
        $ticket->where(['id' => $id])
            ->update(['estado' => 'Aceptado']);
        return back()->with(Helpers\SweetAlert2::success("El ticket ha sido aceptado con folio #{$id}"));
    }

    public function UpdateStatusNotidenied(Request $request)
    {
        Tickets::where(['id' => $request->id])
            ->update(['estado' => 'Rechazado', 'estatus' => 'En proceso', 'falla' => $request->motivo_rechazo]);
        $ticket = Tickets::find($request->id);
        Mail::to('ivan.clement@organosintesis.com')->queue(new getMail($ticket, $request->motivo_rechazo));
        Mail::to('gpa@organosintesis.com')->queue(new getMail($ticket, $request->motivo_rechazo));
        return back();
    }



    public function index()
    {

        switch (auth()->user()->id_empresa) {
            

            case 39:
                return view('dashboard.tickets.monalisa.monalisa');
                break;

            case 33:
                return view('dashboard.tickets.proyectos9.index');
                break;

            case 10:
                return view('dashboard.tickets.accor.index');
                break;

            case 27:
                return view('dashboard.tickets.pilot.index');
                break;

            case 5:
                return view('dashboard.tickets.ev.index');

            case 44:
                return view('dashboard.tickets.WorkPlay.index');
                break;

        }
    }

    public function filtro(Request $request)
    {
        $estatus = $request->Estatus;
        $tipo = $request->Tipo;
        return view('dashboard.tickets.pilot.index', compact('estatus', 'tipo'));
    }

    public function filtrograficas(Request $request)
    {


   
        switch (auth()->user()->id_empresa) {
            case 27:
        
                $dashboard_pilot= graficas_pilot::graficas($request->fecha_inicio,$request->fecha_fin);
                return $dashboard_pilot;
                break;

            case 33:
                $dashboard_proy9= graficas_proy9::graficas($request->fecha_inicio,$request->fecha_fin);
                return $dashboard_proy9;
                 break;

            case 10:
                $dashboard_accor = graficas_accor::graficas($request->fecha_inicio,$request->fecha_fin);
                return $dashboard_accor;
                 break;
            case 39:
                $graficas_monalisa = graficas_monalisa::graficas($request->fecha_inicio,$request->fecha_fin);
                return $graficas_monalisa;
                 break;
            case 44:
                $graficas_workplay = graficas_workplay::graficas($request->fecha_inicio,$request->fecha_fin);
                return $graficas_workplay;
                break;
 


        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


       
        $data = DB::connection('tickets')->table('tickets')->select('id')->where('empresa', 'DemoProyectos9')->orderBy('id', 'desc')->first();


        if (auth()->user()->id_sucursal === 200 && auth()->user()->rol_tickets === 'Administrador') {
            $sucursales = TBSucursal::where('id_sucursal', 200)->get();
        } elseif (auth()->user()->id_sucursal === 200 && auth()->user()->rol_tickets === 'jefe') {
            $sucursales = TBSucursal::where('id_sucursal', 200)->get();
        } elseif (auth()->user()->id_sucursal === 201 && auth()->user()->rol_tickets === 'Administrador') {
            $sucursales = TBSucursal::where('id_sucursal', 201)->get();
        } elseif (auth()->user()->id_sucursal === 201 && auth()->user()->rol_tickets === 'jefe') {
            $sucursales = TBSucursal::where('id_sucursal', 201)->get();
        } elseif (auth()->user()->id_sucursal === 111) {
            $sucursales = TBSucursal::where('id_sucursal', 111)->get();
        } else
            $sucursales = TBSucursal::get();
        $inventarios = TBInventario::get();
        $inv_lsm = TBInventario::where('inventario_clave', 'LSM')->get();

        $inventario = array();
        $lsm = array();
        foreach ($inventarios as $inve) {
            $inv = $inve->inventario_nombre;

            array_push($inventario, $inv);
        }


        foreach ($inv_lsm as $invlsm) {
            $inv = $invlsm->inventario_nombre;

            array_push($lsm, $inv);
        }

        $idSucursal = auth()->user()->id_sucursal;


        $transmitio = DB::connection('tickets')->table('tcs_transmitio')
            ->join('tcs_control_transmitio', 'tcs_transmitio.id', 'tcs_control_transmitio.idTransmitio')
            ->select('tcs_transmitio.*')
            ->where('tcs_control_transmitio.idSucursal', $idSucursal)
            ->get();



        switch (auth()->user()->id_empresa) {
           
            case 39:
                return view('dashboard.tickets.monalisa.create_monalisa', compact('sucursales', 'inventario', 'transmitio', 'data'));
                break;
            case 33:
                return view('dashboard.tickets.proyectos9.create', compact('sucursales', 'inventario', 'transmitio', 'data'));
                break;
            case 10:
                return view('dashboard.tickets.accor.create', compact('sucursales', 'inventario', 'transmitio', 'data'));
                break;
            case 27:
                return view('dashboard.tickets.pilot.create', compact('sucursales', 'inventario', 'transmitio', 'data'));
                break;
            case 5:
                return view('dashboard.tickets.ev.create', compact('sucursales', 'inventario', 'transmitio', 'data'));
                break;
            case 44:
                return view('dashboard.tickets.WorkPlay.create', compact('sucursales', 'lsm', 'transmitio', 'data'));
                break;
        }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request)
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
            'categoria' => $tcs_categoria,
            'subcategoria' => $tcs_subcategoria ?? null,
            'transmitio' => $request->transmitio ?? null,
            'habitacion' => $request->cuarto,
            'accion' => $request->accion_a_realizar,
            'ticket_descripcion' => $request->descripcion,
            'observaciones' => $request->observaciones,
            'costo_estimado' => $request->costo_estimado,
            'fecha_estimada' => $request->fecha_estimada,
            'estatus' => 'Abierto',
            'realizo' => $request->persona_realizo,
            'prioridad' => $request->prioridad,
            'inventario' => $request->inventario ?? null,
            'tipo_ticket' => $request->tipo_ticket ?? null,
            'evidencia_inicial_multiple' => json_encode($fotos) ?? null
        ]);




        if (!empty($request->inventario)) {
            $ultimo_ticket = Tickets::latest('id')->first();
            $ticket = $ultimo_ticket->id;
            $usuario = auth()->user()->nombre . ' ' . auth()->user()->apellido;
            $area = $area;
            $descripcion = $request->descripcion;
            $equipo = $request->inventario;
            // Mail::to('bhilario@empresavirtual.mx')->queue(new TicketcreateMail($ticket, $usuario, $area, $descripcion, $equipo));
            Mail::to('ivan.clement@organosintesis.com')->queue(new TicketcreateMail($ticket, $usuario, $area, $descripcion, $equipo));
            Mail::to('aom@organosintesis.com')->queue(new TicketcreateMail($ticket, $usuario, $area, $descripcion, $equipo));
        }



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
        if (auth()->user()->id_usuario == 315 || auth()->user()->id_usuario == 314) {
            $ticket = DB::connection('tickets')
                ->table('tickets')
                ->where('id', $id)
                ->first();
        } else
            $ticket = Tickets::query()
                ->where('id', $id)
                ->firstOrFail();

        $auth = auth()->user();
        if ($ticket->empresa != $auth->empresa->c_nombre_empresa) {
            return abort(403);
        }

        $arrayPHP = json_decode($ticket->evidencia_inicial_multiple);
        $array_final = json_decode($ticket->evidencia_final_multiple);
        $array_proceso = json_decode($ticket->evidencia_proceso_multiple);



        return view('dashboard.tickets.show', compact('ticket', 'arrayPHP', 'array_final', 'array_proceso'));
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

        $auth = auth()->user();
        if ($auth->rol_tickets == 'Usuario') {
            return abort(403);
        }

        if ($auth->rol_tickets == 'Ejecutor' and $ticket->estatus == 'Cerrado') {
            return abort(403);
        }

        $arrayPHP = json_decode($ticket->evidencia_inicial_multiple);
        $array_final = json_decode($ticket->evidencia_final_multiple);
        $array_proceso = json_decode($ticket->evidencia_proceso_multiple);


        return view('dashboard.tickets.pilot.edit', compact('ticket', 'arrayPHP', 'array_final', 'array_proceso'));





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
            'cuarto' => ['nullable', 'string'],
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

        $ticket = Tickets::where('id', $id)->first();
        $fecha_estimada = $request->fecha_estimada;
        if ($request->estatus == 'Cierre final') {

            if (!empty($ticket->fecha_tecnico)) {

                $ticket->update([
                    'estatus' => $request->estatus,
                    'inventario' => $request->inventario ?? null,
                    'prioridad' => $request->prioridad,
                    'habitacion' => $request->cuarto,
                    'accion' => $request->accion_a_realizar,
                    'ticket_descripcion' => $request->descripcion,
                    'tipo_ticket' => $request->tipo_ticket,
                    'observaciones' => $request->observaciones,
                    'costo_estimado' => $request->costo_estimado,
                    'fecha_estimada' => $fecha_estimada,
                    'costo' => $request->costo_real,
                    'fecha_cita' => $request->fecha_cita ?? null,
                    'fecha' => $request->fecha_real,
                    'realizo' => $request->persona_realizo,
                    'tiempo_ejecucion' => $request->tiempo_ejecucion,
                    'close_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                return back()->with(Helpers\SweetAlert2::error("El ticket tiene que pasar por el estado Cerrado para poder dar Cierre final"));
            }

        } elseif ($request->estatus == 'Cerrado') {




            $ticket->update([
                'estatus' => $request->estatus,
                'inventario' => $request->inventario ?? null,
                'prioridad' => $request->prioridad,
                'habitacion' => $request->cuarto,
                'accion' => $request->accion_a_realizar,
                'ticket_descripcion' => $request->descripcion,
                'tipo_ticket' => $request->tipo_ticket,
                'observaciones' => $request->observaciones,
                'costo_estimado' => $request->costo_estimado,
                'fecha_estimada' => $fecha_estimada,
                'costo' => $request->costo_real,
                'fecha' => $request->fecha_real,
                'fecha_cita' => $request->fecha_cita ?? null,
                'realizo' => $request->persona_realizo,
                'tiempo_ejecucion' => $request->tiempo_ejecucion,
                'fecha_tecnico' => date('Y-m-d H:i:s')
            ]);


        } else {

            $ticket->update([
                'estatus' => $request->estatus,
                'inventario' => $request->inventario ?? null,
                'prioridad' => $request->prioridad,
                'habitacion' => $request->cuarto,
                'area' => $request->area ?? null,
                'accion' => $request->accion_a_realizar,
                'ticket_descripcion' => $request->descripcion,
                'nivel' => $request->nivel ?? null,
                'tipo_ticket' => $request->tipo_ticket ?? null,
                'observaciones' => $request->observaciones,
                'costo_estimado' => $request->costo_estimado,
                'fecha_estimada' => $fecha_estimada,
                'costo' => $request->costo_real,
                'fecha' => $request->fecha_real,
                'realizo' => $request->persona_realizo,
                'fecha_cita' => $request->fecha_cita ?? null,
                'tiempo_ejecucion' => $request->tiempo_ejecucion
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

        if ($request->estatus == "Cierre final" || $request->estatus == "Cerrado" || $request->estatus == "Cancelado") {
            $userAuth = auth()->user()->nombre . ' ' . auth()->user()->apellido;
            $link = route('web.dashboard.tickets.show', ['ticket' => $ticket->id]);
            $transmitio = $ticket->usuario;
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



            Mail::to($correo[0]->correo)->queue(new SendMail($ticket, $userAuth, $link));


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
        $ticket = Tickets::query()
            ->where('id', $id)
            ->first();

        if (!$ticket) {
            return back()->with(Helpers\SweetAlert2::error('No se pudo eliminar el ticket'));
        }

        if ($ticket->evidenciaInicial != null and $ticket->ticket_sumapp == null) {
            $this->eliminarImagen($ticket->carpeta_evidencia, $ticket->evidenciaInicial);
        }

        if ($ticket->evidenciaFinal != null) {
            $this->eliminarImagen($ticket->carpeta_evidencia, $ticket->evidenciaFinal);
        }

        $ticket->delete();
        return back()->with(Helpers\SweetAlert2::success("Se eliminó permanentemente el ticket #{$ticket->id}"));
    }

    /**
     * Guardar imagen
     *
     * @param mixed $imagen
     * @param String $carpeta
     *
     * @return String $nombre_imagen
     */
    public function guardarImagen(mixed $imagen, string $carpeta)
    {
        $imagen_optimizada = Helpers\Image::optimize($imagen);
        $nombre_imagen = Helpers\File::createUniqueName('.png');
        Storage::disk('evidencias')->put("{$carpeta}/{$nombre_imagen}", $imagen_optimizada);

        return $nombre_imagen;
    }

    /**
     * Eliminar imagen
     *
     * @param String $carpeta
     * @param String $nombre_imagen
     */
    public function eliminarImagen(string $carpeta, string $nombre_imagen)
    {
        return Storage::disk('ftp_fotostickets')->delete("{$carpeta}/{$nombre_imagen}");
    }

    public function offline()
    {
        return view('tickets.offline');
    }
}