<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
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
        $this->middleware('auth')->except(['index', 'search']);
        $this->middleware('is_admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        if (Auth::User() !== null && Auth::User()->role == 'admin') {
            $users = User::where("role", "user")->get();
            $products = Product::paginate(15);
            return view("shared.products", ["users" => $users, "products" => $products]);
        } else {
            $products = Product::where("available", true)->paginate(15);
            return view("shared.products", ["products" => $products]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("Admin.products.addProduct", ["categories" => $categories]);
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

        return to_route("products.index")->with(["status" => "added", "message" => "Product added successfully"]);
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
        $categories = Category::all();
        return view("Admin.products.editProduct", ["product" => $product, "categories" => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($request->image) {
            unlink('images/products/' . $product->image);
            $image = $request->name . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $image);
            $product->image = $image;
        }

        $product->price = $request->price;
        $product->available = isset($request->available) ? true : false;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->save();

        return to_route("products.index")->with(["status" => "updated", "message" => "Product updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id) {
        $product = Product::findorfail($id);
        $product->delete();
        unlink('images/products/' . $product->image);
        return to_route("products.index")->with(["status" => "deleted", "message" => "Product deleted successfully"]);
    }

    public function search(Request $request)
    {
        $users = User::where("role", "user")->get();

        if (Auth::User() !== null && Auth::User()->role == 'admin') {
            $products = Product::where("name", "like", "%$request->search%")->paginate(15);
        } else {
            $products = Product::where("name", "like", "%$request->search%")->where("available", true)->paginate(15);
        }

        if (count($products) > 0)
            return view("shared.products", ["products" => $products, "users" => $users]);
        else
            return to_route("products.index")->with(["status" => "notMatched", "message" => "There is no products matched"]);
    }
}