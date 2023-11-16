<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search =  $request->query('search');
        $users = User::search($search)->paginate(12);
        return view('intranet.pages.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('intranet.pages.users.update', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(!$request->password){
            return back()->with('error', 'La contraseña es obligatoria');
        }
        //
        $user = User::find($id);
        $user->name = $request->name;
        $user->dni  = $request->dni;
        $user->short_name = $request->short_name;
        $user->phone = $request->phone;
        $user->unit = $request->unit;
        $user->area = $request->area;
        $user->position = $request->position;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->clave = $request->password;
        $user->address = $request->address;

        if ($request->observation) {
            $user->observation = $request->observation;
        }
        if(in_array($request->input('show_information_in_web'),[0,1])){
            $user->show_information_in_web = $request->input('show_information_in_web', 0);
        }

        $user->save();

        if ($user->show_information_in_web == 1) {
            User::where('id', '!=', $user->id)->update(['show_information_in_web' => 0]);
        }

        return back()->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
