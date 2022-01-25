<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\SubscriptionPlan;
use App\User;
use Auth;

class SunscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        ini_set("max_execution_time", 3600);
    }



    public function index()
    {
        $user_id = auth()->user()->id;
        if(Auth::user()->isAdmin())
        {

            $data['subscription_plans'] = DB::table('subscription_plans')
                ->select('*')
                ->where('user_id',$user_id)
                ->get();

            return view("subscription.subscription_plan",$data);
         

        } else{
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $user_id = auth()->user()->id;

        $validator = \Validator::make($request->all(), [
            'price' => 'required',
            'month' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $subscriptionPlan= new SubscriptionPlan();
        $subscriptionPlan->user_id=$user_id;
        $subscriptionPlan->price=$request->get('price');
        $subscriptionPlan->month=$request->get('month');
        $subscriptionPlan->description=$request->get('description');
        $subscriptionPlan->save();

        \Session::flash('success', __('Data is successfully added')); 
   
        return response()->json(['success'=>'Data is successfully added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $subscription = SubscriptionPlan::find($id);
        return response()->json($subscription);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user_id = auth()->user()->id;

        $validator = \Validator::make($request->all(), [
            'price' => 'required',
            'month' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

            $subscription = SubscriptionPlan::find($id);
            $subscription->user_id=$user_id;
            $subscription->price=$request->get('price');
            $subscription->month=$request->get('month');
            $subscription->description=$request->get('description');
            $subscription->save();

            \Session::flash('success', __('Data Updated successfully')); 
   
        return response()->json(['success'=>'Data Updated successfully']);
            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubscriptionPlan::find($id)->delete($id);

        \Session::flash('success', __('Data Deleted successfully')); 

  
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
