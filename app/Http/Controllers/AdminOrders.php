<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class AdminOrders extends Controller
{
    public function index(){
        $orders = Order::whereIn('status', ['processing', 'delivered'])->paginate(4);
        return view('Admin.orders', compact('orders'));
    }

    public function update(Request $request, Order $order){
        dd($request);


    }
}
