<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;


class AdminOrders extends Controller
{

    public function __construct()
    {
        $this->middleware('is_admin')->only('index');
    }

    public function index(){
        $users = User::where("role", "user")->get();
        $orders = Order::whereIn('status', ['processing', 'out for delivery'])
        ->orderBy('created_at', 'desc')
        ->paginate(4);
        return view('Admin.orders', compact('orders', 'users'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->status = $request->input('status');

        $order->save();

        return redirect()->route('admin.index');
    }
}
