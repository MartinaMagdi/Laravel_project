<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function __construct()
    {
        $this->middleware('auth')->except(['index']);
        $this->middleware('is_admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        if (Auth::User() !== null && Auth::User()->role == 'admin') {
            $users = User::where("role", "user")->get();
            $products = Product::paginate(15);
            return view("shared.products", ["users" => $users, "products" => $products]);
        } else {
            $products = Product::where("available", true)->get();
            return view("shared.products", ["products" => $products]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("admin.products.addProduct", ["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product();

        $image = $request->name . '.' . $request->image->extension();
        $request->image->move(public_path('images/products'), $image);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->available = isset($request->available) ? true : false;
        $product->category_id = $request->category_id;
        $product->image = $image;
        $product->save();

        return to_route("products.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
