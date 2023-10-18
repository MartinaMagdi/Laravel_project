<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'room' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

    //     if (request()->hasfile('image')) {
    //         $file = request()->file('image');
    //             $extension = $file->getClientOriginalExtension(); // getting image extension
    //             $filename = time() . '.' . $extension;
    //             $file->move('', $filename);
    
    // //see above line.. path is set.(uploads/appsetting/..)->which goes to public->then create
    // //a folder->upload and appsetting, and it wil store the images in your file.
    
    //             $data->image = $filename;
        

 

   // Image upload code
   if (request()->hasFile('image')) {
    $image = request()->file("image");
    $path = $image->store("uploadedfile" ,'avatars');
    $data["image"] = $path;

   }   

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'room' => $data['room'],
            'image'=>$data['image'],
            'password' => Hash::make($data['password']),
        ]);
        // return $user;
    }
}