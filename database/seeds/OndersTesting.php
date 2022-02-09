<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\walmart_order_details;

class OndersTesting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
       foreach(range(1 , 10) as $value)
       {
            DB::table('walmart_order_details')->insert([
                'user_id' => $faker->user_id,
                'purchaseOrderId' => $faker->purchaseOrderId,
                'customerOrderId' => $faker->customerOrderId,
                'order_date' => $faker->order_date,
                'estimatedDeliveryDate' => $faker->estimatedDeliveryDate,
                'estimatedShipDate' => $faker->estimatedShipDate,
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country,
                'status' => $faker->status,
                'postal_code' => $faker->postal_code,
                'cancellationReason' => $faker->cancellationReason,
                'shippingProgramType' => $faker->shippingProgramType,
                'created_at' => $faker->created_at,
                'update_at' => $faker->update_at
            ]);
       }
       
    }
}



