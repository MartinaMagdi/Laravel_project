<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;


class ProfileController extends Controller
{
    //
    public function index()
{
    $user = Auth::user(); // Get the authenticated user
    return view('User.profile', compact('user'));
}

// changepassword

public function changepassword()
{
    $user = Auth::user(); // Get the authenticated user
    return view('User.changepassword', compact('user'));
}
public function updatepassword($id)
{
    $user = User::find($id);
    $password = \request()->get('password');
    $user->password = $password;
    $user->save();

    return view('User.profile', compact('user'));
}
// public function update(Request $request)
// {
//     $user = Auth::user(); // Get the authenticated user

//     $request->validate([
//         'name' => 'required|string|max:255',
//         // Add validation rules for other fields as needed
//     ]);

 
//     $user->update($request->all());

//     return redirect()->route('profile')->with('success', 'Profile updated successfully');
// }




public function edit()
{
    $user = Auth::user(); // Get the authenticated user
    return view('User.edit-profile', compact('user'));
}
public function update(Request $request)
{
    $user = Auth::user(); // Get the authenticated user

    $request->validate([
        'name' => 'required|string|max:255',
    ]);
    $request_data = $request->all();
        if($request->hasFile("image")){
            $image = $request->file("image");
            $path = $image->store("uploadedfile" ,'avatars');
            $request_data["image"] = $path;
        }
    $user->update($request_data);
    return redirect()->route('profile')->with('success', 'Profile updated successfully');
}
}
