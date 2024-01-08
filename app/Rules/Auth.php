<?php

namespace App\Rules;

use App\Models\TBUsuario;
use Illuminate\Contracts\Validation\Rule;

class Auth implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = TBUsuario::query()
            ->where('correo', $value)
            ->first();

        /**
         * No existe el usuario
         */
        if (!$user) {
            return false;
        }

        /**
         * El usuario no tiene tipo cuenta
         */
        if ($user->tipo_cuenta == null xor $user->tipo_cuenta == '') {
            return false;
        }

        /**
         * El usuario no tiene tickets
         */
        $verify = substr($user->tipo_cuenta, -3);
        if ($verify == '_st') {
            return false;
        }

        /**
         * El usuario no tiene rol tickets
         */
        if ($user->rol_tickets == null xor $user->rol_tickets == '') {
            return false;
        }

        /**
         * El usuario es de tipo invitado
         */
        if ($user->rol_tickets == 'Invitado') {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.user_login');
    }
}
