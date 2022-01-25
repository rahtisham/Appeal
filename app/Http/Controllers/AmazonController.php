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

class AmazonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fullfilmentRequest(){
        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);

        $parameter = array("reportOptions"=>array(), "reportType" => "GET_AMAZON_FULFILLED_SHIPMENTS_DATA_GENERAL", "dataStartTime"=>"2020-09-22T08:41:00.794Z", "dataEndTime" => "2021-11-09T11:30:10.802Z", "marketplaceIds"=> $amazonSetting->marketplace_id);

        $requestresponse = $amazon->createReport($parameter);

        echo $requestresponse;exit;
    }

    public function getfullfilmentreport(){
        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);

        $fullfillId = "";

        $requestresponse = $amazon->getReport($fullfillId);

        echo $requestresponse;exit;
    }
    

    public function getfullfilmentreportdocument(){
        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);

        $reportDocumentId = "";

        $requestresponse = $amazon->getReportDocument($reportDocumentId);

        echo $requestresponse;exit;
    }

    public function chargebackReportRequest(){
        $amazonSetting = AmazonSettings::where('user_id',auth()->user()->id)->first();

        $amazon = new Amazon($amazonSetting->role_arn, $amazonSetting->access_key, $amazonSetting->secret_key, $amazonSetting->client_id, $amazonSetting->client_secret, $amazonSetting->refresh_token);

        $parameter = array("reportOptions"=>array(), "reportType" => "GET_FLAT_FILE_ALL_ORDERS_DATA_BY_LAST_UPDATE_GENERAL", "dataStartTime"=>"2020-09-22T08:41:00.794Z", "dataEndTime" => "2021-11-09T11:30:10.802Z", "marketplaceIds"=> $amazonSetting->marketplace_id);

        $requestresponse = $amazon->createReport($parameter);

        echo $requestresponse;exit;
    }
}
