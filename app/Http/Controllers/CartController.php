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
    }

    public function index()
    {
        $userId = Auth::id();
        if (Auth::User() !== null && Auth::User()->role == 'admin') {
            $orders = Order::where('creator_id', $userId)->whereIn('status', ['cart'])->paginate(4);
            foreach ($orders as $order) {
                $user = User::where('id', $order->user_id)->first();
            }
        } else {
            $orders = Order::where('user_id', $userId)->whereIn('status', ['cart'])->paginate(4);
        }

        if(isset($user)) {
            return view('shared.cart', compact('orders', 'user'));
        }
        return view('shared.cart', compact('orders'));
    }



    public function store(Request $request, $orders, $notes)
    {
        $orders = $request->orders;
        $notes = $request->query('notes');
    
        dd($orders); 
    
        foreach ($orders as $orderId) {
            $order = Order::findOrFail($orderId);
            $order->update([
                'note' => $notes,
                'status' => 'processing'
            ]);
        }
    
        if (Auth::user() !== null && Auth::user()->role == 'admin') {
            return redirect()->route('admin-index');
        }
    
        return redirect()->route('orders.index');
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
