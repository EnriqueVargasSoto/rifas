<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use Illuminate\Http\Request;

class RaffleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $start = $request->query('start');
        $end = $request->query('end');

        $rafflesInCart = session('cart', []); // Recupera los productos almacenados en la sesión    

        $raffles = Raffle::byStatus("stock")
                           ->betweenNumber($start, $end)
                           ->byIsVisibleInWeb(1)
                           ->bySearch($search) 
                           ->whereNotIn('id', $rafflesInCart)
                           ->paginate(20);

        return view('welcome', compact('raffles', 'search', 'start', 'end'));
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
