<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use App\Providers\RouteServiceProvider;
use Auth;


class SignupController extends Controller
{

     public function __construct()
    {
        //$this->middleware('auth');
        //ini_set("max_execution_time", 3600);
    }




    public function index()
    {

        return view('auth.register');
    }

    public function postRegister(Request $request)
    { 

        request()->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        ]);

        $data = $request->all();
 
       $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 2,
            'password' => Hash::make($data['password'])
        ]);

        Auth::login($user);

        return redirect()->to('/profile/setting'); 
    
    }
}
