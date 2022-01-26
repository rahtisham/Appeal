<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Integration\Walmart;
use App\Product;
use App\WalmartItemAlert;
use App\WalmartSettings;
use App\User;

class WalmartGetAllTemsController extends Controller
{
    public function index()
    {
        return view('walmartIntegration.walmart');
    }

    public function checkProduct(Request $request)
    {
         $client_id = $request->get('clientID');
         $secret = $request->get('clientSecretID');


        $this->validate($request ,[

            'clientName' => 'required',
            'clientID' => 'required',
            'clientSecretID' => 'required',

        ]);



        $token = Walmart::getToken($client_id , $secret);
        $token = $token['access_token'];
        $total_records = 1000;
        $per_page = 200;
        $no_of_pages = $total_records/$per_page;
        $offset = 0;
        $res = [];
        for ($i=0; $i<$no_of_pages; $i++){
            $url = "https://marketplace.walmartapis.com/v3/items?offset=".$offset."&limit=".$per_page;
            $requestID = uniqid();
            $authorization = base64_encode($client_id.":".$secret);


            $curl = curl_init();

            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'WM_SVC.NAME: Walmart Marketplace',
                    'Authorization: Basic '.$authorization,
                    'WM_QOS.CORRELATION_ID: '.$requestID,
                    'WM_SEC.ACCESS_TOKEN: '.$token,
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Cookie: TS01f4281b=0130aff232afca32ba07d065849e80b32e6ebaf11747c58191b2b4c9d5dd53a042f7d890988bf797d7007bddb746c3b59d5ee859d0'
                ),
                CURLOPT_HTTPGET => true,
            );

            curl_setopt_array($curl,$options);
            $response = curl_exec($curl);
            $code = curl_getinfo($curl,CURLINFO_HTTP_CODE);

            curl_close($curl);
            $response = json_decode($response,true);
//            return $response;
            foreach ($response['ItemResponse'] as $items) {

                $unpublishedReasons = '';
                if(array_key_exists('unpublishedReasons' ,$items))
                {
                    $unpublished = $items['unpublishedReasons']['reason'];
                    $unpublishedReasons = implode(' ', $unpublished);
                }

                $exp = explode(" " , $unpublishedReasons);
                $alert_type = 'Offensive Product';
                if(in_array("intellectual" , $exp))
                {
                    $alert_type = 'IP Claim';
                }

                if($items['publishedStatus'] === "SYSTEM_PROBLEM" || $items['publishedStatus'] === "UNPUBLISHED") {

                    $walmartAlerts = WalmartItemAlert::create([
                        'sku' => $items['sku'],
                        'product_name' => $items['productName'],
                        'reason' => $unpublishedReasons,
                        'alert_type' => $alert_type,
                        'status' => $items['publishedStatus'],
                        'product_url' => $items['sku'],
                    ]);
                }

//                if($items['publishedStatus'] === "UNPUBLISHED") {
//
//                    $walmartAlerts = WalmartItemAlert::create([
//                        'sku' => $items['sku'],
//                        'product_name' => $items['productName'],
//                        'reason' => $unpublishedReasons,
//                        'alert_type' => $alert_type,
//                        'status' => $items['publishedStatus'],
//                        'product_url' => $items['sku'],
//                    ]);
//                }

            }
            //End loop

          $offset ++;

        }
//        return  $response = $res;


        $walmartData = WalmartItemAlert::all()->groupBy('alert_type');

        $user = User::where('id' , '=' , '28')->get()->first();
        $email = $user->email;

        if (!empty($email)) {
                if(isset($walmartData['IP Claim'])  && count($walmartData['IP Claim']) > 0){
                    $detail = [];
                    foreach ($walmartData['IP Claim'] as $ipClaim) {
                        $detail[] = [
                            'productID' => $ipClaim['sku'],
                            'productName' => $ipClaim['product_name'],
                            'publishedStatus' => $ipClaim['status'],
                            'reason' => $ipClaim['reason'],
                            'productLink' => "https://www.walmart.com/ip/".$ipClaim['sku'],
                            'userEmail' => $email
                        ];
                    }
                    Mail::to($email)->send(new SendMail($detail));
                }
                if(count($walmartData['Offensive Product']) > 0){
                    $detail = [];
                    foreach ($walmartData['Offensive Product'] as $offensiveProduct) {
                        $detail[] = [
                            'productID' => $offensiveProduct['sku'],
                            'productName' => $offensiveProduct['product_name'],
                            'publishedStatus' => $offensiveProduct['status'],
                            'reason' => $offensiveProduct['reason'],
                            'productLink' => "https://www.walmart.com/ip/".$offensiveProduct['sku'],
                            'userEmail' => $email
                        ];
                    }
                    Mail::to($email)->send(new SendMail($detail));
                }

         }


    }
    //End function

}
