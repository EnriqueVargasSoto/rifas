<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PurchaseController extends Controller
{
    //
    public function index(Request $request)
    {
        $orders = Order::with('order_items.raffle','order_images')->where('client_id', auth()->guard('client')->user()->id)->get();
        $client = auth()->guard('client')->user();
        return view('purchases', compact('orders', 'client'));
    }


    public function storeInvoicePaymentImage(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required'
            ]);

            $raffleImage = $request->file('image');
            $path = $raffleImage->store('/raffles');

            $raffleImage = new OrderImage();
            $raffleImage->order_id = $request->order_id;
            $raffleImage->image_url = $path;
            $raffleImage->save();

            return redirect()->route('purchases.index')->with('success', 'Imagen subida correctamente'); 

        } catch (\Exception $e) {
            return redirect()->route('purchases.index')->with('error', 'Error al subir imagen: ' . $e->getMessage());
        }
    }

    public function deleteInvoicePaymentImage(Request $request, $id)
    {

        try {

            $raffleImage = OrderImage::find($id);

            if ($raffleImage->image_url) {
                // Eliminar el archivo de almacenamiento
                Storage::delete($raffleImage->image_url);
            }

            $raffleImage->delete();
            return redirect()->route('purchases.index')->with('success', 'Imagen eliminada correctamente');

        } catch (\Exception $e) {
            return redirect()->route('purchases.index')->with('error', 'Error al eliminar imagen: ' . $e->getMessage());
        }
    }
}
