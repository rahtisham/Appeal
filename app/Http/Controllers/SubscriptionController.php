<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubscriptionPlan;
use App\Subscriber;
use Auth;


class SubscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        ini_set("max_execution_time", 3600);
    }


    public function index(){

    if(!Auth::user()->isAdmin())
      {
        $data['subscription']=SubscriptionPlan::all();
        return view('subscription.subscription',$data);
      }else{
        return back();
      }

        
    }   

    public function payment(Request $request)
    {

      $user = Auth::user();

      $data = $request->all();

      require_once (base_path() . '/vendor/autoload.php');
        
      $stripeSecret = 'sk_test_GrKB6A27pZDDuoJXPz6xD58u00RwqcCzz6';
 
      \Stripe\Stripe::setApiKey($stripeSecret);


      
        $stripe = \Stripe\Charge::create ([
                "amount" => $data['amount'],
                "currency" => "inr",
                "source" => $data['tokenId'],
                "description" => "Test payment"
        ]);
        

          $subscriber = new Subscriber;
          $subscriber->user_id = $user->id;
          $subscriber->payment_id = $stripe->id;
          $subscriber->paid_amount = $stripe->amount;
          $subscriber->name = $user->name;
          $subscriber->description = !empty($data['description'])?$data['description']:'';
          $subscriber->months = $data['months'];
          $subscriber->email = $user->email;
          $subscriber->paid_amount_currency = $stripe->currency;
          $subscriber->balance_transaction = $stripe->balance_transaction;
          $subscriber->payment_status = $stripe->status;
          $subscriber->created = date("Y-m-d H:m:i");
          $saved = $subscriber->save();

          if(!$saved){
              $data = array('error' => true, 'data'=> "Payment Failed.");
          } else {

            $data = array('success' => true, 'data'=> $stripe);
          }

        echo json_encode($data);
    }


   
    
}
