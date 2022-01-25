<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Users;
use Spatie\Permission\Models\Role;
use DB;
use Auth;
use Hash;
use App\Rules\MatchOldPassword;
use App\AmazonSettings;
use App\WalmartSettings;
use \App\Mail\SendMail;
use Mail;



class UsersController extends Controller
{

   function __construct()
   {
      $this->middleware('auth');
   }
   public function index(){
      $data = array('pageTitle' => "User List");

   	$data['users'] = Users::select('users.id','users.name','users.email','roles.name as role_id','users.status')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')->get();
   	return view('users.index')->with($data);
   }

	public function create(){

      $data = array('pageTitle' => "Add User");
		$data['roles'] = Role::select('id','name')->get();
   	return view('users.create')->with($data);
	}

   public function store(Request $request){
   	$data = $request->except('_method','_token','submit');

   	$validator = Validator::make($request->all(), [
      	'name' => 'required|string|min:2',
      	'email' => 'required|email|min:3',
   	]);

   	if ($validator->fails()) {
      	return redirect()->Back()->withInput()->withErrors($validator);
   	}

   	$record = Users::create([
         'name' => $request->name,
         'email' => $request->email,
         'role_id' => $request->role_id,
         'password' => Hash::make($request->password),
      ]);

   	if($record){
      	Session::flash('message', 'Added Successfully!');
      	Session::flash('alert-class', 'alert-success');
      	return redirect()->route('users');
   	}else{
      	Session::flash('message', 'Data not saved!');
      	Session::flash('alert-class', 'alert-danger');
   	}

   	return Back();
   }

	public function edit($id){

      $data = array('pageTitle' => "Edit User");

   	$data['user'] = Users::find($id);
   	$data['roles'] = Role::select('id','name')->get();

   	return view('users.edit')->with($data);
	}

	public function update(Request $request,$id){
   	$data = $request->except('_method','_token','submit');
     
   	$validator = Validator::make($request->all(), [
      	'name' => 'required|string|min:2',
      	'email' => 'required|string|min:5',
      	'role_id' => 'required',
   	]);

   	if ($validator->fails()) {
      	return redirect()->Back()->withInput()->withErrors($validator);
   	}
   	$userdata = users::find($id);

   	if($userdata->update($data)){

      	Session::flash('message', 'Update successfully!');
      	Session::flash('alert-class', 'alert-success');
      	return redirect()->route('users');
   	}else{
      	Session::flash('message', 'Data not updated!');
      	Session::flash('alert-class', 'alert-danger');
   	}

   	return Back()->withInput();
   }

   // Delete
   public function destroy($id){
      if($id == '1'){
         Users::destroy($id);

         Session::flash('message', 'Delete successfully!');
         Session::flash('alert-class', 'alert-success');
      }
      return redirect()->route('users');
   }

   public function profile(){

      $data = array('pageTitle' => "Profile");

      $user_id = auth()->user()->id;

      //$user = Users::find($user_id);

      $data['user'] = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->select('users.*', 'roles.name as role')
            ->where('users.id',$user_id)
            ->get();

      $data['amazon_settings'] = DB::table('amazon_settings')
            ->select('*')
            ->where('user_id',$user_id)
            ->get();

      $data['walmart_settings'] = DB::table('walmart_settings')
            ->select('*')
            ->where('user_id',$user_id)
            ->get();


      return view('users.setting')->with($data);
   }

   public function mwsSettingUpdate(Request $request){

      $data = $request->all();

      $userData = array(
         'name' => $data['name'],
         'email' => $data['email'],
      );

      if(!empty($userData)){

         $res = DB::table('users')
            ->where('id', auth()->user()->id)  
            ->limit(1)
            ->update($userData);

         Session::flash('message', 'Profile Settings Updated successfully');
         Session::flash('alert-class', 'alert-success');
      }

      return redirect()->route('profile.setting');

   }

