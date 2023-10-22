<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{


    function __construct(){

        // $this->middleware('is-admin')->only(['create','edit','destroy']);       // only admin  can add or edit or delete category
        $this->middleware('is_admin');
  }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
     //   return Category::all();

     $category = Category::paginate(5);

     return view('Admin.category.index',['categories'=>$category]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
              return view('Admin.category.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name'=>'required|unique:categories|min:3'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => "Error", 'data' => "", "message" => $validator->errors()], 401);
        } else {
        $requestData= \request()->all();
       // $requestData['creator_id']=Auth::id();
       $category = Category::create($requestData);
       return redirect()->route('categories.index');
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
               return view('Admin.category.show',['category'=>$category]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
                return view('Admin.category.edit',['category'=>$category]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //         
        $validator = Validator::make($request->all(), [
            'name'=>['required', Rule::unique('categories')->ignore($category->name),'min:3']
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => "Error", 'data' => "", "message" => $validator->errors()], 401);
        } else {

            $category->name=$request->name;
            $category->save();
            return to_route('categories.show',[$category->id]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
         $category->delete();
        return to_route('categories.index');
 
    }
}
