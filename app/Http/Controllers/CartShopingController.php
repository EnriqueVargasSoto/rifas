<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartShopingController extends Controller
{
    //

    public function index()
    {
        // Recupera los productos almacenados en la sesión
        $cartItems = session('cart', []);
        $raffles = Raffle::whereIn('id', $cartItems)->get();

        // Calcula el total utilizando el método sum
        $total = $raffles->sum('price');

        return view('cart', compact('cartItems', 'raffles', 'total'));
    }

    public function addItem(Request $request)
    {
        $productId = $request->input('id');

        // Recupera los productos almacenados en la sesión
        $cartItems = session('cart', []);

        // verifica si el producto ya existe en el carrito

        if (in_array($productId, $cartItems)) {
            return back()->with('error-add-cart', 'El producto ya existe en el carrito');
        }

        // Agrega el nuevo producto al carrito
        $cartItems  = array_merge($cartItems, [$productId]);

        // Actualiza la sesión con los nuevos productos
        session(['cart' => $cartItems]);

        return back()->with('success-add-cart', 'Producto agregado al carrito');
    }

    public function removeItem($id)
    {
        // Recupera los productos almacenados en la sesión
        $cartItems = session('cart', []);

        // Busca la posición del producto en el array

        $index = array_search($id, $cartItems);

        // si el producto no existe en el carrito, redirecciona

        if ($index === false) {
            return redirect()->route('cart.index')->with('error-delete-cart', 'Producto no encontrado en el carrito');
        }


        // Si el producto existe en el carrito, lo eliminamos
        if ($index !== false) {
            unset($cartItems[$index]);
        }

        // Actualiza la sesión con los productos actualizados
        session(['cart' => $cartItems]);

        return redirect()->route('cart.index')->with('success-delete-cart', 'Producto eliminado del carrito');
    }

    public function checkout(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required',
                'last_name' => 'required',
                'identity_number' => 'required',
                'phone' => 'required'
            ]);

            DB::beginTransaction();

            $shoppingCartItems = session('cart', []);
            $raffles = Raffle::whereIn('id', $shoppingCartItems)->get();
            $total = $raffles->sum('price');


            if(!$raffles->count()){
                return redirect()->route('cart.index')->with('error-checkout', 'No hay productos en el carrito')->withInput();
            }

            $pathImage = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::uuid() . $image->getClientOriginalName();
                $pathImage = "images/payments/" . $imageName;
                Storage::put($pathImage, file_get_contents($image));
            }

            // Verifica si el cliente ya existe en la base de datos por su número de identidad
            $client = Client::where('identity_number', $request->input('identity_number'))->first();
            if (!$client) {
                $client = new Client();
                $client->name = $request->input('name');
                $client->last_name = $request->input('last_name');
                $client->identity_number = $request->input('identity_number');
                $client->phone = $request->input('phone');
                $client->email = $request->input('email');
                $client->address = $request->input('address');
                $client->save();
            }

            // Guarda el cliente en la base de datos si no existe 
            $order = new Order();
            $order->client_id = $client->id;
            $order->total = $total;
            $order->payment_method = $request->input('payment_method');
            $order->image_payment_url = $pathImage;
            $order->status = 'reservado';
            $order->save();

            foreach ($raffles as $raffle) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->raffle_id = $raffle->id;
                $orderItem->quantity = 1;
                $orderItem->price = $raffle->price;
                $orderItem->total = $raffle->price;
                $orderItem->status = 'reservado';
                $orderItem->save();

                // Actualiza el estado de la rifa a reservado y le asigna el id del item de la orden
                $raffle->status = 'Reservada';
                $raffle->order_item_id = $orderItem->id;
                $raffle->order_id = $order->id;
                $raffle->save();
            }

            // Elimina los productos del carrito
            session(['cart' => []]);
            DB::commit();


            return redirect()->route('cart.index')->with('success-checkout', 'Compra realizada con éxito puede ver el estado de su compra en la sección de mis compras');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('cart.index')->with('error-checkout', 'Error al realizar la compra' . $e->getMessage())->withInput();
        }
    }
}
