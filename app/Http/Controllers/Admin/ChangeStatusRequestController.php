<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChangeStatusRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ChangeStatusRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        $changeStatusRequests = ChangeStatusRequest::with('user')->byUserId($request->query('user_id'))
            ->orderBy('created_at', 'desc')->paginate(12);
        
        $users= User::all();
        return view('intranet.pages.change_status_request.index', compact('changeStatusRequests', 'users'));
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
    public function show(ChangeStatusRequest $changeStatusRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChangeStatusRequest $changeStatusRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChangeStatusRequest $changeStatusRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChangeStatusRequest $changeStatusRequest)
    {
        //
    }
}
