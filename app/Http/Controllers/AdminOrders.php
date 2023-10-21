<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class AdminOrders extends Controller
{

    public function __construct()
    {
        $this->middleware('is_admin')->only('index');
    }

    public function index(){
        $orders = Order::whereIn('status', ['processing', 'out for delivery'])
        ->orderBy('created_at', 'desc')
        ->paginate(4);
        return view('Admin.orders', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status = $request->input('status');

        $order->save();

        return redirect()->route('admin.index');
    }


    public function filter(Request $request)
    {
        $start_date = $request->startDate;
        $end_date = $request->endDate;


        if ($start_date && $end_date) {
            $orders = Order::whereDate('created_at', '>=', date('Y-m-d', strtotime($start_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($end_date)))
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $orders = [];
        }

        return view('Admin.orders', compact('orders'));
    }


}
