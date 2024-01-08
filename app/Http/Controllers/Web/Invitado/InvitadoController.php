<?php

namespace App\Http\Controllers\Web\Invitado;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Resources\TicketsController;
use Illuminate\Http\Request;
use App\Models\TCSTransmitio;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class InvitadoController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Muestra la vista de generar ticket
     */
    public function index()
    {
        $session = Session::get('invitado');
        $areas = Http::get(url("api/resources/areas/{$session['sucursal']['id_sucursal']}"));
        $transmitio= TCSTransmitio::get();
        if ($areas->ok()) {
            $areas = $areas->object();
        } else {
            $areas = [];
        }

        return view('invitado.ticket', compact(
            'session',
            'areas',
            'transmitio'
        ));
    }

    /**
     * Genera ticket
     */
    public function generar(Request $request)
    {
        return TicketsController::store($request);
    }
}
