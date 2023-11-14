<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderImage;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{


    public function index(Request $request)
    {
        $search = $request->query('search');
        $orders = Order::leftJoin('clients', 'clients.id', '=', 'orders.client_id')
            ->select('orders.*', 'clients.name as client_name', 'clients.last_name as client_last_name', 'clients.phone as client_phone')
            ->search($search)
            ->paginate(10);

        return view('intranet.pages.orders.index', compact('orders', 'search'));
    }

    public function show($id)
    {
        $order = Order::with('client', 'order_items.raffle', 'order_images')->find($id);
        $payments = Payment::where('order_id', $order->id)->where('model', 'order')->get();
        $totalPaid  = $payments->sum('total');
        return view('intranet.pages.orders.show', compact('order', 'payments', 'totalPaid'));
    }

    public function storeFile(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required',
                'type' => 'required|in:raffle,invoice,payment'
            ]);

            $raffleImage = $request->file('image');
            $path = $raffleImage->store('/raffles');

            $raffleImage = new OrderImage();
            $raffleImage->order_id = $request->order_id;
            $raffleImage->image_url = $path;
            $raffleImage->type = $request->type;
            $raffleImage->save();

            return redirect()->back()->with('success', 'Imagen subida correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al subir imagen: ' . $e->getMessage());
        }
    }

    public function deleteFile(Request $request, $id)
    {

        try {

            $raffleImage = OrderImage::find($id);

            if ($raffleImage->image_url) {
                // Eliminar el archivo de almacenamiento
                Storage::delete($raffleImage->image_url);
            }

            $raffleImage->delete();
            return redirect()->back()->with('success', 'Imagen eliminada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar imagen: ' . $e->getMessage());
        }
    }


    public function changeStatus(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required',
                'status' => 'required|in:reservado,aprobado,cancelado'
            ]);

            $order = Order::find($request->order_id);
            if ($order->status == "cancelado") {
                return redirect()->back()->with('error', 'No se puede cambiar el estado de una orden cancelada');
            }

            $order->transaction_id = $request->input('transaction_id');
            $order->rejection_reason = $request->input('rejection_reason');
            $order->status = $request->status;
            $order->save();

            if ($request->status == "cancelado") {
                $orderItems = $order->order_items();
                foreach ($orderItems as $orderItem) {
                    $raffle = $orderItem->raffle;
                    $raffle->status = "Stock";
                    $raffle->reserved_at = null;
                    $raffle->save();

                    $payment = Payment::where('order_id', $order->id)->where('raffle_id', $raffle->id)->first();
                    if ($payment) {
                        $payment->delete();
                    }
                }

                return redirect()->back()->with('success', 'Orden cancelada correctamente');
            }


            $amountPaid = $request->input('amount_paid');
            $paymentStatus = $amountPaid == $order->total ? "Pagada" : "Fiada";
            $paymentAt = $request->input('payment_at');

            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->raffle_id = null;
            $payment->client_id = $order->client_id;
            $payment->total = $amountPaid;
            $payment->payment_method = $order->payment_method;
            $payment->transaction_id = $order->transaction_id;
            $payment->image_payment_url = $order->image_payment_url;
            $payment->payment_at = $paymentAt;
            $payment->model = "order";
            $payment->save();


            $orderItems = $order->order_items();
            foreach ($orderItems as $orderItem) {
                $raffle = $orderItem->raffle;
                $raffle->status = $paymentStatus;
                $raffle->save();

                if ($paymentStatus == "Pagada") {
                    $payment = new Payment();
                    $payment->order_id = $order->id;
                    $payment->raffle_id = $raffle->id;
                    $payment->client_id = $order->client_id;
                    $payment->total = $raffle->price;
                    $payment->payment_method = $order->payment_method;
                    $payment->transaction_id = $order->transaction_id;
                    $payment->image_payment_url = $order->image_payment_url;
                    $payment->payment_at = $paymentAt;
                    $payment->model = "raffle";
                    $payment->save();
                }
            }
            return redirect()->back()->with('success', 'Orden aporbada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar estado: ' . $e->getMessage());
        }
    }

    public function storePayment(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required',
                'amount_paid' => 'required',
                'payment_method' => 'required',
                'transaction_id' => 'required',
                'payment_at' => 'required'
            ]);

            $order = Order::find($request->order_id);

            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->raffle_id = null;
            $payment->client_id = $order->client_id;
            $payment->total = $request->amount_paid;
            $payment->payment_method = $request->payment_method;
            $payment->transaction_id = $request->transaction_id;
            $payment->payment_at = $request->payment_at;
            $payment->model = "order";

            if ($request->hasFile('image')) {
                $paymentImage = $request->file('image');
                $path = $paymentImage->store('/raffles');
                $payment->image_payment_url = $path;
            }

            $payment->save();


            $paymentsOrder = Payment::where('order_id', $order->id)->where('model', 'order')->get();
            $totalPaid  = $paymentsOrder->sum('total');

            if ($totalPaid >= $order->total) {
                if ($order->status == "aprobado") {
                    foreach ($order->order_items as $orderItem) {
                        $raffle = $orderItem->raffle;
                        $raffle->status = "Pagada";
                        $raffle->save();

                        $paymentExists = Payment::where('order_id', $order->id)->where('raffle_id', $raffle->id)->first();
                        if(! $paymentExists){
                            $payment = new Payment();
                            $payment->order_id = $order->id;
                            $payment->raffle_id = $orderItem->raffle_id;
                            $payment->client_id = $order->client_id;
                            $payment->total = $orderItem->raffle->price;
                            $payment->payment_method = $order->payment_method;
                            $payment->transaction_id = $order->transaction_id;
                            $payment->image_payment_url = $order->image_payment_url;
                            $payment->payment_at = $request->payment_at;
                            $payment->model = "raffle";
                            $payment->save();
                        }
                    }
                }
            }

            return redirect()->back()->with('success', 'Pago registrado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al registrar pago: ' . $e->getMessage());
        }
    }
}
