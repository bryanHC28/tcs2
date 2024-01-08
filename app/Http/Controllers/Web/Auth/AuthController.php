<?php

namespace App\Http\Controllers\Web\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TBUsuario;
use Illuminate\Validation\ValidationException;
use App\Rules;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function login_post(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => [new Rules\Recaptcha()],
            'email'    => ['required', 'string', new Rules\Auth()],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean']
        ]);

        $user = TBUsuario::query()
            ->where('correo', $request->email)
            ->first();

        if ($request->password != $user->contrasena) {
            throw ValidationException::withMessages(['password' => 'La contraseña es incorrecta']);
        }

        auth()->login($user, ($request->remember == 1 ? true : false));
        return redirect()->route('web.redirect');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('web.auth.login.view');
    }
}
