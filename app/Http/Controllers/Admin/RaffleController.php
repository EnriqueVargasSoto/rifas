<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChangeStatusRaffles;
use App\Models\ChangeStatusRequest;
use App\Models\Payment;
use App\Models\Raffle;
use App\Models\RaffleImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RaffleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $is_visible_in_web = $request->query('is_visible_in_web', '');

        $user_id_1 = $request->query('user_id_1');
        $user_id_2 = $request->query('user_id_2');
        $user_id_3 = $request->query('user_id_3');
        $status = $request->query('status');

        $raffles = Raffle::with('firstUser', 'secondUser', 'thirdUser', 'raffleImages')
            ->byStatus($status)
            ->byFirstUser($user_id_1)
            ->bySecondUser($user_id_2)
            ->byThirdUser($user_id_3)
            ->byIsVisibleInWeb($is_visible_in_web)
            ->bySearch($search)
            ->paginate(12);

        $users = User::orderBy('name', 'asc')->get();
        return view('intranet.pages.raffles.index', compact('raffles', 'search', 'users', 'is_visible_in_web', 'user_id_1', 'user_id_2', 'user_id_3', 'status'));
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
        try {
            $raffle = new Raffle();
            $raffle->status = "Stock";
            $raffle->number = $request->input('number');
            $raffle->code = $request->input('code');
            $raffle->is_visible_in_web = $request->input('is_visible_in_web', 0);
            $raffle->is_active = $request->input('is_active', 1);
            $raffle->price = $request->input('price', 10);
            $raffle->user_id_1 = $request->input('user_id_1');
            $raffle->user_id_2 = $request->input('user_id_2');
            $raffle->user_id_3 = $request->input('user_id_3');
            $raffle->save();
            return redirect()->route('rifas.index')->with('success', 'Rifa creada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('rifas.index')->with('error', 'Error al crear la rifa: ' . $e->getMessage());
        }
    }


    public function storeFile(Request $request)
    {
        try {
            $request->validate([
                'raffle_id' => 'required'
            ]);

            $raffle = Raffle::find($request->input('raffle_id'));
            $raffleImage = $request->file('image');
            $path = $raffleImage->store('/raffles');

            $raffleImage = new RaffleImage();
            $raffleImage->raffle_id = $raffle->id;
            $raffleImage->image_url = $path;
            $raffleImage->save();

            return redirect()->route('rifas.index')->with('success', 'Imagen subida correctamente');
        } catch (\Exception $e) {
            return redirect()->route('rifas.index')->with('error', 'Error al subir imagen: ' . $e->getMessage());
        }
    }

    public function deleteFile(Request $request, $id)
    {

        try {

            $raffleImage = RaffleImage::find($id);

            if ($raffleImage->image_url) {
                // Eliminar el archivo de almacenamiento
                Storage::delete($raffleImage->image_url);
            }

            $raffleImage->delete();
            return redirect()->route('rifas.index')->with('success', 'Imagen eliminada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('rifas.index')->with('error', 'Error al eliminar imagen: ' . $e->getMessage());
        }
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
        try {
            $raffle = Raffle::find($id);
            $raffle->status = $request->input('status');
            $raffle->number = $request->input('number');
            $raffle->code = $request->input('code');
            $raffle->is_visible_in_web = $request->input('is_visible_in_web', 0);
            $raffle->is_active = $request->input('is_active', 1);
            $raffle->price = $request->input('price', 10);
            $raffle->user_id_1 = $request->input('user_id_1');
            $raffle->user_id_2 = $request->input('user_id_2');
            $raffle->user_id_3 = $request->input('user_id_3');
            $raffle->save();

            return redirect()->route('rifas.index')->with('success', 'Rifa actualizada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('rifas.index')->with('error', 'Error al actualizar la rifa: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $raffle = Raffle::find($id);
            $raffle->delete();

            return redirect()->route('rifas.index')->with('success', 'Rifa eliminada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('rifas.index')->with('error', 'Error al eliminar la rifa: ' . $e->getMessage());
        }
    }


    public function status(Request $request)
    {
        $search = $request->query('search');
        $is_visible_in_web = $request->query('is_visible_in_web', '');

        $user_id_1 = $request->query('user_id_1');
        $user_id_2 = $request->query('user_id_2');
        $user_id_3 = $request->query('user_id_3');
        $status = $request->query('status',[]);
        $start = $request->query('start');
        $end = $request->query('end');

        $paginateRows = 12;

        if ($start && $end) {
            $paginateRows = 500;
        }

        $raffles = Raffle::with('firstUser', 'secondUser', 'thirdUser', 'raffleImages')
            ->byStatus2($request->query('status',[]))
            ->bySearch($search)
            ->betweenNumber($start, $end)
            ->byRoleUser()
            ->paginate($paginateRows);

        $users = User::orderBy('name', 'asc')->get();

        return view('intranet.pages.raffles.status', compact('raffles', 'status', 'users', 'search', 'is_visible_in_web', 'user_id_1', 'user_id_2', 'user_id_3', 'start', 'end'));
    }


    public function requestChangeStatus(Request $request)
    {
        try {

            $request->validate([
                'status' => 'required|in:Liquidada,Stock,Fiada,Pagada,Reservada'
            ]);

            if (!count($request->input('selectedItems', []))) {
                return redirect()->route('rifas.status')->with('error', 'Debe seleccionar al menos una rifa');
            }

            $rafflesLiquided = Raffle::whereIn('id', $request->input('selectedItems'))->where('status', 'Liquidada')->exists();
            if($rafflesLiquided){
                return redirect()->route('rifas.status')->with('error', 'No se puede cambiar el estado de una o mas rifas que ya se encuentra liquidada');
            }

            $rafflesPendingAprobation = Raffle::whereIn('id', $request->input('selectedItems'))->where('status', 'Por aprobar')->exists();
            if ($rafflesPendingAprobation) {
                return redirect()->route('rifas.status')->with('error', 'No se puede liquidar seleccionaste una o mas rifas que ya se encuentra por aprobar');
            }

            // $rafflesPagada = Raffle::whereIn('id', $request->input('selectedItems'))->where('status', 'Pagada')->exists();
            // if ($rafflesPagada && $request->input('status') == "Stock") {
            //     return redirect()->route('rifas.status')->with('error', 'No se puede devolver a stock una o mas rifas que ya se encuentra pagada');
            // }

            $transactionIdRegistred = Payment::where('transaction_id', $request->input('transaction_id'))->first();
            if ($transactionIdRegistred) {
                return redirect()->route('rifas.status')->with('error', 'El número de transacción ya se encuentra registrado');
            }

            $changeStatusRequest = new ChangeStatusRequest();
            $changeStatusRequest->status_request = $request->input('status');
            $changeStatusRequest->status = $request->input('status') == "Liquidada" ? "Pendiente" : "Aprobado";
            $changeStatusRequest->user_id = auth('web')->user()->id;
            $changeStatusRequest->user_id_gestion = auth('web')->user()->id;
            $changeStatusRequest->transaction_id = $request->input('transaction_id');
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $path = $image->store('/change-status-requests');
                $changeStatusRequest->image_url = $path;
            }
            $changeStatusRequest->save();



            $rafles = Raffle::whereIn('id', $request->input('selectedItems'))->get();

            foreach ($rafles as $raffle) {
                $changeStatusRaffle = new ChangeStatusRaffles();
                $changeStatusRaffle->raffle_id = $raffle->id;
                $changeStatusRaffle->change_status_request_id = $changeStatusRequest->id;
                $changeStatusRaffle->before_status = $raffle->status;
                $changeStatusRaffle->after_status = $request->input('status');
                $changeStatusRaffle->save();


                if($changeStatusRequest->status_request != "Liquidada"){
                    $raffle->status = $request->input('status');
                    // $raffle->transaction_liquidation_id = $request->input('transaction_id');
                    // $raffle->liquidation_at = now();
                    $raffle->save();

                    // $paymentExists = Payment::where('raffle_id', $raffle->id)->first();

                    // if (!$paymentExists) {
                    //     $payment = new Payment();
                    //     $payment->transaction_id = $request->input('transaction_id');
                    //     $payment->user_id = auth('web')->user()->id;
                    //     $payment->total = $raffle->price;
                    //     $payment->raffle_id = $raffle->id;
                    //     $payment->model = "raffle";
                    //     $payment->payment_at = now();
                    //     $payment->image_payment_url = $changeStatusRequest->image_url;
                    //     $payment->save();
                    // }
                }else{
                    $raffle->status="Por aprobar";
                    $raffle->save();
                }

            }



            return redirect()->route('rifas.status')->with('success', 'Rifa actualizada correctamente');
        } catch (\Exception $e) {
            return redirect()->route('rifas.status')->with('error', 'Error al actualizar la rifa: ' . $e->getMessage());
        }
    }



}
