<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('is_user');
    }

    public function index()
    {
        $userId = Auth::id();

        $orders = Order::where('user_id', $userId)->whereIn('status', ['cart'])->paginate(4);
        return view('User.cart', compact('orders'));
    }



    public function store(Request $request)
    {

        $orders = $request->orders;

        // dd($orders);

        foreach($orders as $orderId)
        {
            $order = Order::findOrFail($orderId);
            // dump($order->id);
            $order->update([
                'note' => $request->client_note,
                'status' => 'done'
            ]);
        }
        return to_route('cart.index');
    }


    public function update(Request $request,  $id)
    {
        $orderProduct = OrderProduct::findOrFail($id);
        $orderProduct->update([
            'quantity' => $request->quantity
        ]);
        return to_route('cart.index');

    }


    public function destroy($id)
    {

        // dd($id);
        $productItem = OrderProduct::findOrFail($id);
        $productItem->delete();
        // $order->delete();
        return redirect()->route('cart.index');
    }
}
