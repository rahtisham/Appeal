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

class testingApiController extends Controller
{
    public function index()
    {
        return view('walmartIntegration.testing');
    }

    public function testing(Request $request)
    {

        $client_id = $request->get('clientID');
        $secret = $request->get('clientSecretID');


        $this->validate($request ,[

            'clientName' => 'required',
            'clientID' => 'required',
            'clientSecretID' => 'required',

        ]);

        $token = Walmart::getToken($client_id, $secret);
        $token = $token['access_token'];  // Token generated

        $response[] = Walmart::getItemTesting($client_id , $secret , $token);
        return $response;
        // Walmart taken generate with Original data
        $authorization = base64_encode($client_id.":".$secret);
        $token = Walmart::getToken($client_id , $secret);
        $token = $token['access_token'];
        $requestID = uniqid();
//        return $requestID;

        $ApiIntegration = apiIntegrations::where('client_id' , $client_id)->first();
        $clientIntegrationId =  $ApiIntegration->id;

        foreach ($response[0]['ItemResponse'] as $items) {

            $unpublishedReasons = '';

            if(array_key_exists('unpublishedReasons' ,$items))
            {
                $unpublished = $items['unpublishedReasons']['reason'];
                $unpublishedReasons = implode(', ', $unpublished);
            }

            $status = 'test';
            if($items['publishedStatus'] === "UNPUBLISHED")
            {
                $status = "Email Notification";
            }


            $price = $items['price']['amount'];

            $productItems = Product::create([
                'itemId' => $items['wpid'],
                'user_id' => auth()->user()->id,
                'client_id' => $clientIntegrationId,
                'UPC' => $items['upc'],
                'SKU' => $items['sku'],
                'Title' => $items['productName'],
                'price' => $price,
                'unpublishedReasons' => $unpublishedReasons,
                'lifeStatus' => $items['lifecycleStatus'],
                'publishedStatus' => $items['publishedStatus'],
                'emailNotification' => $status
            ]);

        }
        //End loop
        if ($productItems)
        {
            echo "Data Inserted";
            log::info('Walmart API Data Have Been Interted');
        }
        else
        {
            echo "Data did not insert";
        }



    }
    //End function
}
