<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserRegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function showRegistrationUserForm()
    {
        return view('register-user');
    }

    public function showRegistrationAdminForm()
    {
        return view('register-admin');
    }

    public function userRegister(Request $request)
    {
        $users = User::create([
            'role_id' => 2,
            'name' => $request->input('name'),
            'dni' => $request->input('dni'),
            'short_name' => $request->input('short_name'),
            'phone' => $request->input('phone'),
            'unit' => $request->input('unit'),
            'area' => $request->input('area'),
            'position' => $request->input('position'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'clave' => $request->input('password'),
            'observation' => $request->input('observation'),
            'address' => $request->input('address')
        ]);
        
        return redirect()->route('login');
    }

    public function adminRegister(Request $request)
    {
        $users = User::create([
            'role_id' => 3,
            'name' => $request->input('name'),
            'dni' => $request->input('dni'),
            'short_name' => $request->input('short_name'),
            'phone' => $request->input('phone'),
            'unit' => $request->input('unit'),
            'area' => $request->input('area'),
            'position' => $request->input('position'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'clave' => $request->input('password'),
            'observation' => $request->input('observation'),
            'address' => $request->input('address')
        ]);

        return redirect()->route('login');
    }
}
