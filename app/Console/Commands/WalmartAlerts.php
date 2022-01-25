<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
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

        $products = Product::all();
        foreach ($products as $products)
        {
            $user_id = $products['user_id'];

            if($products['emailNotification'] == "Email Notification")
            {
                $user = User::where('id' , '=' , $user_id)->get()->first();
                $email = $user->email;
                if(!empty($email)) {
                    $detail = [
                        'productID' => $products['itemId'],
                        'productName' => $products['Title'],
                        'publishedStatus' => $products['publishedStatus'],
                        'reason' => $products['unpublishedReasons'],
                        'productLink' => "https://www.walmart.com/ip/".$products['itemId'],
                        'userEmail' => $email
                    ];
                    Mail::to($email)->send(new SendMail($detail));
                    $userUpdate = Product::where('emailNotification' , '=' , 'Email Notification')->get()->first();
                    $userUpdate->emailNotification = "Email Has been Sent";
                    $userUpdate->save();
                    \Log::info("Email Has Been updated".$userUpdate);
                }
            }
            else
            {
                \Log::info("Email is already sent".$user_id);
            }
        }
    }
}
