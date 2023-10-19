<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $orders = Order::where('user_id', $userId)->whereIn('status', ['cart'])->paginate(4);
        return view('User.cart', compact('orders'));
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request,  $id)
    {
        $order = $request->orderId;
        $product = $request->productId;
        $requestType = $request->btn;
        if($requestType == 'plus'){
            $orderProduct = new OrderProduct();
            $orderProduct->product_id = $product;
            $orderProduct->order_id = $order;
            $orderProduct->save();
            return to_route('cart.index');
        }else{
            $orderProduct = OrderProduct::findOrFail($id);
            $orderProduct->delete();
            return to_route('cart.index');
        }

        // if($request->btn == 'plus'){
        //     dd('plus'. $id);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        // dd($id);
        $productItem = OrderProduct::findOrFail($id);
        $productItem->delete();
        // $order->delete();
        return redirect()->route('cart.index');
    }
}
