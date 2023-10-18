<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderAdminCheck extends Controller
{
    public function index(){
        $orders = Order::where('status', 'done')->paginate(4);
        return view('Admin.checks', compact('orders'));
    }


    // orders->order-products->product_id
    // products::find(orders->order-products->product_id);

}
