<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;

use App\User;
use Auth;
use Hash;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
        ini_set("max_execution_time", 3600);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array('pageTitle' => "Dashboard");
        $data['active_user'] = DB::table('users')
            ->select('*')
            ->where('status','Active')
            ->count();
        DB::enableQueryLog();
        $data['subscribers'] = DB::table('subscribers')
            ->select('*')
            //->where(DATE_ADD(`created` , INTERVAL `months` month),'>',now())
            ->where('created', '>', 'DATE_SUB(now() , INTERVAL `months` month)')
            ->count();

        //dd(DB::getQueryLog());exit;

        //echo "<pre>";print_r($data);exit;

        return view('home')->with($data);
    }
    
    public function createShipmentPlan(){
        $controller = new Controller();
        $config = $controller->getConfig();

        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\FbaInboundApi($config);

        /*$Bodypart = array(
                'ship_from_address' => array(
                    'name' => 'Gorilla Store',
                    'address_line1' => '9637 Pierrront ST',
                    'address_line2' => 'BURKE',
                    'address_line3' => '',
                    'state_or_region'=> 'VA',
                    'city' => 'Richmond',
                    'country_code' => 'US',
                    'postal_code' => '20015',
                    'email' => 'test@yopmail.com',
                    'copy_emails' => 'test@yopmail.com',
                    'phone_number' => '9898653214'
                ),
                'label_prep_preference' => \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\LabelPrepPreference::SELLER_LABEL,
                'ship_to_country_code' => 'US',
                'ship_to_country_subdivision_code' => '',
                'inbound_shipment_plan_request_items' => array(
                    array(
                        'seller_sku' => '',
                        'asin' => '',
                        'condition' => 'NewItem',
                        'quantity' => '5',
                        'quantity_in_case' => '',
                        'prep_details_list' => array(
                            'prep_instruction' => 'BubbleWrapping ',
                            'prep_owner' => 'SELLER'
                        )
                    )
                )
        );*/
        $newbody = array(
                "ShipFromAddress"=> array(
                        "Name"=> "sunt in",
                        "AddressLine1"=> "9637 Pierrront ST",
                        "AddressLine2"=> "enim sint in",
                        "DistrictOrCounty"=> "United States",
                        "City"=> "Richmond",
                        "StateOrProvinceCode"=> "VA",
                        "CountryCode"=> "US",
                        "PostalCode"=> "20015"
                    ),
                "InboundShipmentPlanRequestItems"=> array(
                        array(
                            "ASIN"=> "B099VMT8VZ",
                            "Condition"=> "NewOpenBox",
                            "Quantity"=> 120,
                            "SellerSKU"=> "dolore pariatur quis",
                            "QuantityInCase"=> 20
                        )
                    ),
                    "LabelPrepPreference"=> "SELLER_LABEL",
                    "ShipToCountryCode"=> "US"
            );

        $state = new \ClouSale\AmazonSellingPartnerAPI\Models\Shipping\StateOrRegion();
        $state->setters('VA');

        $city = new \ClouSale\AmazonSellingPartnerAPI\Models\Shipping\City();
        $city->setters('Richmond');

        $country = new \ClouSale\AmazonSellingPartnerAPI\Models\Shipping\CountryCode();
        $country->setters('US');

        $postcode = new \ClouSale\AmazonSellingPartnerAPI\Models\Shipping\PostalCode();
        $postcode->setters('20015');

        $Address = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\Address();
        $Address->setName('Gorilla Store');
        $Address->setAddressLine1('BURKE');
        $Address->setAddressLine2('BURKE');
        $Address->setDistrictOrCounty('US');
        $Address->setCity('Richmond');
        $Address->setStateOrProvinceCode('VA');
        $Address->setCountryCode('US');
        $Address->setPostalCode('20015');

        $labpref = \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\LabelPrepPreference::SELLER_LABEL;

        $prepDetail = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\PrepDetails();
        $prepDetail->setPrepInstruction('LABELING');
        $prepDetail->setPrepOwner('SELLER');

        $prepDetails = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\PrepDetailsList();
        $prepDetails->setters($prepDetail);

        $planRequestItem = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\InboundShipmentPlanRequestItem();
        $planRequestItem->setSellerSku('dolore pariatur quis');
        $planRequestItem->setAsin('B099VMT8VZ');
        $planRequestItem->setCondition('NewItem');
        $planRequestItem->setQuantity(120);
        $planRequestItem->setQuantityInCase(20);
        //$planRequestItem->setPrepDetailsList($prepDetails);

        $planRequestItems = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\InboundShipmentPlanRequestItemList();
        //$planRequestItems[] = $planRequestItem;
        $planRequestItems[] = array(
                                "ASIN"=> "B099VMT8VZ",
                                "Condition"=> "NewOpenBox",
                                "Quantity"=> 120,
                                "SellerSKU"=> "dolore pariatur quis",
                                "QuantityInCase"=> 20
                            );

        $httpBody = new \ClouSale\AmazonSellingPartnerAPI\Models\FulfillmentInbound\CreateInboundShipmentPlanRequest();
        $httpBody->setShipFromAddress($Address);
        $httpBody->setLabelPrepPreference($labpref);
        $httpBody->setShipToCountryCode('US');
        //$httpBody->setShipToCountrySubdivisionCode('US-NJ');
        $httpBody->setInboundShipmentPlanRequestItems($planRequestItem);
        
        //echo "<pre>";print_r($httpBody);exit;

        /*$httpBody = array( 
            "Body" => array(
                'ShipFromAddress' => array(
                    'Name' => 'Gorilla Store',
                    'AddressLine1' => '9637 Pierrront ST',
                    'AddressLine2' => 'BURKE',
                    'DistrictOrCounty'=> 'US',
                    'City' => 'Richmond',
                    'StateOrProvinceCode' => 'VA',
                    'CountryCode' => 'US',
                    'PostalCode' => '20015'
                ),
                'LabelPrepPreference' => 'SELLER_LABEL',
                'ShipToCountryCode' => 'US',
                'ShipToCountrySubdivisionCode' => '',
                'InboundShipmentPlanRequestItems' => array(
                    array(
                        'SellerSKU' => '',
                        'ASIN' => '',
                        'Condition' => 'NewItem',
                        'Quantity' => '5',
                        'QuantityInCase' => '',
                        'PrepDetailsList' => array(
                            'PrepInstruction' => 'BubbleWrapping ',
                            'PrepOwner' => 'SELLER'
                        )
                    )
                )
            )
        );*/

        try {
            $result = $apiInstance->createInboundShipmentPlan($httpBody);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling FbaInboundApi->createInboundShipmentPlan: ', $e->getMessage(), PHP_EOL;
        }
    }

    public function logout() {
      Auth::logout();

      return redirect('login');
    }

    public function getPrepInstructions(){

        $parameter = '{
                "ShipFromAddress": {
                        "Name": "sunt in",
                        "AddressLine1": "9637 Pierrront ST",
                        "AddressLine2": "enim sint in",
                        "DistrictOrCounty": "United States",
                        "City": "Richmond",
                        "StateOrProvinceCode": "VA",
                        "CountryCode": "US",
                        "PostalCode": "20015"
                    },
                "InboundShipmentPlanRequestItems": [
                        {
                            "ASIN": "B07V5JLD75",
                            "Condition": "New",
                            "Quantity": 120,
                            "SellerSKU": "41GG12GG-2",
                            "QuantityInCase": 20
                        }
                    ],
                    "LabelPrepPreference": "SELLER_LABEL",
                    "ShipToCountryCode": "US"
            }';
        $date = urlencode(gmdate("Ymd\THis\Z"));

        $para = 'X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIDEXAMPLE%2F20150830%2Fus-east-1%2Fiam%2Faws4_request&X-Amz-Date='.$date.'&X-Amz-SignedHeaders=content-type%3Bhost%3Bx-amz-date';
        $url_string = "POST\nsellingpartnerapi-na.amazon.com\n/fba/inbound/v0/plans\n".$para;

        $signature = urlencode(base64_encode(hash_hmac("sha256", $url_string, "q4uEv7WGl7OsCIhffrJKuX4y4QnvEkmjEfQS5hMq", TRUE)));


        //$signature = urlencode(base64_encode(hash_hmac("sha256", $url_string, "q4uEv7WGl7OsCIhffrJKuX4y4QnvEkmjEfQS5hMq", TRUE)));

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://sellingpartnerapi-na.amazon.com/fba/inbound/v0/plans',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'
            {
                "ShipFromAddress": {
                        "Name": "sunt in",
                        "AddressLine1": "9637 Pierrront ST",
                        "AddressLine2": "enim sint in",
                        "DistrictOrCounty": "United States",
                        "City": "Richmond",
                        "StateOrProvinceCode": "VA",
                        "CountryCode": "US",
                        "PostalCode": "20015"
                    },
                "InboundShipmentPlanRequestItems": [
                        {
                            "ASIN": "B099VMT8VZ",
                            "Condition": "NewOpenBox",
                            "Quantity": 120,
                            "SellerSKU": "dolore pariatur quis",
                            "QuantityInCase": 20
                        }
                    ],
                    "LabelPrepPreference": "SELLER_LABEL",
                    "ShipToCountryCode": "US"
            }',
          CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'user-agent: cs-php-sp-api-client/2.1',
                'x-amz-access-token: Atza|IwEBIPlyTatImtb8LmqOE9BJQGTPFCjbmt9Ps_i8kb5DrvCZpa6nhzcbcBO36WsenTr-q3pEhjmxTxBfpCESp_FS7-KRUHvovm3MjV1PsCFMwAQY_Ckso7-Uvun4hcMJl1TLe0HA6KYsJa57QW8pvevT_5Izy7w0JJRKHUfoNVK6kJjOVMAvfO0JZeNrUASmMdbHB2kEDmhJLuGrxb7WYwgI1DCQq7W6tC-Iu4Vt4YKn6qbSRIH-h8vP2iwbJLacbtsn-eLtkcPFUZOjclBnkkKUoL_FdTtBjSkS7a3hQ2XC96uFsqBRKu0s6pcVbANsqrQzxMWlutrC1c0MPqlXGQIRJDdO',
                //'X-Amz-Content-Sha256: beaead3198f7da1e70d03ab969765e0821b24fc913697e929e726aeaebf0eba3',
                'X-Amz-Date: 20210907T101907Z',
                'x-amz-security-token: FwoGZXIvYXdzEFQaDEHowd3F/6BTMOaPICK1ATAoWcyahrvXzO5DbLvRw6bM7iUF7YXf10h5ejj0QS3E+bCLWHU2HebzPmYts6PwuSphgic4zhHj1CXI0JcuBVKsan3/YClDMAaNBzMubTcSOMBS/4PguDAO7GTvu0NQu3mTMZY1ap1Hlsgcbm9566stquFSpCUjjNbrZmnAWpe7GfGEZ8IzgFYFz5aVFg/1ArWf/kSuTtPa0lG/SmsSDm9D6Tqn/1bwusIdFjM725soAAfxwokom/nciQYyLd5qECKQsbJjFwuHy20f/+CKGwMOBmFXMW9CV87Ns4QUD6+XnRKjHnyZIt7E2Q==',
                'AWS4-HMAC-SHA256 Credential=ASIAQO6HAERJA54WDQAO/20210907/us-east-1/execute-api/aws4_request, SignedHeaders=host;user-agent;x-amz-access-token;x-amz-date;x-amz-security-token, Signature=0bf1e2443dab678eafeb85b821430622d0ed36de9ac55aa12117090b88d619d9'
              ),
        ));

         

        $response = curl_exec($curl);

         

        curl_close($curl);
        echo $response;
    }

    function createSignature($secretKey) { // $secretKey is the AWS secret key from IAM user
        //$stringToSign = $this->createStringToSign(); // Derived according to docs: https://docs.aws.amazon.com/general/latest/gr/sigv4-create-string-to-sign.html
        $algorithm = 'sha256';
        $kSecret = "AWS4".$secretKey;
        $date = $this->credentials->date; // Date derived per amazon documentation eg. 20201020 for 20 Oct 2020
        $region = $this->credentials->region; // Region for request eg. us-east-1
        $service = $this->credentials->service; // Service eg. execute-api
        $terminationString = $this->credentials->terminationString; // Signature termination string eg. aws4_request
        $kDate = hash_hmac($algorithm, $date, $kSecret, true);
        $kRegion = hash_hmac($algorithm, $region, $kDate, true);
        $kService = hash_hmac($algorithm, $service, $kRegion, true);
        $kSigning = hash_hmac($algorithm, $terminationString, $kService, true);

        $signature = hash_hmac($algorithm, $stringToSign, $kSigning); // Without fourth parameter passed as true, returns lowercase hexits as called for by docs
        return trim($signature); // Trimming maybe not necessary here but can't hurt.
    }
}
