<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request = null)
    {
        $userId = Auth::id();

        // dd($userId);
        if ($request) {

            $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate)->endOfDay();

            dd($startDate, $endDate);


            $orders = DB::table('orders')
                ->where('user_id', $userId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->paginate(4);

            return view('User.orders', compact('orders'));
        } else {
            $orders = Order::where('user_id', $userId)->whereIn('status', ['processing', 'out for delivery', 'done'])
                ->orderBy('created_at', 'desc')
                ->paginate(4);
            return view('User.orders', compact('orders'));
        }
    }

    public function filter(Request $request)
    {
        $orderDetails = OrderProduct::all();
        $start_date = $request->startDate;
        $end_date = $request->endDate;
        $userId = $request->user_id;
        $users = User::where("role", "user")->get();

        if (Auth::user()->role == 'admin') {
            if ($start_date && $end_date && $userId) {
                $orders = Order::whereDate('created_at', '>=', date('Y-m-d', strtotime($start_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($end_date)))
                ->where('status', ['processing', 'out for delivery'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
            } else if ($start_date && $end_date) {
                $orders = Order::whereDate('created_at', '>=', date('Y-m-d', strtotime($start_date)))
                    ->whereDate('created_at', '<=', date('Y-m-d', strtotime($end_date)))
                    ->whereIn('status', ['processing', 'out for delivery'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(4);
            } else if ($start_date && $userId) {
                $orders = Order::whereDate('created_at', '>=', date('Y-m-d', strtotime($start_date)))
                ->where('status', ['processing', 'out for delivery'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
            } else if ($end_date && $userId) {
                $orders = Order::whereDate('created_at', '<=', date('Y-m-d', strtotime($end_date)))
                ->where('status', ['processing', 'out for delivery'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
            } else if ($start_date) {
                $orders = $this->selectOrdersDate('>=', $start_date);
            } else if ($end_date) {
                $orders = $this->selectOrdersDate('<=', $end_date);
            } else if ($userId){
                $orders = Order::where('status', ['processing', 'out for delivery'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(4);
            } else {
                $orders = Order::whereIn('status', ['processing', 'out for delivery'])
                    ->paginate(4);
            }
            return view('Admin.orders', compact('orders', 'users'));
        } else {
            if ($start_date && $end_date) {
                $orders = Order::whereDate('created_at', '>=', date('Y-m-d', strtotime($start_date)))
                    ->whereDate('created_at', '<=', date('Y-m-d', strtotime($end_date)))
                    ->whereIn('status', ['processing', 'out for delivery', 'done'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(4);
            } else if ($start_date) {
                $orders = $this->selectOrdersDate('>=', $start_date);
            } else if ($end_date) {
                $orders = $this->selectOrdersDate('<=', $end_date);
            } else {
                $orders = Order::whereIn('status', ['processing', 'out for delivery', 'done'])
                    ->paginate(4);
            }
            return view('User.orders', compact('orders', 'users'));
        }

    }

    public function filterWithStatusDone(Request $request)
    {
        $orderDetails = OrderProduct::all();
        $start_date = $request->startDate;
        $end_date = $request->endDate;
        $userId = $request->user_id;
        $users = User::where("role", "user")->get();

        if ($start_date && $end_date && $userId) {
            $orders = Order::whereDate('created_at', '>=', date('Y-m-d', strtotime($start_date)))
            ->whereDate('created_at', '<=', date('Y-m-d', strtotime($end_date)))
            ->where('status', 'done')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        } else if ($start_date && $end_date) {
            $orders = Order::whereDate('created_at', '>=', date('Y-m-d', strtotime($start_date)))
                ->whereDate('created_at', '<=', date('Y-m-d', strtotime($end_date)))
                ->where('status', 'done')
                ->orderBy('created_at', 'desc')
                ->paginate(4);
        } else if ($start_date && $userId) {
            $orders = Order::whereDate('created_at', '>=', date('Y-m-d', strtotime($start_date)))
            ->where('status', 'done')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        }else if ($end_date && $userId) {
            $orders = Order::whereDate('created_at', '<=', date('Y-m-d', strtotime($end_date)))
            ->where('status', 'done')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        } else if ($start_date) {
            $orders = $this->selectOrdersDateCheck('>=', $start_date);
        } else if ($end_date) {
            $orders = $this->selectOrdersDateCheck('<=', $end_date);
        } else if ($userId){
            $orders = Order::where('status', 'done')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        }else {
            $orders =  Order::whereIn('status', ['done'])
                ->paginate(4);;
        }

        return view('Admin.checks', compact('orders', 'users'));
    }

    public function selectOrdersDateCheck($condition, $date)
    {
        $orders = Order::whereDate('created_at', $condition, date('Y-m-d', strtotime($date)))
            ->where('status', 'done')
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return $orders;
    }


    public function selectOrdersDate($condition, $date)
    {
        $orders = Order::whereDate('created_at', $condition, date('Y-m-d', strtotime($date)))
            ->whereIn('status', ['processing', 'out for delivery'])
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return $orders;
    }


    public function create()
    {
        //
    }


    public function store(StoreOrderRequest $request)
    {
        if (Auth::User() == null) {
            return to_route("login");
        }

        $product_id = $request->input('product_id');

        if (Auth::User()->role == 'admin') {
            $user_id = $request->user_id;
            $creator_id = Auth::id();
            $order = Order::where('creator_id', Auth::id())->where("status", "cart")->first();
        } else {
            $user_id = Auth::id();
            $creator_id = null;
            $order = Order::where('user_id', Auth::id())->where("status", "cart")->first();
        }

        if (!isset($order)) {
            $order = $this->storeOrder($creator_id, $user_id);
            $this->storeOrderProduct($product_id, $order);
        } else {
            $order->creator_id = $creator_id;
            $order->user_id = $user_id;
            $order->save();

            $order_product = OrderProduct::where("order_id", $order->id)->where("product_id", $product_id)->first();
            if (isset($order_product)) {
                $order_product->quantity = ++$order_product->quantity;
                $order_product->save();
            } else {
                $this->storeOrderProduct($product_id, $order);
            }
        }

        return to_route("products.index")->with(["status" => "cartAdded", "message" => "The product is added to the cart successfully"]);
    }

    public function storeOrder($creator_id, $user_id)
    {
        $order = new Order();
        $order->creator_id = $creator_id;
        $order->user_id = $user_id;
        $order->save();
        return $order;
    }

    public function storeOrderProduct($product_id, $order)
    {
        $order_product = new OrderProduct();
        $order_product->product_id = $product_id;
        $order_product->order_id = $order->id;
        $order_product->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return to_route('orders.index')->with(["status" => "deleted", "message" => "The product is deleted successfully"]);
    }
}
