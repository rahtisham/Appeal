<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use DB;
use App\User;
use App\Order;
use App\AmazonSettings;
use App\Amazon;
use Auth;
use Hash;

use GuzzleHttp\Client;
use \ClouSale\AmazonSellingPartnerAPI AS AmazonSellingPartnerAPI;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
        $status = !empty($request->input('orderstatus'))?$request->input('orderstatus'):'';

        if(!empty($status)){

    	   $orders = Order::select()->where('orderStatus',$status)->orderby('id','DESC')->get();
        } else {

            $orders = Order::select()->orderby('id','DESC')->get();
            // echo '<pre>';
            // print_r($orders);
            // exit;

        }

        $data = array(
            'pageTitle' => "Order Listing",
            'status' => $status,
            'ordersList' => $orders
        );

        return view('order.list')->with($data);
    }

    function updateMwsOrderList()
    {
        $authtoken = "amzn.mws.c2b0a6c0-499d-f6e7-21f3-bfe6c9b072e6";

        $parameter = "AWSAccessKeyId=AKIAJ5LP6U6FDV6X3MDA&Action=ListOrders&CreatedAfter=2020-12-31T18%3A30%3A00Z&CreatedBefore=2021-01-31T18%3A30%3A00Z&MWSAuthToken=".$authtoken."&MarketplaceId.Id.1=ATVPDKIKX0DER&SellerId=A2JW9Q1FH2SWAI&SignatureMethod=HmacSHA256&SignatureVersion=2&Timestamp=".urlencode(gmdate("Y-m-d\TH:i:s\Z"))."&Version=2013-09-01";

        $url_string = "POST\nmws.amazonservices.com\n/Orders/2013-09-01\n".$parameter;
        $signature = hash_hmac("sha256", $url_string, "q4uEv7WGl7OsCIhffrJKuX4y4QnvEkmjEfQS5hMq", TRUE);
        $parameter = $parameter."&Signature=".urlencode(base64_encode($signature));


        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://mws.amazonservices.com/Orders/2013-09-01",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $parameter,
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded",
            "postman-token: a7ff838a-0e36-42cc-9e9a-76b8d3db2b27"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
        } else {

            $response = str_replace("ns2:","",$response);
            $xml= simplexml_load_string($response);

            if (isset($xml->ListOrdersResult->Orders->Order)) {

                $orderList = json_decode( json_encode($xml->ListOrdersResult->Orders) , 1);

                foreach ($orderList['Order'] as $order) {

                    $id = DB::table('tblamazonOrderList')->where('amazonOrderId', $order['AmazonOrderId'])->value('id');

                    if(isset($id) && !empty($id)){

                        //array_push($products_array, $attributeData);
                    } else {

                        if(strtolower($order['IsReplacementOrder']) == 'true'){ 
                            $isReplacementOrder = 1;
                        } else {
                            $isReplacementOrder = 0;
                        }
                        if(strtolower($order['IsBusinessOrder']) == 'true'){ 
                            $isBusinessOrder = 1;
                        } else {
                            $isBusinessOrder = 0;
                        }
                        if(strtolower($order['IsPremiumOrder']) == 'true'){ 
                            $isPremiumOrder = 1;
                        } else {
                            $isPremiumOrder = 0;
                        }
                        if(isset($order['ShippingAddress']) && strtolower($order['ShippingAddress']['isAddressSharingConfidential']) == 'true'){ 
                            $isAddressSharingConfidential = 1;
                        } else {
                            $isAddressSharingConfidential = 0;
                        }

                        $orderData = array();
                        $orderData['amazonOrderId'] = $order['AmazonOrderId'];
                        $orderData['orderType'] = !empty($order['AmazonOrderId'])?$order['OrderType']:'';
                        $orderData['purchaseDate'] = date("Y-m-d H:i:s", strtotime($order['PurchaseDate']));
                        $orderData['latestShipDate'] = date("Y-m-d H:i:s", strtotime($order['LatestShipDate']));
                        $orderData['isReplacementOrder'] = $isReplacementOrder;
                        $orderData['numberOfItemsShipped'] = !empty($order['NumberOfItemsShipped'])?$order['NumberOfItemsShipped']:0;
                        $orderData['shipServiceLevel'] = !empty($order['ShipServiceLevel'])?$order['ShipServiceLevel']:'';
                        $orderData['orderStatus'] = !empty($order['OrderStatus'])?$order['OrderStatus']:'';
                        $orderData['isBusinessOrder'] = $isBusinessOrder;
                        $orderData['numberOfItemsUnshipped'] = !empty($order['NumberOfItemsUnshipped'])?$order['NumberOfItemsUnshipped']:0;
                        $orderData['paymentMethod'] = !empty($order['PaymentMethod'])?$order['PaymentMethod']:'';
                        $orderData['paymentMethodDetail'] = !empty($order['PaymentMethodDetails'])?$order['PaymentMethodDetails']['PaymentMethodDetail']:'';
                        $orderData['isPremiumOrder'] = $isPremiumOrder;

                        if(isset($order['OrderTotal']) && !empty($order['OrderTotal'])){
                            $orderData['amount'] = $order['OrderTotal']['Amount'];
                            $orderData['currencyCode'] = $order['OrderTotal']['CurrencyCode'];
                        }

                        if(isset($order['ShippingAddress']) && !empty($order['ShippingAddress'])){
                            $orderData['city'] = $order['ShippingAddress']['City'];
                            $orderData['postalCode'] = $order['ShippingAddress']['PostalCode'];
                            $orderData['stateOrRegion'] = $order['ShippingAddress']['StateOrRegion'];
                            $orderData['countryCode'] = $order['ShippingAddress']['CountryCode'];
                            $orderData['isAddressSharingConfidential'] = $isAddressSharingConfidential;
                        }

                        $orderData['shipmentServiceLevelCategory'] = !empty($order['ShipmentServiceLevelCategory'])?$order['ShipmentServiceLevelCategory']:'';
                        $orderData['created_at'] = date('Y-m-d H:i:s', time());
                        $orderData['created_by'] = auth()->user()->id;
                        $orderData['updated_at'] = date('Y-m-d H:i:s', time());
                        $orderData['updated_by'] = auth()->user()->id;

                        $result = Order::create($orderData);

                        if($result){
                            Session::flash('message', 'Order List updated Successfully.');
                            Session::flash('alert-class', 'alert-success');
                        } else {
                            Session::flash('message', 'Something went wrong');
                            Session::flash('alert-class', 'alert-danger');
                        }
                        /*$result = AmazonMWS::create($attributeData);

                        if($result){
                            array_push($products_array, $attributeData);
                        }*/
                    }
                    
                }

                return redirect()->route('amazon.orderList');
            }


        }
    }

    public function refreshAmazonOrders(){

        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        //echo "<pre>";print_r($amazonSetting->role_arn);exit;
        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);

        $marketplace_ids = $amazonSetting->marketplace_id;
        $created_after = "2019-08-30";
        $created_before = "";
        $last_updated_after = "";
        $last_updated_before = "";
        //$order_statuses = array("Pending","Unshipped","Shipped","Canceled","Unfulfillable");
        $order_statuses = array();
        $fulfillment_channels = array();
        $payment_methods = array();
        $buyer_email = "";
        $seller_order_id = "";
        $max_results_per_page = "";
        $easy_ship_shipment_statuses = array("");
        $next_token = "";
        $amazon_order_ids = array("");

        $orderList = $amazon->getOrders($marketplace_ids, $created_after, $created_before, $last_updated_after, $last_updated_before, $order_statuses, $fulfillment_channels, $payment_methods, $buyer_email, $seller_order_id, $max_results_per_page, $easy_ship_shipment_statuses, $next_token, $amazon_order_ids);
        echo "<pre>";print_r($orderList);exit;
        foreach ($orderList as $order) {

            $id = DB::table('tblamazonOrderList')->where('amazonOrderId', $order->AmazonOrderId)->value('id');

            if(isset($id) && !empty($id)){

                //array_push($products_array, $attributeData);
            } else {

                if(strtolower($order->IsReplacementOrder) == 'true'){ 
                    $isReplacementOrder = 1;
                } else {
                    $isReplacementOrder = 0;
                }
                if(strtolower($order->IsBusinessOrder) == 'true'){ 
                    $isBusinessOrder = 1;
                } else {
                    $isBusinessOrder = 0;
                }
                if(strtolower($order->IsPremiumOrder) == 'true'){ 
                    $isPremiumOrder = 1;
                } else {
                    $isPremiumOrder = 0;
                }
                /*if(isset($order->ShippingAddress) && strtolower($order->ShippingAddress->isAddressSharingConfidential) == 'true'){ 
                    $isAddressSharingConfidential = 1;
                } else {
                    $isAddressSharingConfidential = 0;
                }*/

                $orderData = array();
                $orderData['amazonOrderId'] = $order->AmazonOrderId;
                $orderData['orderType'] = !empty($order->AmazonOrderId)?$order->OrderType:'';
                $orderData['purchaseDate'] = date("Y-m-d H:i:s", strtotime($order->PurchaseDate));
                $orderData['latestShipDate'] = date("Y-m-d H:i:s", strtotime($order->LatestShipDate));
                $orderData['isReplacementOrder'] = $isReplacementOrder;
                $orderData['numberOfItemsShipped'] = !empty($order->NumberOfItemsShipped)?$order->NumberOfItemsShipped:0;
                $orderData['shipServiceLevel'] = !empty($order->ShipServiceLevel)?$order->ShipServiceLevel:'';
                $orderData['orderStatus'] = !empty($order->OrderStatus)?$order->OrderStatus:'';
                $orderData['isBusinessOrder'] = $isBusinessOrder;
                $orderData['numberOfItemsUnshipped'] = !empty($order->NumberOfItemsUnshipped)?$order->NumberOfItemsUnshipped:0;
                $orderData['paymentMethod'] = !empty($order->PaymentMethod)?$order->PaymentMethod:'';
                $orderData['paymentMethodDetail'] = !empty($order->PaymentMethodDetails)?$order->PaymentMethodDetails[0]:'';
                $orderData['isPremiumOrder'] = $isPremiumOrder;

                if(isset($order->OrderTotal) && !empty($order->OrderTotal)){
                    $orderData['amount'] = $order->OrderTotal->Amount;
                    $orderData['currencyCode'] = $order->OrderTotal->CurrencyCode;
                }


                /*if(isset($order->ShippingAddress) && !empty($order->ShippingAddress)){
                    $orderData['city'] = $order->ShippingAddress->City;
                    $orderData['postalCode'] = $order->ShippingAddress->PostalCode;
                    $orderData['stateOrRegion'] = $order->ShippingAddress->StateOrRegion;
                    $orderData['countryCode'] = $order->ShippingAddress->CountryCode;
                    $orderData['isAddressSharingConfidential'] = $isAddressSharingConfidential;
                }*/

                $orderData['shipmentServiceLevelCategory'] = !empty($order->ShipmentServiceLevelCategory)?$order->ShipmentServiceLevelCategory:'';
                $orderData['created_at'] = date('Y-m-d H:i:s', time());
                $orderData['created_by'] = auth()->user()->id;
                $orderData['updated_at'] = date('Y-m-d H:i:s', time());
                $orderData['updated_by'] = auth()->user()->id;

                $result = Order::create($orderData);

                if($result){
                    Session::flash('message', 'Order List updated Successfully.');
                    Session::flash('alert-class', 'alert-success');
                } else {
                    Session::flash('message', 'Something went wrong');
                    Session::flash('alert-class', 'alert-danger');
                }
                /*$result = AmazonMWS::create($attributeData);

                if($result){
                    array_push($products_array, $attributeData);
                }*/
            }
        }
        return redirect()->route('amazon.orderList');
    }

    public function feedbackRequest(){
        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);
        echo "<pre>";print_r($amazonSetting);exit;

        $parameter = array("reportOptions"=>array(), "reportType" => "GET_SELLER_FEEDBACK_DATA", "dataStartTime"=>"2020-09-22T08:41:00.794Z", "dataEndTime" => "2021-11-09T11:30:10.802Z", "marketplaceIds"=> array($amazonSetting->marketplace_id));

        $requestresponse = $amazon->createReport($parameter);

        echo $requestresponse;exit;

        /*$controller = new Controller();
        $config = $controller->getConfig();

        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\ReportsApi(
                 //new GuzzleHttp\Client(),
                 $config
        );

        //echo "<pre>";print_r($apiInstance);exit;
        $body = array("reportOptions"=>array(), "reportType" => "GET_SELLER_FEEDBACK_DATA", "dataStartTime"=>"2020-09-22T08:41:00.794Z", "dataEndTime" => "2021-11-09T11:30:10.802Z", "marketplaceIds"=> array($amazonSetting->marketplace_id));
        $marketplace_ids = "ATVPDKIKX0DER"; 
        $reportOptions = array();
        $dataStartTime = "1945-09-22T08:41:00.794Z";
        $dataEndTime = "2001-11-09T11:30:10.802Z";

        try {
            $result = $apiInstance->createReport($body);
            echo "<pre>"; print_r($result);exit;
        } catch (Exception $e) {
            echo 'Exception when calling OrdersV0Api->getOrders: ', $e->getMessage(), PHP_EOL;
        }*/
    }

    public function performanceRequest(){
        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        //echo "<pre>";print_r($amazonSetting->role_arn);exit;
        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);

        $requestresponse = $amazon->createReport("GET_V2_SELLER_PERFORMANCE_REPORT",$amazonSetting->marketplace_id);

        echo $requestresponse;exit;
    }

    public function orderReportRequest(){
        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);

        $parameter = array("reportOptions"=>array(), "reportType" => "GET_FLAT_FILE_ALL_ORDERS_DATA_BY_LAST_UPDATE_GENERAL", "dataStartTime"=>"2020-09-22T08:41:00.794Z", "dataEndTime" => "2021-11-09T11:30:10.802Z", "marketplaceIds"=> $amazonSetting->marketplace_id);

        $requestresponse = $amazon->createReport($parameter);

        echo $requestresponse;exit;
    }

    public function getorderreport(){
        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);

        $orderreportid = "";

        $requestresponse = $amazon->getReport($orderreportid);

        echo $requestresponse;exit;
    }

    public function getorderreportdocument(){
        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);

        $orderreportDocumentId = "";

        $requestresponse = $amazon->getReportDocument($orderreportDocumentId);

        echo $requestresponse;exit;
    }
}
