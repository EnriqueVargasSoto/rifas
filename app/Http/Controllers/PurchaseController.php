<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    //
    public function index(Request $request)
    {
        $identity_number = $request->query('identity_number');
        $client = Client::where('identity_number',$identity_number)->first();
        if (!$client) {
            return view('purchases', [
                'orders' => [],
                'client' => null,
                'client_not_found' => $identity_number ? true : false,
                'identity_number'=> $identity_number
            ]);
        }

        $client_not_found = false;
        $orders = Order::with('order_items.raffle')->where('client_id', $client->id)->get();
        return view('purchases', compact('orders', 'client','client_not_found','identity_number'));
    }
}
