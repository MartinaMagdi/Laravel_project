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


    public function filter(Request $request)
    {
        $start_date = $request->startDate;
        $end_date = $request->endDate;


        if ($start_date && $end_date) {
            $orders = Order::whereDate('created_at', '>=', date('Y-m-d', strtotime($start_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($end_date)))
                ->get();
        } else {
            $orders = [];
        }

        return view('Admin.orders', compact('orders'));
    }

    // orders->order-products->product_id
    // products::find(orders->order-products->product_id);

}
