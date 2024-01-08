<?php

namespace App\Http\Controllers\Web\Auth;

use App\Helpers\ApiValidation;
use App\Models\TBUsuario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TBEmpresa;
use App\Models\TBSucursal;
use App\Models\Tickets;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginOutsideController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * Login with QR
     *
     * @param Int $id_empresa
     * @param Int $id_sucursal
     * @return RedirectRoute
     */
    public function qr(Int $id_empresa, Int $id_sucursal)
    {
        Session::remove('invitado');
        $sucursal = TBSucursal::query()
            ->where('id_empresa', $id_empresa)
            ->where('id_sucursal', $id_sucursal)
            ->with(['tb_empresa'])
            ->firstOrFail();

       $user = TBUsuario::query()
            ->where('rol_tickets', 'Invitado')
            ->where('id_empresa', $id_empresa)
            ->where('id_sucursal', $id_sucursal)
            ->first();



        if (!$user) {
            return abort(404);
        }

        auth()->login($user, true);
        Session::put('invitado.empresa', $sucursal->tb_empresa);
        unset($sucursal->tb_empresa);
        Session::put('invitado.sucursal', $sucursal);

        return redirect()->route('web.redirect');
    }

    public function logueo(Int $id_empresa, Int $id_sucursal)
    {
        Session::remove('invitado');
        $sucursal = TBSucursal::query()
            ->where('id_empresa', $id_empresa)
            ->where('id_sucursal', $id_sucursal)
            ->with(['tb_empresa'])
            ->firstOrFail();

        $user = TBUsuario::query()
            ->where('rol_tickets', 'Invitado')
            ->where('id_empresa', $id_empresa)
            ->where('id_sucursal', $id_sucursal)
            ->first();



        if (!$user) {
            return abort(404);
        }

        auth()->login($user, true);
        Session::put('invitado.empresa', $sucursal->tb_empresa);
        unset($sucursal->tb_empresa);
        Session::put('invitado.sucursal', $sucursal);

        $tickets = Tickets::query()
            ->orderBy('id', 'DESC')
            ->get();
 
        return view('dashboard.tickets.index', compact('tickets'));
    }
}