   public function changePassword(Request $request){

      $data = $request->all();

      $validator = Validator::make($request->all(), [
            'password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'confirm_new_password' => ['same:new_password'],
         ]);

         if ($validator->fails()) {
            Session::flash('message', 'Password Not Updated successfully');
            Session::flash('alert-class', 'alert-warning');
         }else{

         $userData = array(
            'password' => Hash::make($data['new_password'])
         );


            $res = DB::table('users')
            ->where('id', auth()->user()->id)  
            ->limit(1)
            ->update($userData);


         Session::flash('message', 'Password Updated successfully');
         Session::flash('alert-class', 'alert-success');
         }

         return redirect()->route('profile.setting');

   }



   public function AmazonSettingsUpdate(Request $request){


      $data = $request->all();

      $validator = Validator::make($request->all(), [
            'client_id' => ['required'],
            'client_secret' => ['required'],
            'access_key' => ['required'],
            'secret_key' => ['required'],
            'refresh_token' => ['required']
         ]);

      if ($validator->fails()) {
            Session::flash('message', 'Amazon Settings Not Updated successfully');
            Session::flash('alert-class', 'alert-success');
         }else{

               $userData = array(
                  'marketplace_id' => $data['marketplaceid'],
                  'client_id' => $data['client_id'],
                  'client_secret' => $data['client_secret'],
                  'access_key' => $data['access_key'],
                  'secret_key' => $data['secret_key'],
                  'refresh_token' => $data['refresh_token'],
                  'role_arn' => $data['role_arn'],
                  'status' => '1'
               );



            if(!empty($userData)){

               $res = DB::table('amazon_settings')
                  ->where('user_id', auth()->user()->id)  
                  ->limit(1)
                  ->update($userData);

                  if ($res==0) {

                     $amazon_settings = new AmazonSettings;
                     $amazon_settings->user_id = auth()->user()->id;
                     $amazon_settings->marketplace_id = $data['marketplaceid'];
                     $amazon_settings->client_id = $data['client_id'];
                     $amazon_settings->client_secret = $data['client_secret'];
                     $amazon_settings->access_key = $data['access_key'];
                     $amazon_settings->secret_key = $data['secret_key'];
                     $amazon_settings->refresh_token = $data['refresh_token'];
                     $amazon_settings->role_arn = $data['role_arn'];
                     $amazon_settings->status = 1;
                     $amazon_settings->save();

                     Session::flash('message', 'Amazon Settings Authenticated successfully');
                     Session::flash('alert-class', 'alert-success');
                     
                  }else{
                     Session::flash('message', 'Amazon Settings Authenticated successfully');
                     Session::flash('alert-class', 'alert-success');
                  }
            }

         }

      return redirect()->route('profile.setting');

   }


   public function walmartSetting(Request $request){


       $data = $request->all();

      $validator = Validator::make($request->all(), [
            'client_id' => ['required'],
            'client_secret' => ['required'],
            'walmart_service_name' => ['required'],
            'correlation_id' => ['required'],
            // 'customer_channel_type' => ['required'],
            // 'access_token' => ['required']
         ]);

      if ($validator->fails()) {
            Session::flash('message', 'Walmart Settings Not Updated successfully');
            Session::flash('alert-class', 'alert-success');
         }else{

               $userData = array(
                  'client_id' => $data['client_id'],
                  'client_secret' => $data['client_secret'],
                  'walmart_service_name' => $data['walmart_service_name'],
                  'correlation_id' => $data['correlation_id'],
                  // 'customer_channel_type' => $data['customer_channel_type'],
                  // 'access_token' => $data['access_token']
               );



            if(!empty($userData)){

                $credential=$this->getToken($userData['client_id'],$userData['client_secret']);

                if (!empty($credential)) {

                     $res = DB::table('walmart_settings')
                  ->where('user_id', auth()->user()->id)  
                  ->limit(1)
                  ->update($userData);



                  if ($res==0) {

                     $walmart_settings = new WalmartSettings;
                     $walmart_settings->user_id = auth()->user()->id;
                     $walmart_settings->client_id = $data['client_id'];
                     $walmart_settings->client_secret = $data['client_secret'];
                     $walmart_settings->walmart_service_name = $data['walmart_service_name'];
                     $walmart_settings->correlation_id = $data['correlation_id'];
                     // $walmart_settings->customer_channel_type = $data['customer_channel_type'];
                     $walmart_settings->access_token = $credential;
                     $walmart_settings->save();

                   //  echo "updated"; exit;

                     Session::flash('message', 'Walmart Authenticated successfully');
                     Session::flash('alert-class', 'alert-success');
                     
                  }else{
                     Session::flash('message', 'Walmart Authenticated successfully');
                     Session::flash('alert-class', 'alert-success');
                  }
                }else{
                 
                  Session::flash('message', 'Walmart Not Authenticated, Please Enter Right Credential');
                  Session::flash('alert-class', 'alert-danger');

                }


               
            }

         }

      return redirect()->route('profile.setting');

    

   }


