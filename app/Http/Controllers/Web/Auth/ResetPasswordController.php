<?php

namespace App\Http\Controllers\Web\Auth;

use App\Helpers\ConsoleLog;
use Illuminate\Http\Request;

use App\Rules;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\SweetAlert2;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Crypt, Log, Mail, Validator};
use App\Models\{TBUsuario, PasswordResets};
use App\Mail\Password as PasswordMail;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Password as PasswordRequest;
use Illuminate\Contracts\Encryption\DecryptException;

class ResetPasswordController extends Controller
{
    public function view()
    {
        return view('auth.passwords.email');
    }

    public function send_email(Request $request)
    {
        $request->validate([
            'g-recaptcha-response' => [new Rules\Recaptcha()],
            'email' => ['required', 'string', new Rules\Auth()]
        ]);

        $usuario = TBUsuario::query()
            ->where('correo', $request->email)
            ->first();

        $buscar_token = PasswordResets::query()
            ->where('email', $usuario->correo)
            ->first();

        if ($buscar_token) {
            $tiempo_restante = $this->checkTheRemainingTimeOfExpiration($buscar_token->created_at);
            if ($tiempo_restante > 0) {
                $label = $tiempo_restante > 1 ? 'minutos' : 'minutos';
                return back()
                    ->with(SweetAlert2::warning("Ya se ha solicitado reestablecer la contraseña del correo electrónico '{$buscar_token->email}', por lo que hay que esperar {$tiempo_restante} {$label} para poder realizar una nueva petición"));
            } else {
                $buscar_token->delete();
            }
        }

        $registrar_token = PasswordResets::create([
            'email' => $request->email,
            'token' => Str::random(64)
        ]);

        try {
            Mail::to($usuario->correo)->send(new PasswordMail\Reset($usuario, $registrar_token->token));
        } catch (\Throwable $e) {
            $registrar_token->delete();
            Log::critical("El servició de correos electrónicos no está funcionando en reset password: $e");
            return back()->with(array_merge(
                SweetAlert2::error('Ocurrió un error inesperado #01'),
                ConsoleLog::error($e)
            ));
        }

        return back()->with(SweetAlert2::success("Se ha enviado un enlace al correo electrónico '{$usuario->correo}' para poder reestablecer la contraseña"));
    }

    public function get_token($token)
    {
        try {
            $token_decrypted = Crypt::decrypt($token);
        } catch (DecryptException $e) {
            return back()->with(SweetAlert2::error('El token es inválido'));
        }

        $buscar_token = PasswordResets::query()
            ->where('token', $token_decrypted)
            ->first();

        if (!$buscar_token) {
            return back()->with(SweetAlert2::error('El token ya expiró #01'));
        }

        $tiempo_restante = $this->checkTheRemainingTimeOfExpiration($buscar_token->created_at);
        if ($tiempo_restante == 0) {
            $buscar_token->delete();
            return back()->with(SweetAlert2::error('El token ya expiró #02'));
        }

        $usuario = TBUsuario::query()
            ->where('correo', $buscar_token->email)
            ->first();

        if (!$usuario) {
            $buscar_token->delete();
            return back()->with(SweetAlert2::error('El token ya expiró #03'));
        }

        return view('auth.passwords.token', compact('usuario', 'token'));
    }

    public function reset(Request $request)
    {
        try {
            $token_decrypted = Crypt::decrypt($request->token);
        } catch (DecryptException $e) {
            return back()->with(SweetAlert2::error('El token es inválido'));
        }

        $buscar_token = PasswordResets::query()
            ->where('token', $token_decrypted)
            ->first();

        if (!$buscar_token) {
            return back()->with(SweetAlert2::error('El token ya expiró #01'));
        }

        $usuario = TBUsuario::query()
            ->where('correo', $buscar_token->email)
            ->first();

        if (!$usuario) {
            $buscar_token->delete();
            return back()->with(SweetAlert2::error('El token ya expiró #02'));
        }

        Validator::make($request->all(), PasswordRequest\Store::rules())->validate();

        if ($request->password == $usuario->contrasena) {
            throw ValidationException::withMessages(['password' => 'La nueva contraseña no puede ser la misma que la anterior']);
        }

        $usuario->update(['contrasena' => $request->password]);

        $buscar_token->delete();
        return redirect()->route('web.auth.login.view')->with(SweetAlert2::success('Se ha reestablecido tu contraseña'));
    }

    public function checkTheRemainingTimeOfExpiration(Carbon $created_at)
    {
        $tiempo_indicado_de_expiracion_en_minutos = config('app.mail_toggle.reset_password_expiration_in_minutes');
        $tiempo_transcurrido_en_minutos = $created_at->diffInMinutes(now());
        if ($tiempo_transcurrido_en_minutos < $tiempo_indicado_de_expiracion_en_minutos) {
            $resultado = $tiempo_indicado_de_expiracion_en_minutos - $tiempo_transcurrido_en_minutos;
        } else {
            $resultado = 0;
        }
        return $resultado;
    }
}
