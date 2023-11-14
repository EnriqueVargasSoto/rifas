<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class RegisterClientController extends Controller
{



    public function showClientRegisterForm()
    {
        return view('register-client');
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required',
                'password' => 'required',
            ]);

            $emailRegistred = Client::where('phone', $request->input('phone'))->first();
            if ($emailRegistred) {
                $credentials = $request->only('phone', 'password');
                if (auth()->guard('client')->attempt($credentials)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/')->with('success', 'Bienvenido');
                }

                return back()->with('error', 'Usuario o contraseña incorrectos');
            }

            $client = new Client();
            $client->name = "#" . $request->input('phone');
            $client->last_name = "";
            $client->phone = $request->input('phone');
            $client->address = $request->input('address');
            $client->password = bcrypt($request->input('password'));
            $client->clave = $request->input('password');
            $client->save();

            $credentials = $request->only('phone', 'password');
            if (auth()->guard('client')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', 'Bienvenido');
            }

            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar' . $e->getMessage());
        }
    }


    public function showClientUpdateForm()
    {
        $client = Client::find(auth()->guard('client')->user()->id);
        return view('update-client', compact('client'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'last_name' => 'required',
                'phone' => 'required'
            ]);

            $client = Client::find(auth()->guard('client')->user()->id);
            $client->name = $request->input('name');
            $client->last_name = $request->input('last_name');
            $client->phone = $request->input('phone');
            $client->address = $request->input('address');
            if ($request->input('password')) {
                $client->password = bcrypt($request->input('password'));
                $client->clave = $request->input('password');
            }
            $client->save();

            return redirect()->back()->with('success', 'Datos actualizados exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar' . $e->getMessage());
        }
    }
}