   function getWalmartDetail($client_id, $client_secret)
   {
      $data = []; 
      $data['client_id'] = $client_id;
      $data['client_secret'] = $client_secret;
      return $data;
   }

   function getToken($client_id, $client_secret)
   {
      $data = $this->getWalmartDetail($client_id, $client_secret);
      $client_id = $data['client_id'];
      $client_secret = $data['client_secret'];
      $url = "https://marketplace.walmartapis.com/v3/token";
      $uniqid = uniqid();
      $authorization_key = base64_encode($client_id.":".$client_secret);
      $code = "";

      $ch = curl_init();
      $options = array(

            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_HEADER => false,
            CURLOPT_POST =>1,
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(

                  "WM_SVC.NAME: Walmart Marketplace",
                  "WM_QOS.CORRELATION_ID: $uniqid",
                  "Authorization: Basic $authorization_key",
                  "Accept: application/json",
                  "Content-Type: application/x-www-form-urlencoded",
            ),
      );
      curl_setopt_array($ch,$options);
      $response = curl_exec($ch);
      $code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
      curl_close($ch);

      if($code == 201 || $code == 200)
      {
         $token = json_decode($response,true);
         return $token['access_token'];
      } 
   }


    public function all_orders_notifications(){


      $user_id = auth()->user()->id;

      $amazon_settings = AmazonSettings::where('user_id','=',$user_id)->get();
      $user = Users::where('id','=',$user_id)->get();


      if ($amazon_settings->isEmpty()) {
                    $data['all_orders']=[];
                    return view('amz.orders',$data);

      }else{

              $controller = new Controller();
              $config = $controller->getConfig();

              $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\OrdersApi(
                     //new GuzzleHttp\Client(),
                     $config
               );

               $marketplace_ids = "ATVPDKIKX0DER"; 
               $created_after = "2019-08-01"; 
               $created_before = ""; 
               $last_updated_after = ""; 
               $last_updated_before = ""; 
               $order_statuses = array(""); 
               $fulfillment_channels = array(""); 
               $payment_methods = array(""); 
               $buyer_email = ""; 
               $seller_order_id = ""; 
               $max_results_per_page = 56; 
               $easy_ship_shipment_statuses = array(""); 
               $next_token = ""; 
               $amazon_order_ids = array("");

            try {
                $result = $apiInstance->getOrders($marketplace_ids, $created_after, $created_before, $last_updated_after, $last_updated_before, $order_statuses, $fulfillment_channels, $payment_methods, $buyer_email, $seller_order_id, $max_results_per_page, $easy_ship_shipment_statuses, $next_token, $amazon_order_ids);

                //OrderStatus

                if(empty($result['payload']['orders']['OrderStatus'])){

                     $details = [
                        'title' => 'Valid Tracking Rate (VTR)',
                        'body' => 'Please Maintain Your Valid Tracking Rate (VTR)'
                     ];

                  $user['to']=$user[0]['email'];

                  Mail::send('mail', $details, function($message) use ($user) {
                     $message->to($user['to']);
                     $message->subject('Valid Tracking Rate (VTR)');
                  });

                    // \Mail::to('siddharthshukla089@gmail.com')->send(new SendMail($details));

                     //echo "mail sent";
                     //return view('emails.thanks');

                }

                //echo "<pre>";
                //print_r($result['payload']); exit;
                
               // if (!empty($result['payload']['orders'])) {
               //           $data['all_orders']=$result['payload']['orders'];
               //           return view('amz.orders',$data);
               // }else{

               //    $data['all_orders']=[];
               //    return view('amz.orders',$data);

               // }
            } catch (Exception $e) {
                echo 'Exception when calling OrdersV0Api->getOrders: ', $e->getMessage(), PHP_EOL;
            }

      }

  }


