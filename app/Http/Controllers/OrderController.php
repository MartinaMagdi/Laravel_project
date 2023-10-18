<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request = null)
    {
        $userId = Auth::id();

        // dd($userId);
        if($request){

            $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate)->endOfDay();

            dd($startDate, $endDate);


            $orders = DB::table('orders')
            ->where('user_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->paginate(4);

            return view('User.orders', compact('orders'));

        }else{
            $orders = Order::where('user_id', $userId)->paginate(4);
            return view('User.orders', compact('orders'));
        }
    }

    // public function filterOrder(Request $request){
    //     // $startDate = $request->startDate;
    //     // $endData   = $request->endDate;

    //     $startDate = Carbon::createFromFormat('Y-m-d', $request->startDate)->startOfDay();
    // $endDate = Carbon::createFromFormat('Y-m-d', $request->endDate)->endOfDay();

    //     $userId = auth::id();

    //     $orders = DB::table('orders')
    //     ->where('user_id', $userId)
    //     ->whereBetween('created_at', [$startDate, $endDate])
    //     ->paginate(4);

    //     // dd($startDate, $endDate);
    //     // dd($orders);
    //     return view('User.orders', compact('orders'));

    // }
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
        return to_route('orders.index');
    }
}
