<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $auth = Auth()->user();
        switch ($auth->role_id) {
            case 1:
                # code...
                return redirect()->route('users.index');
                break;

            default:
                # code...
                return view('home');
                break;
        }

    }
}
