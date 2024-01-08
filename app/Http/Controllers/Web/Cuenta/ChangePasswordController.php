<?php

namespace App\Http\Controllers\Web\Cuenta;

use App\Models\Usuarios;
use App\Helpers\SweetAlert2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TBUsuario;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        //
    }

    public function view()
    {
        return view('cuenta.cambiar-contraseña');
    }

    public function post(Request $request)
    {
        $auth = auth()->user();
        $request->validate([
            'current_password' => ['required', 'current_password:web'],
            'new_password' => ['required', 'min:6', 'confirmed'],
        ]);

        TBUsuario::where('id_usuario', $auth->id_usuario)
            ->update([
                'contrasena' => $request->new_password
            ]);

        return back()->with(SweetAlert2::success('Se ha actualizado tu contraseña correctamente'));
    }
}
