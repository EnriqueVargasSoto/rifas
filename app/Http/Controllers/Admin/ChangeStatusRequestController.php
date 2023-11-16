<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChangeStatusRequest;
use App\Models\Raffle;
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

        $changeStatusRequests = ChangeStatusRequest::with('user', 'userGestion')
            ->withCount('changeStatusRaffles')            
            ->byUserId($request->query('user_id'))
            ->orderBy('created_at', 'desc')->paginate(12);

        $users = User::all();
        return view('intranet.pages.change_status_request.index', compact('changeStatusRequests', 'users'));
    }


    public function changeStatusRequest(Request $request)
    {

        $changeStatusRequest = ChangeStatusRequest::find($request->id);
        if($changeStatusRequest->status_request!="Liquidada"){
            return redirect()->route('change-status-requests.index')->with('error', 'No se puede cambiar el estado de la solicitud solo esta permitido cambiar el estado de las solicitudes que esten liquidadas');
        }

        if ($request->status == $changeStatusRequest->status) {
            return redirect()->route('change-status-requests.index')->with('success', 'Se ha cambiado el estado de la solicitud');
        }

        if($changeStatusRequest->status=="Aprobado"  && $request->status=="Rechazado"){
            return redirect()->route('change-status-requests.index')->with('error', 'No se puede cambiar el estado de la solicitud a rechazado ya que esta aprobado');
        }

        $changeStatusRequest->status = $request->status;
        $changeStatusRequest->user_id_gestion = auth('web')->user()->id;
        $changeStatusRequest->save();



        $changeStatusRaffles = $changeStatusRequest->changeStatusRaffles;
        if ($changeStatusRequest->status == "Aprobado") {
            foreach ($changeStatusRaffles as $changeStatusRaffle) {
                $raffle = Raffle::find($changeStatusRaffle->raffle_id);
                $raffle->status = "Liquidada";
                $raffle->transaction_liquidation_id = $changeStatusRequest->transaction_id;
                $raffle->liquidation_at = now();
                $raffle->user_id = $changeStatusRequest->user_id;
                $raffle->save();
            }
        }

        return redirect()->route('change-status-requests.index')->with('success', 'Se ha cambiado el estado de la solicitud');
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
    public function requestChangeStatusDetail(Request $request, $id)
    {
        $changeStatusRequest = ChangeStatusRequest::with('changeStatusRaffles.raffle')->find($id);
        return view('intranet.pages.change_status_request.show', compact('changeStatusRequest'));
    }
}
