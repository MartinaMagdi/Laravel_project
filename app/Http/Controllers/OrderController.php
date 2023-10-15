<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
        //
    }
}
