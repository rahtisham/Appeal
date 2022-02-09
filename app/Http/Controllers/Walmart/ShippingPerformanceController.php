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

            $token = Walmart::getToken($client_id, $secret);
            $token = $token['access_token'];  // Token generated

            $response[] = Walmart::getItemOrder($client_id, $secret, $token ,$createdStartDate);

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

            }
            // End of else condition
        }
        // End of IF Condition
        else
        {

            $token = Walmart::getToken($client_id, $secret);
            $token = $token['access_token'];  // Token generated

            $response[] = Walmart::getItemOrder($client_id, $secret , $token ,$createdStartDate = 0);

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
            ini_set('max_execution_time', '700');

            $client_id = $request->get('clientID');
            $secret = $request->get('clientSecretID');

            $order_status = '';
            $actualShipDateTimes = '';
            $carrierName = '';

            $walmart_order = walmart_order_details::where('status', '!=', 'Delivered')->get();
            $token = Walmart::getToken($client_id, $secret);
            $token = $token['access_token'];  // Token generated


            foreach ($walmart_order as $order_status_databaseTable) {

                    $order_purchade_id = $order_status_databaseTable['purchaseOrderId'];
                    $response = Walmart::getItemAnOrder($client_id, $secret, $token, $order_purchade_id);
                    $live_status = $response['order']['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['status'];
                   
                    if($response['order']['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['trackingInfo'] != null){
                        $actualShipDateTime =  $response['order']['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['trackingInfo']['shipDateTime'];
                        $actualShipDateTimes = date("Y-m-d", substr($actualShipDateTime, 0, 10));

                        $carrierName =  $response['order']['orderLines']['orderLine'][0]['orderLineStatuses']['orderLineStatus'][0]['trackingInfo']['carrierName']['carrier'];
                    }
                    if($live_status == 'Acknowledged'){
                            $order_status = 'Acknowledged101';
                            $query = walmart_order_details::where('purchaseOrderId', $order_purchade_id)
                                                            ->update(['status' => $order_status]);
                        }
                        elseif($live_status == 'Created'){
                            $order_status = 'Created101';
                            $query = walmart_order_details::where('purchaseOrderId', $order_purchade_id)
                                                            ->update(['status' => $order_status]);
                        }
                        elseif($live_status == 'Shipped'){
                            $order_status = 'Shipped101';

                            //  $estimatedShipDate = strtotime($order_status_databaseTable['estimatedShipDate']);
                            //  $actualShipDate = strtotime($order_status_databaseTable['actualShipDate']);

                            // if($actualShipDate < $estimatedShipDate)
                            // {
                            //     return "Excellent";
                            // }
                            // elseif($actualShipDate <= $estimatedShipDate)
                            // {
                            //     return "good";
                            // }
                            // elseif($actualShipDate > $estimatedShipDate)
                            // {
                            //     return "Poor";
                            // }
                            
                            
                            $query = walmart_order_details::where('purchaseOrderId', $order_purchade_id)
                                                            ->update(['status' => $order_status , 
                                                                      'actualShipDate' => $actualShipDateTimes,
                                                                      'carrierName' => $carrierName]);
                        }
                        elseif($live_status == 'Delivered'){
                            $order_status = 'Delivered101';
                            $query = walmart_order_details::where('purchaseOrderId', $order_purchade_id)
                                                            ->update(['status' => $order_status, 
                                                                      'actualDeliveryDate' => date('Y-m-d')]);
                        }
                        
              // End of if condition regarding created
            }


            // End of foreach loop
        }
    // End of order_status_check



    }
    // End of function Class