  public function walmart_orders_notifications(){

            $user_id = auth()->user()->id;

            $walmart_settings = WalmartSettings::where('user_id','=',$user_id)->get();
            $user = Users::where('id','=',$user_id)->get();


            if ($walmart_settings->isEmpty()) {
                    $data['all_orders']=[];
                    return view('walmarts.orders',$data);

            }else{

                    $token = $this->getToken($walmart_settings[0]['client_id'],$walmart_settings[0]['client_secret']);
                    
                    $data = $this->getWalmartDetail($walmart_settings[0]['client_id'],$walmart_settings[0]['client_secret']);
                    $client_id = $data['client_id'];
                    $client_secret = $data['client_secret'];
                    $authorization = base64_encode($client_id . ":" . $client_secret);
                    $url="https://marketplace.walmartapis.com/v3/orders";

                    $ch      = curl_init();
                    $qos     = uniqid();
                    $options = array(
                        CURLOPT_URL            => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT        => 60,
                        CURLOPT_HEADER         => false,
                        CURLOPT_HTTPHEADER     => array(
                            "WM_SVC.NAME: Walmart Marketplace",
                            "WM_QOS.CORRELATION_ID: $qos",
                            "Authorization: Basic $authorization",
                            "WM_SEC.ACCESS_TOKEN:$token",
                            "Accept: application/json",
                            "Content-Type: application/json",

                        ),
                        CURLOPT_HTTPGET        => true,
                    );
                    curl_setopt_array($ch, $options);
                    $response = curl_exec($ch);

                    echo "<pre>";
                    print_r($response); exit;
                    $code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    /*if ($code == 201 || $code == 200) {
                         $response = json_decode($response,true);

                         $data['all_orders']=$response['list']['elements']['order'];

                         return view('walmarts.orders',$data);

                         
                    } else {
                        return false;
                    }*/

            }    

   }


