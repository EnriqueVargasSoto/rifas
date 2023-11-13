<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderImage;
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

    public function show($id){
        $order= Order::with('client','order_items.raffle','order_images')->find($id);

        return view('intranet.pages.orders.show',compact('order'));
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
}
