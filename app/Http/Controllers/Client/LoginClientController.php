<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginClientController extends Controller
{



    public function showClientLoginForm()
    {
        return view('login-client');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('phone', 'password');
            if (auth()->guard('client')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', 'Bienvenido');
            }

            return back()->with('error', 'Usuario o contraseña incorrectos');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al iniciar sesion' . $e->getMessage());
        }
    }


    public function logout(Request $request)
    {
        auth()->guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    
}