   public function walmart_orders_notification(){

         $user_id = auth()->user()->id;
         $user = Users::where('id','=',$user_id)->get();

         $curl = curl_init();

         curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://marketplace.walmartapis.com/v3/orders',
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'GET',
           CURLOPT_HTTPHEADER => array(
             'Authorization: Basic Mjg5ZDZmYWItZmQ1Ny00YTgwLTkxYjQtZDU3NTAyZGE2OTk2OmZQOEd6TG5WSU1sSGg0T0RkeW9VdHZsVWgteDJpTE04R2hrQUoxUFI1QnJicFUwa1M0Z05TeTRISjNESU43S0lSRk5NbDNoOVRsMnp4OEI4N1NEcmFn',
             'WM_SEC.ACCESS_TOKEN: eyJraWQiOiJiN2JmYjM1OC1lODYzLTRjMzItYmUxZC00M2I4NTIyMzkyZjMiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiZGlyIn0..PnbVwk5Vpp35X7di.5L7qp2Xyc8Q8z8OwOrwl0RAI1b-gLcanqzibvaFOL28qUc2qdbH0sx2189rkF3iCl-jmOOIp7w-dc-NQPG24gi7EH8gr1K5bT6zFuCGpNO9LLXbWKXB9zqYfwX9xiLaKAbyTjcV3fBDJq6fyusf7WHpvdzFwRzgJiS-KtczfcSpAHiwMn_tOACukSlzBJWa4q45jk6SFrGQrgvOGiAZ6H6b_yiPsCoknAr2SXT4stwhr39JqaFNZMtSOqmuuKifW6ccJbOzYQJyHmktMjMuwftHogG_VrSKzfCv9dVyWoITr98LKjJBVBD82ryB9ZPqhIQa3y7Ap0m9rOup4Gv_u6CcsxPrbL_04A13YL-vj2MZaNI3joZvFEcF_OQbwy0568R3JkIBWoUgx7r-imiTge7jN-_mYRHPncsA-XZ3eFmWqrSmL_7W8TMJd0tTs_J1jAlyV33PuRQnhDBzsxhJHnY6T0RMV8J3kzZwsAcEQCi6-qsVyIIKRoipEPEfgFxMqieV4G82DG9cK20Wiw4MSgJOqrtv_-dMiNa7RYV8GHXxzg4HDMFzwKV5A_767f_bKv8qjdyXa0kRUIBYKz6wk8P5oU6WEsgz6wVqLwdlLpJWsSIWiVxFiUFsaBaoYKz9jq1PCHNJzuGvdw1DA4xfV6Oy2Sng0IWX_xProy_EtFmi3Vs2c34pQSPewW02z.HdY0etozcPA-X1fpLXqHoQ',
             'WM_QOS.CORRELATION_ID: Test Seller',
             'WM_SVC.NAME: Walmart Marketplace',
             'Accept: application/json',
             'Content-Type: application/x-www-form-urlencoded',
             'Cookie: TS01f4281b=0130aff2328dda47b71a0227a967ceefc2dd84dbea15ca718fec9ff76d39463436818c47f7d7c96aae6e817f0e403c0b43619c8eff'
           ),
         ));

      
         $response = curl_exec($curl);
         $response = json_decode($response,true);


         foreach ($response['list']['elements']['order'] as $key => $value) {

            // echo "<pre>";
            // print_r($value['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['status']); 
            // exit;
            if (empty($value['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['status']) || !isset($value['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['status'])) {


               $details = [
                        'title' => 'Valid Tracking Rate (VTR)',
                        'body' => 'Please Maintain Your Valid Tracking Rate (VTR)'
                     ];


               $user['to']=$user[0]['email'];


               Mail::send('mail', $details, function($message) use ($user) {
                  $message->to($user['to']);
                  $message->subject('Valid Tracking Rate (VTR)');
               });

               // \Mail::to('siddharthshukla089@gmail.com')->send(new SendMail($details));
               //  echo "sent message";
              
            }

            if ($value['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['status'] == "Shipped") {

                  $details = [
                           'title' => 'Shipped Order',
                           'body' => 'Order Shipped'
                        ];

                  $user['to']=$user[0]['email'];

                  Mail::send('mail', $details, function($message) use ($user) {
                  $message->to($user['to']);
                  $message->subject('Shipped Order');
                  });

                  //echo "sent message"; exit;
               
            }

            if ($value['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['status'] == "Delivered") {

               $details = [
                        'title' => 'Delivered Order',
                        'body' => 'Order Delivered'
                     ];

               $user['to']=$user[0]['email'];

               Mail::send('mail', $details, function($message) use ($user) {
               $message->to($user['to']);
               $message->subject('Delivered Order');
               });
               
            }
           
         }  
         
         curl_close($curl);
         //echo $response;
   }


   public function item_affected_notification(){

         $user_id = auth()->user()->id;
         $user = Users::where('id','=',$user_id)->get();

         $curl = curl_init();

         curl_setopt_array($curl, array(
           CURLOPT_URL => 'https://marketplace.walmartapis.com/v3/insights/items/unpublished/items?fromDate='.date("Y-m-d"),
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => '',
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 0,
           CURLOPT_FOLLOWLOCATION => true,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => 'GET',
           CURLOPT_HTTPHEADER => array(
             'Authorization: Basic Mjg5ZDZmYWItZmQ1Ny00YTgwLTkxYjQtZDU3NTAyZGE2OTk2OmZQOEd6TG5WSU1sSGg0T0RkeW9VdHZsVWgteDJpTE04R2hrQUoxUFI1QnJicFUwa1M0Z05TeTRISjNESU43S0lSRk5NbDNoOVRsMnp4OEI4N1NEcmFn',
             'WM_SEC.ACCESS_TOKEN: eyJraWQiOiJiN2JmYjM1OC1lODYzLTRjMzItYmUxZC00M2I4NTIyMzkyZjMiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiZGlyIn0..v_fGxHcH_mBweAWr.16oDVNMnaeboPMOewSmUp0BlV-IGnu9CIAYJQBqnDk4zvYps_XC5UlR49L62BwD5IUbHbJPYzCC73-AHhCSjfQMxwTHomqJg1vLBBe7VrWtX4jTk1HgqDUcCY35xJ-5MsInzB4_hJPz8pW6NtUjJ7pYdSW5RBKahU7DRxSfHQhjHGWGPFRRioGWFSX4Gw3Nm49mmjHINlQi7_Ym2YlWshUnPTM8BfxPVcD6GaHxt31ZvB1SqebLcYByMpP5hLCD7Aa87EJasv5nd9o7KgkHid36Bd7GhRx8SdeHnP59giWz0WgJJwrqnFx-3J118owHcBtNLYhU2YaaR4Uy9BPp6kwWM68XhdRuVL4hXjyVCLw23ZU-Oz_jY3jM7bL6CkJi0qkyxKXM85SGO9SEptW4Z97Ej_bfzmXTI25q1BuMf0cwokTsBj5odF2PjHBLnLdnzalvitJo4X3CWQp0t12kOhaypC4Wprh0APB2GJxoAD1knHJ33OwIlpaJVVXNUvndYMs8VWRgHDvnpI4xzU-ovXRhsQZ7t50gCqDxsnUc9BTFyPNJemkPZoSrBx-xv25BBCN0tTIu1AFNzwoZsB8CxFL5HZGoiLRonIUwBM2CY7trckwiQwmbOvYpLCAlSsHJFSh0TcroOnDSEi_ZE6emosge9faYS3Nk-JJF9j8kbbn2fh-reEVrKS59xeQUj.8ZVAblR-wYa3lfgIwg5q3w',
             'WM_QOS.CORRELATION_ID: Test Seller',
             'WM_SVC.NAME: Walmart Marketplace',
             'Accept: application/json',
             'Content-Type: application/x-www-form-urlencoded',
             'Cookie: TS01f4281b=01c5a4e2f9b0e2f53fa35e3246aa1600bcc10134a633544e2030a9ad15c79b8f05042c4b0231ff8325ff6acebf8ee6de067101b349'
           ),
         ));

         $response = curl_exec($curl);

         $response = json_decode($response,true);

         foreach($response['payload'] as $key => $response_data){

            if ($response_data['publishStatus'] == 'PUBLISHED') {

               $details = [
                        'title' => 'Unpublished Item',
                        'body' => 'Item Unpublished',
                        'itemId' => $response_data['itemId'],
                        'sku' => $response_data['sku']
                     ];

               $user['to']=$user[0]['email'];

               Mail::send('mail', $details, function($message) use ($user) {
               $message->to($user['to']);
               $message->subject('Published Item');
               });
            }

            if ($response_data['publishStatus'] == 'UNPUBLISHED') {
               $details = [
                        'title' => 'Unpublished Item',
                        'body' => 'Item Unpublished',
                        'itemId' => $response_data['itemId'],
                        'sku' => $response_data['sku']
                     ];

               $user['to']=$user[0]['email'];

               Mail::send('mail', $details, function($message) use ($user) {
               $message->to($user['to']);
               $message->subject('Unpublished Item');
               });
            }

         } 

         curl_close($curl);
         //echo $response;

   }


}
