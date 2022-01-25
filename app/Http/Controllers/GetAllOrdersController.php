<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WalmartSettings;
use App\Walmart;

class GetAllOrdersController extends Controller
{

    function __construct()
   {
      $this->middleware('auth');
   }

   public function getWalmartDetail()
    {

        $user_id = auth()->user()->id;

        $walmart_settings = WalmartSettings::where('user_id','=',$user_id)->first();

        $data = []; 
        $data['client_id'] = $walmart_settings->client_id;
        $data['client_secret'] = $walmart_settings->client_secret;
        return $data;
    }


   function getToken()
       {
          $data = $this->getWalmartDetail();
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

    public function get_all_items(){

        $user_id = auth()->user()->id;

        $walmart_settings = WalmartSettings::where('user_id','=',$user_id)->get();

        if ($walmart_settings->isEmpty()) {
           $data['all_items']=[];
            return view('walmarts.items',$data);
        } else {

            $token = $this->getToken();
            
            $data = $this->getWalmartDetail();
            $client_id = $data['client_id'];
            $client_secret = $data['client_secret'];
            $authorization = base64_encode($client_id . ":" . $client_secret);
            $url="https://marketplace.walmartapis.com/v3/items?limit=50";

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

            $code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($code == 201 || $code == 200) {
                 $response = json_decode($response,true);

                $data['all_items']=$response['ItemResponse'];

                    
                if(!empty($data['all_items'])){
                    foreach ($data['all_items'] as $item) {

                        $itemid = Walmart::select('id')->where('wpid', $item['wpid'])->where('created_by',auth()->user()->id)->get();

                        if(!empty($itemid) && count($itemid) > 0){


                        } else {
                        
                            $product_array = array(
                                'mart'      =>  !empty($item['mart'])?$item['mart']:'',
                                'wpid'           =>  !empty($item['wpid'])?$item['wpid']:'',
                                'sku'          =>  !empty($item['sku'])?$item['sku']:'',
                                'upc'         =>  !empty($item['upc'])?$item['upc']:'',
                                'gtin'           =>  !empty($item['gtin'])?$item['gtin']:'',
                                'productName'          =>  !empty($item['productName'])?$item['productName']:'',
                                'productType'          =>  !empty($item['productType'])?$item['productType']:'',
                                'price'    =>  !empty($item['price']['amount'])?$item['price']['amount']:'',
                                'currency'            =>  !empty($item['price']['currency'])?$item['price']['currency']:'',
                                'publishedStatus' =>  !empty($item['publishedStatus'])?$item['publishedStatus']:'',
                                'updated_by'      =>  auth()->user()->id,
                                'updated_at'    =>  date('Y-m-d H:i:s'),
                                'created_at'       => date('Y-m-d H:i:s'),
                                'created_by'     => auth()->user()->id
                            );

                            $result = Walmart::create($product_array);
                        }
                    }
                }

                return view('walmarts.items',$data);
            } else {
                return false;
            }

        }    

   }


    public function get_all_orders(){

            $user_id = auth()->user()->id;

            $walmart_settings = WalmartSettings::where('user_id','=',$user_id)->get();

            if ($walmart_settings->isEmpty()) {
                    $data['all_orders']=[];
                    return view('walmarts.orders',$data);

            }else{

                    $token = $this->getToken();
                    
                    $data = $this->getWalmartDetail();
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

                    $code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);
                        
                    if ($code == 201 || $code == 200) {
                         $response = json_decode($response,true);

                         $data['all_orders']=$response['list']['elements']['order'];

                         return view('walmarts.orders',$data);

                         
                    } else {
                        return false;
                    }

            }    

   }

   
}
