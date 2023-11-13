<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $clients = Client::search($search)->paginate(12);
        return view('intranet.pages.clients.index', compact('clients', 'search'));
    }


    public function update(Request $request,$id){
        try {
            $client = Client::find($id);
            $client->name = $request->input('name');
            $client->last_name = $request->input('last_name');
            $client->phone = $request->input('phone');
            $client->address = $request->input('address');
            $client->password = bcrypt($request->input('password'));
            $client->clave = $request->input('password');
            $client->observation = $request->input('observation');
            $client->save();
            return redirect()->route('clients')->with('success', 'Cliente actualizado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar' . $e->getMessage());
        }
    }
}
