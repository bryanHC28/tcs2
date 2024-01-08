<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    //


    public function login(Request $request){

        $email = 'pruebamultiserle@correo.com';
        $password = '123';

      
        $login= DB::table('tb_usuario')
                ->where('correo', '=', $email)
                ->where('contrasena', '=', $password)
                ->get();
                

         Auth::login($login[0]->correo);

         return redirect()->intended('home');


    }
}
