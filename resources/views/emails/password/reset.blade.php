@component('mail::message')
# Recupera tu contraseña

Hola {{ $usuario->nombre_completo }}, te enviamos este correo ya que solicitaste
recuperar tu contraseña si no reconoces esta solicitud elimina este mensaje,
en caso contrario da clic en el botón de abajo para continuar con la operación:

@component('mail::button', ['url' => route('web.auth.reset_password.token_view', ['token' => $token])])
Reestablecer contraseña
@endcomponent

<br>
Saludos,<br>
{{ config('app.company') }}
@endcomponent
