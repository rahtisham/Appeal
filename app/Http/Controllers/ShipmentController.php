<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipment;
use App\Http\Controllers\Controller;
use \ClouSale\AmazonSellingPartnerAPI AS AmazonSellingPartnerAPI;

class ShipmentController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function createShipment(){

        $controller = new Controller();
        $config = $controller->getConfig();

        $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\ShippingApi($config);

        echo "<pre>";print_r($apiInstance);exit();

        /*$body_array = array('client_reference_id' => '',
                        'ship_to' => array('name' => '',
                                        'address_line1' => '',
                                        'address_line2' => '',
                                        'address_line3' => '',
                                        'state_or_region' => '',
                                        'city' => '',
                                        'country_code' => '',
                                        'postal_code'=> '',
                                        'email' => '',
                                        'copy_emails' => '',
                                        'phone_number' => ''
                                    ),
                        'ship_from' => array('name' => '',
                                        'address_line1' => '',
                                        'address_line2' => '',
                                        'address_line3' => '',
                                        'state_or_region' => '',
                                        'city' => '',
                                        'country_code' => '',
                                        'postal_code'=> '',
                                        'email' => '',
                                        'copy_emails' => '',
                                        'phone_number' => ''
                                    ),
                        'containers' => ''
                    );*/


                        $body_data= [
                            'client_reference_id' => '',
                            'ship_to' => [
                                            'name' => 'suraj',
                                            'address_line1' => 'krishna appartmet',
                                            'address_line2' => 'odhav road',
                                            'address_line3' => '382415',
                                            'state_or_region' => 'odhav',
                                            'city' => 'ahmedabad',
                                            'country_code' => '91',
                                            'postal_code' => '382415',
                                            'email' => 'suraj.patel@objectcodes.com',
                                            'copy_emails' => 'viral.sir@objectcodes.com',
                                            'phone_number' => '7600007440'    
                                        ],
                            'ship_from' => [
                                            'name' => 'ajay',
                                            'address_line1' => 'lilamani corporate heights',
                                            'address_line2' => 'vastral road',
                                            'address_line3' => '382418',
                                            'state_or_region' => 'vastral',
                                            'city' => 'ahmedabad',
                                            'country_code' => '91',
                                            'postal_code' => '382418',
                                            'email' => 'ajy.nagar@gmail.com',
                                            'copy_emails' => 'vijay.nagar@gmail.com',
                                            'phone_number' => '9427620998'    
                                        ],
                            'containers' => [
                                            'dimensions' => [
                                                                'length' => 10,
                                                                'width' => 20,
                                                                'height' => 30,
                                                                'unit' => 'CM' 
                                                            ],
                                            'weight' => [
                                                                'unit' => 'kg',
                                                                'value' => 25,
                                                            ]  
                                        ]
                    ];

                    

        $body = new \ClouSale\AmazonSellingPartnerAPI\Models\Shipping\CreateShipmentRequest($body_data);

        try {

            $result = $apiInstance->createShipment($body);
            print_r($result);

        } catch (Exception $e) {
            echo 'Exception when calling ShippingApi->createShipment: ', $e->getMessage(), PHP_EOL;
        }

    }
}
