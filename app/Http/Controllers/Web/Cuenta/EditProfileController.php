<?php

namespace App\Http\Controllers\Web\Cuenta;

use App\Helpers\SweetAlert2;
use App\Http\Controllers\Controller;
use App\Models\TBUsuario;
use Illuminate\Http\Request;

class EditProfileController extends Controller
{
    public function __construct()
    {
        //
    }

    public function view()
    {
        return view('cuenta.editar-perfil');
    }

    public function post(Request $request)
    {
        $auth = auth()->user();
        $request->validate([
            'email' => ['required', "unique:EV_SUMAPP.tb_usuario,correo,$auth->id_usuario,id_usuario"],
        ]);

        TBUsuario::where('id_usuario', $auth->id_usuario)
            ->update([
                'correo' => $request->email
            ]);

        return back()->with(SweetAlert2::success('Se ha actualizado tu información correctamente'));
    }
}
