<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SubscriptionPlanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        ini_set("max_execution_time", 3600);
    }


    public function subscription_plan(){

      $user_id = auth()->user()->id;
        

        $data['subscription_plans'] = DB::table('subscription_plans')
            ->select('*')
            ->where('user_id',$user_id)
            ->get();

        return view("subscription.subscription_plan",$data);
    }

   /* public function subscription_plan_list(){

        return view("");
    }*/
}
