<?php

namespace App\Http\Controllers\Walmart;

use App\Http\Controllers\Controller;
use App\Integration\Walmart;
use App\Product;
use Illuminate\Http\Request;
use App\walmart_order_details;
use App\apiIntegrations;
use Carbon\Carbon;
use phpDocumentor\Reflection\Utils;

class ShippingPerformanceController extends Controller
{
    public function index()
    {
        return view('walmartIntegration.shipping_performance');
    }


    public function ShippingPerformance(Request $request)
    {

        $client_id = $request->get('clientID');
        $secret = $request->get('clientSecretID');


        $this->validate($request, [

            'clientName' => 'required',
            'clientID' => 'required',
            'clientSecretID' => 'required',

        ]);

        $walmartOrderDetails = walmart_order_details::count();

        if ($walmartOrderDetails > 0) {

            $data_last = walmart_order_details::latest()->first();
            $createdStartDates = $data_last['order_date'];
            $createdStartDate = Carbon::parse($createdStartDates)->addDay();
//            $createdStartDate = date('Y-m-d' , time());
            $response[] = Walmart::getItem($client_id, $secret ,$createdStartDate);

            if ($response[0]) {

                foreach ($response[0]['list']['elements']['order'] as $res) {

                    $order_date = $res['orderDate'];
                    $estimated_delivery_date = $res['shippingInfo']['estimatedDeliveryDate'];
                    $estimated_ship_date = $res['shippingInfo']['estimatedShipDate'];

                    // $orderData = date("Y-m-d H:i:s", substr($order_date , 0, 10));
                    $orderData = date("Y-m-d", substr($order_date, 0, 10));
                    $estimatedDeliveryDate = date("Y-m-d", substr($estimated_delivery_date, 0, 10));
                    $estimatedShipDate = date("Y-m-d", substr($estimated_ship_date, 0, 10));

                    $walmart_order_details = walmart_order_details::create([
                        'user_id' => "1",
                        'purchaseOrderId' => $res['purchaseOrderId'],
                        'customerOrderId' => $res['customerOrderId'],
                        'order_date' => $orderData,
                        'estimatedDeliveryDate' => $estimatedDeliveryDate,
                        'estimatedShipDate' => $estimatedShipDate,
                        'city' => $res['shippingInfo']['postalAddress']['city'],
                        'state' => $res['shippingInfo']['postalAddress']['state'],
                        'country' => $res['shippingInfo']['postalAddress']['country'],
                        'status' => $res['shippingInfo']['postalAddress']['state'],
                        'postal_code' => $res['shippingInfo']['postalAddress']['postalCode'],
                        'cancellationReason' => $res['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['cancellationReason'],
                        'status' => $res['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['status'],
                        'shippingProgramType' => $res['orderLines']['orderLine'][0]['fulfillment']['shippingProgramType'],
                    ]);

                }
                // End of Foreach loop
            }
            // End of IF Condition
            else{


                echo "No Current Record in API ";
//                $walmart_order_Detail = walmart_order_details::all();
//
//                foreach ($walmart_order_Detail as $orderDetail)
//                {
//                    $order_date = $orderDetail['order_date'];
//                    $estimated_delivery_date = $orderDetail['estimatedDeliveryDate'];
//                    $status = $orderDetail['status'];
//
//                    $startTimeStamp = strtotime($order_date);
//                    $endTimeStamp = strtotime($estimated_delivery_date);
//                    $timeDiff = abs($endTimeStamp - $startTimeStamp);
//                    $numberOfDays = $timeDiff/86400;  // 86400 seconds in one day
//                    $numberDays = intval($numberOfDays);
//                    echo $numberDays."<br>";
//
//                     $todayDate = "2022-02-10";
//
//
//
//                }
                // End of foreach loop
            }
            // End of else condition
        }
        // End of IF Condition
        else
        {

            $response[] = Walmart::getItem($client_id, $secret ,$createdStartDate = 0);

            if (count($response) > 0) {

                foreach ($response[0]['list']['elements']['order'] as $res) {

                    $order_date = $res['orderDate'];
                    $estimated_delivery_date = $res['shippingInfo']['estimatedDeliveryDate'];
                    $estimated_ship_date = $res['shippingInfo']['estimatedShipDate'];

                    // $orderData = date("Y-m-d H:i:s", substr($order_date , 0, 10));
                    $orderData = date("Y-m-d", substr($order_date, 0, 10));
                    $estimatedDeliveryDate = date("Y-m-d", substr($estimated_delivery_date, 0, 10));
                    $estimatedShipDate = date("Y-m-d", substr($estimated_ship_date, 0, 10));

                    $walmart_order_details = walmart_order_details::create([
                        'user_id' => "2",
                        'purchaseOrderId' => $res['purchaseOrderId'],
                        'customerOrderId' => $res['customerOrderId'],
                        'order_date' => $orderData,
                        'estimatedDeliveryDate' => $estimatedDeliveryDate,
                        'estimatedShipDate' => $estimatedShipDate,
                        'city' => $res['shippingInfo']['postalAddress']['city'],
                        'state' => $res['shippingInfo']['postalAddress']['state'],
                        'country' => $res['shippingInfo']['postalAddress']['country'],
                        'status' => $res['shippingInfo']['postalAddress']['state'],
                        'postal_code' => $res['shippingInfo']['postalAddress']['postalCode'],
                        'cancellationReason' => $res['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['cancellationReason'],
                        'status' => $res['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['status'],
                        'shippingProgramType' => $res['orderLines']['orderLine'][0]['fulfillment']['shippingProgramType'],
                    ]);

                }
                // End of Foreach loop
            }
            // End of IF Condition
        }
        // End of ELSE condition
      }
    // End of function Shipping Performance

    public function order_status_check(Request $request)
    {
        $client_id = $request->get('clientID');
        $secret = $request->get('clientSecretID');

        $walmart_order = walmart_order_details::all();
        foreach ($walmart_order as $order_status_databaseTable)
        {
//            $order_status_databaseTable['purchaseOrderId'];
//            $status = $order_status_databaseTable['status'];
//            $purchaseID = $order_status_databaseTable['purchaseOrderId'];

            $order_purchade_id = "7870331028520";

            $response[] = Walmart::getItem($client_id, $secret ,$order_purchade_id);

            if(!empty($response)) {

                $order_status_check = $response[0]['list']['elements']['order'][0]['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['status'];
                $purchaseID = $response[0]['list']['elements']['order'][0]['purchaseOrderId'];

                if (!empty($purchaseID)) {
                    $UpdateDetails = walmart_order_details::where('purchaseOrderId', '=', $purchaseID)->first();
                    $UpdateDetails->status = "Delivered";
                    $UpdateDetails->save();
                    return "Order Status Updated";
                }
            }

        }
        // End of foreach loop
     }
    // End of order_status_check





    }
    // End of function Class

