<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Raffle;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CartShopingController extends Controller
{
    //

    public function index()
    {
        if(!auth()->guard('client')->check()){
            return redirect()->route('login-client-view')->with('error-login', 'Debe iniciar sesión para poder comprar');
        }

        $userInformation = User::where('show_information_in_web',1)->first();
        // Recupera los productos almacenados en la sesión
        $cartItems = session('cart', []);
        $raffles = Raffle::whereIn('id', $cartItems)->get();

        // Calcula el total utilizando el método sum
        $total = $raffles->sum('price');

        $orders = Order::with('order_items.raffle','order_images')->where('client_id', auth()->guard('client')->user()->id)->get();

        $orderItemsGroupByStatus=[];
        $orderImages = [];

        foreach ($orders as $order) {
            $orderImages = array_merge($orderImages, $order->order_images->toArray());
            foreach ($order->order_items as $orderItem) {
                $orderItemsGroupByStatus[$order->status][] = $orderItem;
            }
        }

        $client = auth()->guard('client')->user();

        return view('cart', compact('cartItems', 'raffles', 'total','userInformation','client','orderItemsGroupByStatus','orderImages'));
    }

    public function addItem(Request $request)
    {
        if(!auth()->guard('client')->check()){
            return redirect()->route('register-client')->with('error-login', 'Debe iniciar sesión para poder comprar');
        }

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
        if(!auth()->guard('client')->check()){
            return redirect()->route('register-client')->with('error-login', 'Debe iniciar sesión para continuar');
        }

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
        if(!auth()->guard('client')->check()){
            return redirect()->route('login-client-view')->with('error-login', 'Debe iniciar sesión para continuar');
        }

        try {

            DB::beginTransaction();

            $shoppingCartItems = session('cart', []);
            $raffles = Raffle::whereIn('id', $shoppingCartItems)->get();
            $total = $raffles->sum('price');

            if(!$raffles->count()){
                return redirect()->route('cart.index')->with('error-checkout', 'No hay productos en el carrito')->withInput();
            }

            $imagePaymentPath='';
            if($request->hasFile('image')){
                $imagePaymentPath = $request->file('image')->store('orders/payment');
            }


            $order = new Order();
            $order->client_id = auth()->guard('client')->user()->id;
            $order->total = $total;
            $order->payment_method = $request->input('payment_method',"Yape");
            $order->image_payment_url = $imagePaymentPath;
            $order->transaction_id = $request->input('transaction_code');
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
                $raffle->reserved_at = now();
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
