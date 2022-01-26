<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Integration\Walmart;
use App\WalmartSettings;
use App\Product;
use App\Mail\SendMail;
use App\User;
use Illuminate\Support\Facades\DB;

class WalmartAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'walmart:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $Walmart = WalmartSettings::all();
        foreach ($Walmart as $getWalmart)
        {
            $client_id = $getWalmart['client_id'];
            $secret = $getWalmart['client_secret'];
            $user_id = $getWalmart['user_id'];


            $response[] = Walmart::getItem($client_id , $secret);
            // This is use to getting data from Walmart using API
            // it is called to walmart.php which is located in integration folder

            foreach ($response[0]['ItemResponse'] as $items) {

                $user = User::where('id' , '=' , $user_id)->get()->first();
                $email = $user->email;
                if(!empty($email))
                {
                    $unpublishedReasons = '';

                    if(array_key_exists('unpublishedReasons' ,$items))
                    {
                        $unpublished = $items['unpublishedReasons']['reason'];
                        $unpublishedReasons = implode(', ', $unpublished);
                    }

                    $publishedStatus = $items['publishedStatus'];

                    if($publishedStatus == "UNPUBLISHED" || $publishedStatus == "SYSTEM_PROBLEM" )
                    {

                        $detail = [
                        'productID' => $items['sku'],
                        'productName' => $items['productName'],
                        'publishedStatus' => $items['publishedStatus'],
                        'reason' => $unpublishedReasons,
                        'productLink' => "https://www.walmart.com/ip/".$items['sku'],
                        'userEmail' => $email
                       ];

                        $exp = explode(" " , $detail['reason']);
                        if(in_array("intellectual" , $exp))
                        {
                            \Log::info("founded");
                        }
                        else
                        {
                            \Log::info("Not Found");
                        }
//                        Mail::to($email)->send(new SendMail($detail));

                    }
                }

            }
           //End of walmart API's Data is being fetching using given query up'

        }
        //End of user fetching secret and client id



//        $products = Product::all();
//        foreach ($products as $products)
//        {
//            $user_id = $products['user_id'];
//
//            if($products['emailNotification'] == "Email Notification")
//            {
//                $user = User::where('id' , '=' , $user_id)->get()->first();
//                $email = $user->email;
//                if(!empty($email)) {
//                    $detail = [
//                        'productID' => $products['itemId'],
//                        'productName' => $products['Title'],
//                        'publishedStatus' => $products['publishedStatus'],
//                        'reason' => $products['unpublishedReasons'],
//                        'productLink' => "https://www.walmart.com/ip/".$products['itemId'],
//                        'userEmail' => $email
//                    ];
//                    Mail::to($email)->send(new SendMail($detail));
//                    $userUpdate = Product::where('emailNotification' , '=' , 'Email Notification')->get()->first();
//                    $userUpdate->emailNotification = "Email Has been Sent";
//                    $userUpdate->save();
//                    \Log::info("Email Has Been updated".$userUpdate);
//                }
//            }
//            else
//            {
//                \Log::info("Email is already sent".$user_id);
//            }
//        }
    }
}
