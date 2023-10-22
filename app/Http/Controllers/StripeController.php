<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class StripeController extends Controller
{
   
    public function checkout()
    {
        return view('checkout');
    }
 
    public function session(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('stripe.sk'));
        $orders = $request->orders;
        $note = $request->client_note;
        $productname = $request->get('productname');
        $quantity = $request->get('quantity');
        $totalprice = $request->get('total');
        $two0 = "00";
        $total = "$totalprice$two0";
 
        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'EGP',
                        'product_data' => [
                            "name" => $productname,
                        ],
                        'unit_amount'  => $total,
                    ],
                    'quantity'   => 1,
                ],
                 
            ],
            'mode'        => 'payment',
            'success_url' => route('cart.store', ['orders' => $orders, 'notes' => $note]),
            'cancel_url'  => route('cart.index'),
        ]);
 
        return redirect()->away($session->url);
    }
 
    public function success()
    {
        return to_route('cart.store');
    }
}
