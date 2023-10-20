<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->can('is-admin')) {
        $users = User::all();
        return view('Admin.users.index',['users'=>$users]);
        }
        return  abort(403);       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.users.addUser');

    }

    /**
     * Store a newly created resource in storage.
     */
   

    public function store(Request $request)
    {
        $request_data = $request->all();
        if ($request->hasFile("image")) {
            $image = $request->file("image");
            $path = $image->store("uploadedfile" ,'avatars');
            $request_data["image"] = $path;
        }
        User::create($request_data);

        return to_route('user.index');


    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
     return view('Admin.users.edituser', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        // Add validation rules for other fields as needed
    ]);
    $request_data = $request->all();
    if ($request->hasFile("image")) {
        $image = $request->file("image");
        $path = $image->store("uploadedfile" ,'avatars');
        $request_data["image"] = $path;

    }
    $user->update($request_data);
    return redirect()->route('user.index')->with('success', 'Profile updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return to_route('user.index');


    }
}
