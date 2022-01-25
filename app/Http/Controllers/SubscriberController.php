<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use Auth;


class SubscriberController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;

    if(Auth::user()->isAdmin())
      {

        $data['subscribers'] =Subscriber::all();

        return view("subscribers.subscribers",$data);
         

      } else{
        return back();
      }
        

        
    }
}
