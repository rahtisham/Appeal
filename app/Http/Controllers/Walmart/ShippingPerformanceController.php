<?php

namespace App\Http\Controllers\Walmart;

use App\Http\Controllers\Controller;
use App\Integration\Walmart;
use App\Product;
use Illuminate\Http\Request;
use App\walmart_order_details;
use App\apiIntegrations;

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


        $this->validate($request ,[

            'clientName' => 'required',
            'clientID' => 'required',
            'clientSecretID' => 'required',

        ]);

        $response[] = Walmart::getItem($client_id , $secret);


        foreach ($response[0]['list']['elements']['order'] as $res)
        {

            $order_date = $res['orderDate'];
            $estimated_delivery_date = $res['shippingInfo']['estimatedDeliveryDate'];
            $estimated_ship_date = $res['shippingInfo']['estimatedShipDate'];

            $orderData = date("Y-m-d H:i:s", substr($order_date , 0, 10));
            $estimatedDeliveryDate = date("Y-m-d H:i:s", substr($estimated_delivery_date , 0, 10));
            $estimatedShipDate = date("Y-m-d H:i:s", substr($estimated_ship_date , 0, 10));

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
                'shippingProgramType' => $res['orderLines']['orderLine'][0]['fulfillment']['shippingProgramType'],
            ]);


        }
       // End of Foreach loop

        echo date("Y-m-d H:i:s", substr("1643918400000", 0, 10));

    }
    // End of function Shipping Performance
}
