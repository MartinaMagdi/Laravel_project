<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderAdminCheck extends Controller
{
    public function __construct()
    {
        $this->middleware('is_admin');
    }

    public function index(){
        $orders = Order::where('status', 'done')
        ->orderBy('created_at','desc')
        ->paginate(4);
        $users = User::where("role", "user")->get();
        return view('Admin.checks', compact('orders', 'users'));
    }
}
