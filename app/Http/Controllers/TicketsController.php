<?php

namespace App\Http\Controllers\Web\Resources;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Areas, TBEmpresa, TBInventario, TCSSubcategorias, TCSCategorias, Tickets, TBSucursal};
use Illuminate\Support\Facades\{DB, File, Mail, Storage};
use App\Helpers;
use App\Mail\SendMail;
use App\Mail\TicketcloseMail;
use App\Mail\TicketcreateMail;
use App\Rules\Auth;
use Illuminate\Support\Str;

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
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Tickets::query()
            ->orderBy('id', 'DESC')
            ->get();

        return view('dashboard.tickets.index', compact('tickets'));
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = TBSucursal::get();
        $inventarios = TBInventario::get();

        $inventario = array();
        foreach ($inventarios as $inve) {
            $inv = $inve->inventario_nombre;

            array_push($inventario,  $inv);
        }
        $idSucursal = auth()->user()->id_sucursal;
       // $idSucursal = TBEmpresa::where('id_empresa', '10')->get();
       // $idSucursal->tcs_transmitio->get();
        $transmitio = DB::connection('tickets')->table('tcs_transmitio')
                    ->join('tcs_control_transmitio', 'tcs_transmitio.id', 'tcs_control_transmitio.idTransmitio')
                    ->select('tcs_transmitio.*')
                    ->where('tcs_control_transmitio.idSucursal', $idSucursal)
                    ->get();

        return view('dashboard.tickets.create', compact('sucursales', 'inventario', 'transmitio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request)
    {


        $self = new Self;
        $request->validate([
            'sucursal'          => ['required', 'integer', 'exists:EV_SUMAPP.tb_sucursal,id_sucursal'],
            'area'              => ['required', 'integer', 'exists:tickets.areas,id'],
            'categoria'         => ['required', 'integer', 'exists:tickets.tcs_categorias,id'],
            'subcategoria'      => ['nullable', 'integer', 'exists:tickets.tcs_subcategorias,id'],
            'inventario'        => ['nullable', 'string'],
            'transmitio'        => ['nullable', 'string'],
            'cuarto'            => ['nullable', 'string'],
            'accion_a_realizar' => ['nullable', 'string'],
            'descripcion'       => ['nullable', 'string'],
            'observaciones'     => ['nullable', 'string'],
            'costo_estimado'    => ['nullable', 'numeric'],
            'fecha_estimada'    => ['nullable', 'date'],
            'evidencia'         => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png']
        ]);

        $tb_sucursal = TBSucursal::where('id_sucursal', $request->sucursal)->first();
        $area = (Areas::where('id', $request->area)->first())->area_descripcion;
        $tcs_categoria = (TCSCategorias::where('id', $request->categoria)->first())->categoria_descripcion;
        if ($request->has('subcategoria') and $request->subcategoria != null) {
            $tcs_subcategoria = (TCSSubcategorias::where('id', $request->subcategoria)->first())->descripcion_subcategoria;
        }



        if ($request->hasFile('evidencia')) {

            $fileIden = $request->file('evidencia');
            $iden = Str::slug(config('app.name') . ' ' . now()) . $fileIden->getClientOriginalName();
            Storage::disk('evidencias')->put("{$iden}", File::get($fileIden));
            // $fileIden->move('/var/www/vhosts/app.polizaderentas.com/public/docs/'.$folio[0]->clave.'/dueno/', $iden);
            $url = 'evidencias/'.$iden;

        }
        $crear_ticket = Tickets::create([
            'empresa'            => $tb_sucursal->tb_empresa->c_nombre_empresa,
            'sucursal'           => $tb_sucursal->sucursal,
            'usuario'            => auth()->user()->nombre.' '. auth()->user()->apellido,
            'area'               => $area,
            'categoria'          => $tcs_categoria,
            'subcategoria'       => $tcs_subcategoria ?? null,
            'transmitio'         => $request->transmitio ?? null,
            'habitacion'         => $request->cuarto,
            'accion'             => $request->accion_a_realizar,
            'ticket_descripcion' => $request->descripcion,
            'observaciones'      => $request->observaciones,
            'costo_estimado'     => $request->costo_estimado,
            'fecha_estimada'     => $request->fecha_estimada,
            'estatus'            => 'Abierto',
            'prioridad'          => $request->prioridad,
            'inventario'         => $request->inventario ?? null,
            'tipo_ticket'        => $request->tipo_ticket ?? null,
            'evidenciaInicial' => $url ?? null
        ]);

        if (auth()->user()->id_empresa == 27) {
            $idSuc = auth()->user()->id_sucursal;
            $nombre = auth()->user()->nombre . ' ' . auth()->user()->apellido;
            $ultimo_ticket = Tickets::latest('id')->first();


            $ticket = $ultimo_ticket->id;
            $usuario = $nombre;
            $area = $area;
            $descripcion = $request->descripcion;




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
        $ticket = Tickets::query()
            ->where('id', $id)
            ->firstOrFail();

        $auth = auth()->user();
        if ($ticket->empresa != $auth->empresa->c_nombre_empresa) {
            return abort(403);
        }

        return view('dashboard.tickets.show', compact('ticket'));
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
        if($ticket->estatus == 'Cerrado'){
            $ticket = $id;
           // Mail::to('corozco@empresavirtual.mx')->queue(new TicketcloseMail($ticket));

        }

        return view('dashboard.tickets.edit', compact('ticket'));
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
            'costo_real'        => ['nullable', 'numeric'],
            'fecha_real'        => ['nullable', 'date'],
            'evidencia_final'   => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png'],
        ]);


        $ticket = Tickets::where('id', $id)->first();
        $ticket->update([
            'estatus'            => $request->estatus,
            'prioridad'          => $request->prioridad,
            'habitacion'         => $request->cuarto,
            'accion'             => $request->accion_a_realizar,
            'ticket_descripcion' => $request->descripcion,
            'observaciones'      => $request->observaciones,
            'costo_estimado'     => $request->costo_estimado,
            'fecha_estimada'     => $request->fecha_estimada,
			'tipo_ticket'        => $request->tipo_ticket ?? null,
            'costo'              => $request->costo_real,
            'fecha'              => $request->fecha_real
        ]);

        if ($request->hasFile('evidencia_inicial')) {
            $fileIden = $request->file('evidencia_inicial');
            $iden = Str::slug(config('app.name') . ' ' . now()) . $fileIden->getClientOriginalName();
            Storage::disk('evidencias')->put("{$iden}", File::get($fileIden));

            $url = 'evidencias/' . $iden;
            $ticket->update([
                'evidenciaInicial' => $url
            ]);
        }

        if ($request->hasFile('evidencia_final')) {
            $fileIden = $request->file('evidencia_final');
            $iden = Str::slug(config('app.name') . ' ' . now()) . $fileIden->getClientOriginalName();
            Storage::disk('evidencias')->put("{$iden}", File::get($fileIden));

            $url2 = 'evidencias/' . $iden;
            $ticket->update([
                'evidenciaFinal' => $url2
            ]);
        }
        // Enviar email

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
    public function guardarImagen(mixed $imagen, String $carpeta)
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
    public function eliminarImagen(String $carpeta, String $nombre_imagen)
    {
        return Storage::disk('ftp_fotostickets')->delete("{$carpeta}/{$nombre_imagen}");
    }
}
