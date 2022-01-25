<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;

use DB;
use App\User;
use Auth;
use Hash;
use App\WalmartScrap;
use Storage;

class WalmartScrapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array('pageTitle' => "Scrap Product");
        return view('walmart.index')->with($data);
    }

    public function walmartProductLog(Request $request){

        $filteroption = !empty($request->input('filteroption'))?$request->input('filteroption'):'';

        if(!empty($filteroption) && $filteroption == 'profitable_on_amazon'){

          $products = WalmartScrap::select('id','productid','walmartid','name','price','amazonPrice','images','model','brand','upc','shortdesc','description','delivery','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','profit','roi')->where('uploadedOnMWS', 0)->where('created_by',auth()->user()->id)->whereRaw('amazonPrice > price')->orderby('id','DESC')->get();

        }elseif (!empty($filteroption) && $filteroption == 'profitable_on_walmart') {

            $products = WalmartScrap::select('id','productid','walmartid','name','price','amazonPrice','images','model','brand','upc','shortdesc','description','delivery','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','profit','roi')->where('uploadedOnMWS', 0)->where('created_by',auth()->user()->id)->whereRaw('amazonPrice < price')->orderby('id','DESC')->get();
        }elseif (!empty($filteroption) && $filteroption == 'non_profitable') {

            $products = WalmartScrap::select('id','productid','walmartid','name','price','amazonPrice','images','model','brand','upc','shortdesc','description','delivery','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','profit','roi')->where('uploadedOnMWS', 0)->where('created_by',auth()->user()->id)->whereRaw('amazonPrice = price')->orderby('id','DESC')->get();

        }elseif (!empty($filteroption) && $filteroption == 'profit_lessthan_50') {

            $products = WalmartScrap::select('id','productid','walmartid','name','price','amazonPrice','images','model','brand','upc','shortdesc','description','delivery','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','profit','roi')->where('uploadedOnMWS', 0)->where('created_by',auth()->user()->id)->where('profit', '<', '50')->orderby('id','DESC')->get();

        }elseif (!empty($filteroption) && $filteroption == 'profit_50to100') {

            $products = WalmartScrap::select('id','productid','walmartid','name','price','amazonPrice','images','model','brand','upc','shortdesc','description','delivery','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','profit','roi')->where('uploadedOnMWS', 0)->where('created_by',auth()->user()->id)->where('profit', '>', '50')->whereRaw('profit < 100')->orderby('id','DESC')->get();

        }elseif (!empty($filteroption) && $filteroption == 'profit_greaterthan_100') {

            $products = WalmartScrap::select('id','productid','walmartid','name','price','amazonPrice','images','model','brand','upc','shortdesc','description','delivery','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','profit','roi')->where('uploadedOnMWS', 0)->where('created_by',auth()->user()->id)->where('profit', '>', '100')->orderby('id','DESC')->get();

        } else {

          $products = WalmartScrap::select('id','productid','walmartid','name','price','amazonPrice','images','model','brand','upc','shortdesc','description','delivery','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','profit','roi')->where('uploadedOnMWS', 0)->where('created_by',auth()->user()->id)->orderby('id','DESC')->get();
        }

        $data = array('pageTitle' => "Product Listing");
        $data['filteroption'] = $filteroption;
        $data['walmartProducts'] = $products;

        return view('walmart.product_log')->with($data);
    }

    public function scrapCategory(Request $request){

    	$this->validate($request, [
            'categoryurl' => 'required_without:producturl'
        ]);

        $url = strtok($request->input('categoryurl'), '?');
        $producturl = strtok($request->input('producturl'), '?');

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if(!empty($producturl)) {

            $chod = curl_init();
            curl_setopt_array($chod, array(
              CURLOPT_URL => $producturl,
              // CURLOPT_URL => "https://www.walmart.com/ip/VIZIO-50-Class-4K-UHD-LED-Quantum-Smart-TV-HDR-M6x-Series-M506x-H9/910109519",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_FOLLOWLOCATION => 1,
              CURLOPT_TIMEOUT => 300,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                'X-Apple-Tz: 0',
                'X-Apple-Store-Front: 143444,12',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Encoding: gzip, deflate',
                'Accept-Language: en-US,en;q=0.5',
                'Cache-Control: no-cache',
                'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
                'Host: www.walmart.com',
                "cache-control: no-cache",
                //"user-agent: Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0"
                "user-agent: Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion"
                //"user-agent: Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/geckotrail Firefox/31.0"
              ),
            ));
            $productresponse = curl_exec($chod);
            $proerr = curl_error($chod);
            curl_close($chod); 
            
            if ($proerr) {
                //echo "cURL Error #:" . $proerr; exit;
            }else{
                $domP = HtmlDomParser::str_get_html($productresponse);

                $products_array = array();
                $title = $price = $currency = $brand = $description = $specifications = $model = $productid = $upc = $walmartid = $shortdesc = $delivery = '';
                $images = $path = array();
                if($domP->find('script.tb-optimized'))
                {
                    $projson = $domP->find('script.tb-optimized')[0]->innertext();
                    $projson = json_decode($projson,true);
                    /*echo '<prE>';
                    print_r($projson);
                    exit();*/
                    // echo $response;

                    $images = array_column($projson['item']['product']['buyBox']['products'][0]['images'],"url");
                    $path = array_column($projson['item']['product']['buyBox']['products'][0]['path'],"name");
                    $title = $projson['item']['product']['buyBox']['products'][0]['productName'];
                    $price = $projson['item']['product']['buyBox']['products'][0]['priceMap']['price'];
                    $specifications = $projson['item']['product']['buyBox']['products'][0]['idmlSections']['specifications'];
                    $model = !empty($projson['item']['product']['buyBox']['products'][0]['model'])?$projson['item']['product']['buyBox']['products'][0]['model']:'';
                    $brand = $projson['item']['product']['buyBox']['products'][0]['brandName'];
                    $productType = $projson['item']['product']['buyBox']['products'][0]['productType'];
                    $productid = $projson['item']['product']['buyBox']['products'][0]['productId'];
                    $upc = $projson['item']['product']['buyBox']['products'][0]['upc'];
                    $walmartid = !empty($projson['item']['product']['buyBox']['products'][0]['walmartItemNumber'])?$projson['item']['product']['buyBox']['products'][0]['walmartItemNumber']:0;
                    $shortdesc = $projson['item']['product']['buyBox']['products'][0]['shortDescription'];

                    if(!empty($projson['item']['product']['buyBox']['products'][0]['shippingOptions'])){
                      $delivery = !empty($projson['item']['product']['buyBox']['products'][0]['shippingOptions'][0]['fulfillmentDateRange']['exactDeliveryDate'])?date("Y-m-d",($projson['item']['product']['buyBox']['products'][0]['shippingOptions'][0]['fulfillmentDateRange']['exactDeliveryDate']/1000)+86400):NULL;
                    } elseif(!empty($projson['item']['product']['buyBox']['products'][0]['shippingOptions'])){
                      $delivery = date("Y-m-d",($projson['item']['product']['buyBox']['products'][0]['shippingOptions'][0]['fulfillmentDateRange']['latestDeliveryDate']/1000)+86400);
                    } else {
                      $delivery = NULL;
                    }

                    $description = $projson['item']['product']['buyBox']['products'][0]['detailedDescription'];
                    // $delivery = $projson['item']['product']['buyBox']['products'][0]['upsellFulfillmentOption']['displayArrivalDate'];

                    $product_array = array('productid'      =>  $productid,
                       'walmartid'      =>  $walmartid,
                       'name'           =>  $title,
                       'price'          =>  $price,
                       'images'         =>  implode(',', $images),
                       'path'           =>  implode(',', $path),
                       'model'          =>  $model,
                       'brand'          =>  $brand,
                       'productType'    =>  $productType,
                       'upc'            =>  $upc,
                       'specifications' =>  utf8_encode(json_encode($specifications)),
                       'shortdesc'      =>  htmlentities(utf8_encode($shortdesc)),
                       'description'    =>  utf8_encode($description),
                       'delivery'       =>  $delivery,
                       'add_date'       => date('Y-m-d H:i:s'),
                       'created_by'     => auth()->user()->id
                    );

                    if(!empty($images[0])){
                        $url = $images[0];
                        $contents = file_get_contents($url);
                        $imgname = substr($url, strrpos($url, '/') + 1);
                        $fileName = 'public/walmartImg/'.$imgname;
                        
                        Storage::put($fileName, $contents);

                        $product_array['images'] = $imgname;
                    }
                    
                    $id = DB::table('tblwalmart_product')->where('productid', $productid)->value('id');

                    if(isset($id) && !empty($id)){
                        
                    } else {

                        $amazonProductDetail = $this->getAmazonPrice($product_array['name'],$product_array['price']);


                        /*if ((strpos($product_array['brand'], $amazonProductDetail['amazonBrand']) !== false || strpos($amazonProductDetail['amazonBrand'], $product_array['brand']) !== false) && $product_array['productType'] == $amazonProductDetail['amazProductType']) {*/

                          $product_array['amazonPrice'] = $amazonProductDetail['amount'];
                          $product_array['totalFees'] = $amazonProductDetail['totalFees'];
                          $product_array['referralFee'] = $amazonProductDetail['referralFee'];
                          $product_array['closingFee'] = $amazonProductDetail['closingFee'];
                          $product_array['perItemFee'] = $amazonProductDetail['perItemFee'];
                          $product_array['fbaFees'] = $amazonProductDetail['fbaFees'];
                          $product_array['profit'] = $amazonProductDetail['profit'];
                          $product_array['roi'] = $amazonProductDetail['roi'];

                        //echo "<pre>";print_r($product_array);exit;

                        /*} else {
                          $product_array['amazonPrice'] = 0;
                          $product_array['totalFees'] = 0;
                          $product_array['referralFee'] = 0;
                          $product_array['closingFee'] = 0;
                          $product_array['perItemFee'] = 0;
                          $product_array['fbaFees'] = 0;
                          $product_array['profit'] = 0;
                          $product_array['roi'] = 0;
                        }*/

                        $result = WalmartScrap::create($product_array);

                        if($result){
                            array_push($products_array, $product_array);
                        }
                    }
                }
                return view('walmart.product_list')->with('walmartProducts',$products_array);
            }
        } else {

          $ch = curl_init();
          curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            // CURLOPT_URL => "https://www.walmart.com/ip/VIZIO-50-Class-4K-UHD-LED-Quantum-Smart-TV-HDR-M6x-Series-M506x-H9/910109519",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
              'X-Apple-Tz: 0',
              'X-Apple-Store-Front: 143444,12',
              'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
              'Accept-Encoding: gzip, deflate',
              'Accept-Language: en-US,en;q=0.5',
              'Cache-Control: no-cache',
              'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
              'Host: www.walmart.com',
              "cache-control: no-cache",
              //"user-agent: Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0"
              "user-agent: Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/geckotrail Firefox/31.0"
            ),
          ));
          $response = curl_exec($ch);
          $err = curl_error($ch);
          curl_close($ch);        
          if ($err) {
            echo "cURL Error #:" . $err; exit;
          }else{
              $dom = HtmlDomParser::str_get_html($response);
              if($dom->find('script#searchContent'))
              {
                  $json = $dom->find('script#searchContent')[0]->innertext();
                  $json = json_decode($json,true);
                  $products_array = array();
                  $i = 1;
                  foreach ($json['searchContent']['preso']['items'] as $products) {
                      $productUrl = 'https://www.walmart.com'.$products['productPageUrl'];
                      if($i < 3){
                      $chod = curl_init();
                      curl_setopt_array($chod, array(
                        CURLOPT_URL => $productUrl,
                        // CURLOPT_URL => "https://www.walmart.com/ip/VIZIO-50-Class-4K-UHD-LED-Quantum-Smart-TV-HDR-M6x-Series-M506x-H9/910109519",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_FOLLOWLOCATION => 1,
                        CURLOPT_TIMEOUT => 300,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                          'X-Apple-Tz: 0',
                          'X-Apple-Store-Front: 143444,12',
                          'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                          'Accept-Encoding: gzip, deflate',
                          'Accept-Language: en-US,en;q=0.5',
                          'Cache-Control: no-cache',
                          'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
                          'Host: www.walmart.com',
                          "cache-control: no-cache",
                          //"user-agent: Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0"
                          "user-agent: Mozilla/5.0 (platform; rv:geckoversion) Gecko/geckotrail Firefox/firefoxversion"
                          //"user-agent: Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/geckotrail Firefox/31.0"
                        ),
                      ));
                      $productresponse = curl_exec($chod);
                      $proerr = curl_error($chod);
                      curl_close($chod); 
                      //echo $productresponse;exit;
                      if ($proerr) {
                          //echo "cURL Error #:" . $proerr; exit;
                      }else{
                          $domP = HtmlDomParser::str_get_html($productresponse);

                          $title = $price = $currency = $brand = $description = $specifications = $model = $productid = $upc = $walmartid = $shortdesc = $delivery = '';
                          $images = $path = array();
                          if($domP->find('script.tb-optimized'))
                          {
                              $projson = $domP->find('script.tb-optimized')[0]->innertext();
                              $projson = json_decode($projson,true);
                              /*echo '<prE>';
                              print_r($projson);
                              exit();*/
                              // echo $response;

                              $images = array_column($projson['item']['product']['buyBox']['products'][0]['images'],"url");
                              $path = array_column($projson['item']['product']['buyBox']['products'][0]['path'],"name");
                              $title = $projson['item']['product']['buyBox']['products'][0]['productName'];
                              $price = $projson['item']['product']['buyBox']['products'][0]['priceMap']['price'];
                              $specifications = $projson['item']['product']['buyBox']['products'][0]['idmlSections']['specifications'];
                              $model = !empty($projson['item']['product']['buyBox']['products'][0]['model'])?$projson['item']['product']['buyBox']['products'][0]['model']:'';
                              $brand = $projson['item']['product']['buyBox']['products'][0]['brandName'];
                              $productid = $projson['item']['product']['buyBox']['products'][0]['productId'];
                              $upc = $projson['item']['product']['buyBox']['products'][0]['upc'];
                              $walmartid = !empty($projson['item']['product']['buyBox']['products'][0]['walmartItemNumber'])?$projson['item']['product']['buyBox']['products'][0]['walmartItemNumber']:0;
                              $shortdesc = $projson['item']['product']['buyBox']['products'][0]['shortDescription'];

                              $delivery = !empty($projson['item']['product']['buyBox']['products'][0]['shippingOptions'][0]['fulfillmentDateRange']['exactDeliveryDate'])?date("Y-m-d",($projson['item']['product']['buyBox']['products'][0]['shippingOptions'][0]['fulfillmentDateRange']['exactDeliveryDate']/1000)+86400):date("Y-m-d",($projson['item']['product']['buyBox']['products'][0]['shippingOptions'][0]['fulfillmentDateRange']['latestDeliveryDate']/1000)+86400);
                              $description = $projson['item']['product']['buyBox']['products'][0]['detailedDescription'];
                              // $delivery = $projson['item']['product']['buyBox']['products'][0]['upsellFulfillmentOption']['displayArrivalDate'];

                              $product_array = array('productid'      =>  $productid,
                                 'walmartid'      =>  $walmartid,
                                 'name'           =>  $title,
                                 'price'          =>  $price,
                                 'images'         =>  implode(',', $images),
                                 'path'           =>  implode(',', $path),
                                 'model'          =>  $model,
                                 'brand'          =>  $brand,
                                 'upc'            =>  $upc,
                                 'specifications' =>  utf8_encode(json_encode($specifications)),
                                 'shortdesc'      =>  htmlentities(utf8_encode($shortdesc)),
                                 'description'    =>  utf8_encode($description),
                                 'delivery'       =>  $delivery,
                                 'add_date'       => date('Y-m-d H:i:s'),
                                 'created_by'     => auth()->user()->id
                              );

                              if(!empty($images[0])){
                                  $url = $images[0];
                                  $contents = file_get_contents($url);
                                  $imgname = substr($url, strrpos($url, '/') + 1);
                                  $fileName = 'public/walmartImg/'.$imgname;
                                  
                                  Storage::put($fileName, $contents);

                                  $product_array['images'] = $imgname;
                              }
                              
                              $id = DB::table('tblwalmart_product')->where('productid', $productid)->value('id');

                              if(isset($id) && !empty($id)){
                                  
                              } else {
                                  $result = WalmartScrap::create($product_array);

                                  if($result){
                                      array_push($products_array, $product_array);
                                  }
                              }
                          }
                      }
                      }
                      $i++;
                      sleep(3);
                  }

                  return view('walmart.product_list')->with('walmartProducts',$products_array);
              }
          }
        }
    }

    public function getAmazonPrice($product='',$cost){
      if(!empty($product)){

        $query = rawurlencode($product);
        //$query = rawurlencode('VIZIO 32" Class HD Smart TV D-Series D32h-G9');

        $parameter = "AWSAccessKeyId=AKIAJ5LP6U6FDV6X3MDA&Action=ListMatchingProducts&MarketplaceId=ATVPDKIKX0DER&Query=".$query."&SellerId=AXZU3XORX7Q7L&SignatureMethod=HmacSHA256&SignatureVersion=2&Timestamp=".urlencode(gmdate("Y-m-d\TH:i:s\Z"))."&Version=2011-10-01";

        $url_string = "POST\nmws.amazonservices.com\n/Products/2011-10-01\n".$parameter;
        $signature = hash_hmac("sha256", $url_string, "q4uEv7WGl7OsCIhffrJKuX4y4QnvEkmjEfQS5hMq", TRUE);
        $parameter = $parameter."&Signature=".urlencode(base64_encode($signature));


        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://mws.amazonservices.com/Products/2011-10-01",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $parameter,
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: application/x-www-form-urlencoded"
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

          $attaributeArray = json_decode( json_encode($xml->ListMatchingProductsResult->Products->Product->AttributeSets) , 1);
          $attributeData = array();
          if(!empty($attaributeArray)){
            $attributeData['amazonBrand'] = $attaributeArray['ItemAttributes']['Brand'];
            $attributeData['amazProductType'] = $attaributeArray['ItemAttributes']['ProductTypeName'];
          }

          $asinData = !empty($xml->ListMatchingProductsResult->Products->Product->Identifiers->MarketplaceASIN)?$xml->ListMatchingProductsResult->Products->Product->Identifiers->MarketplaceASIN:'';
          $result = json_decode( json_encode($asinData) , 1);
          $asinId = $result['ASIN'];

          if(!empty($asinId)){

            $priceparameter = "ASINList.ASIN.1=".$asinId."&AWSAccessKeyId=AKIAJ5LP6U6FDV6X3MDA&Action=GetCompetitivePricingForASIN&MarketplaceId=ATVPDKIKX0DER&SellerId=AXZU3XORX7Q7L&SignatureMethod=HmacSHA256&SignatureVersion=2&Timestamp=".urlencode(gmdate("Y-m-d\TH:i:s\Z"))."&Version=2011-10-01";

            $url_string2 = "POST\nmws.amazonservices.com\n/Products/2011-10-01\n".$priceparameter;
            $signature2 = hash_hmac("sha256", $url_string2, "q4uEv7WGl7OsCIhffrJKuX4y4QnvEkmjEfQS5hMq", TRUE);
            $priceparameter = $priceparameter."&Signature=".urlencode(base64_encode($signature2));

            $ch = curl_init();

            curl_setopt_array($ch, array(
              CURLOPT_URL => "https://mws.amazonservices.com/Products/2011-10-01",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => $priceparameter,
              CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
              ),
            ));

            $priceresponse = curl_exec($ch);
            $err = curl_error($ch);

            curl_close($ch);

            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              $xmlres = simplexml_load_string($priceresponse);

              $productobject = $xmlres->GetCompetitivePricingForASINResult->Product->CompetitivePricing->CompetitivePrices->CompetitivePrice->Price->ListingPrice;
              $productPrice = json_decode( json_encode($productobject) , 1);

              $attributeData['amount'] = $productPrice['Amount'];
              $attributeData['currencyCode'] = $productPrice['CurrencyCode'];

              /*-------------Price Calculation -----------------*/

              if (!empty($cost)){

                $calparameter ="AWSAccessKeyId=AKIAJ5LP6U6FDV6X3MDA&Action=GetMyFeesEstimate&FeesEstimateRequestList.FeesEstimateRequest.1.IdType=ASIN&FeesEstimateRequestList.FeesEstimateRequest.1.IdValue=".$asinId."&FeesEstimateRequestList.FeesEstimateRequest.1.Identifier=request1&FeesEstimateRequestList.FeesEstimateRequest.1.IsAmazonFulfilled=true&FeesEstimateRequestList.FeesEstimateRequest.1.MarketplaceId=ATVPDKIKX0DER&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.ListingPrice.Amount=".$attributeData["amount"]."&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.ListingPrice.CurrencyCode=".$attributeData["currencyCode"]."&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Points.PointsMonetaryValue.Amount=0&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Points.PointsMonetaryValue.CurrencyCode=".$attributeData["currencyCode"]."&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Points.PointsNumber=0&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Shipping.Amount=0&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Shipping.CurrencyCode=".$attributeData["currencyCode"]."&SellerId=AXZU3XORX7Q7L&SignatureMethod=HmacSHA256&SignatureVersion=2&Timestamp=".urlencode(gmdate("Y-m-d\TH:i:s\Z"))."&Version=2011-10-01";

                $urlfeesestimate = "POST\nmws.amazonservices.com\n/Products/2011-10-01\n".$calparameter;
                $signature3 = hash_hmac("sha256", $urlfeesestimate, "q4uEv7WGl7OsCIhffrJKuX4y4QnvEkmjEfQS5hMq", TRUE);
                $calparameter = $calparameter."&Signature=".urlencode(base64_encode($signature3));

                $chest = curl_init();

                curl_setopt_array($chest, array(
                  CURLOPT_URL => "https://mws.amazonservices.com/Products/2011-10-01",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => $calparameter,
                  CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/x-www-form-urlencoded"
                  ),
                ));

                $estimateresponse = curl_exec($chest);
                $estimateerr = curl_error($chest);

                curl_close($chest);

                if ($estimateerr) {
                  echo "cURL Error #:" . $estimateerr;
                } else {
                    $xmlresponse = simplexml_load_string($estimateresponse);
                    $productobjectDetail = $xmlresponse->GetMyFeesEstimateResult->FeesEstimateResultList->FeesEstimateResult->FeesEstimate;

                    $productPricesection = json_decode( json_encode($productobjectDetail) , 1);

                    $attributeData['totalFees'] = $productPricesection['TotalFeesEstimate']['Amount'];
                          
                    foreach ($productPricesection['FeeDetailList']['FeeDetail'] as $feedetail) {
                      if($feedetail['FeeType'] == 'ReferralFee'){
                        $attributeData['referralFee'] = $feedetail['FeeAmount']['Amount'];
                      }
                      if($feedetail['FeeType'] == 'VariableClosingFee'){
                        $attributeData['closingFee'] = $feedetail['FeeAmount']['Amount'];
                      }
                      if($feedetail['FeeType'] == 'PerItemFee'){
                        $attributeData['perItemFee'] = $feedetail['FeeAmount']['Amount'];
                      }
                      if($feedetail['FeeType'] == 'FBAFees'){
                        $attributeData['fbaFees'] = $feedetail['FeeAmount']['Amount'];
                      }
                    }
                    $profit = 0;
                    if(!empty($cost)){
                      $profit = $attributeData['amount'] - $attributeData['totalFees'] - $cost;
                      $attributeData['profit'] = $profit;
                      $attributeData['roi'] = ($profit *  100)/$cost;
                    }
                }
              }
            }
          }
          return $attributeData;
        }
      }
    }

    public function filter(Request $request){

        if(!empty($request->input('filter'))){

            $filter = array();
            foreach ($request->input('filter') as $parameter) {
                array_pop($parameter);

                if($parameter[0] == 'price' || $parameter[0] == 'amazonPrice' || $parameter[0] == 'profit' || $parameter[0] == 'roi' || $parameter[0] == 'totalFees' || $parameter[0] == 'referralFee' || $parameter[0] == 'closingFee' || $parameter[0] == 'perItemFee' || $parameter[0] == 'fbaFees' || $parameter[0] == 'estimatedsales' || $parameter[0] == 'shippingcost'){
                    $parameter[2] = (int)$parameter[2];
                }

                if($parameter[1] == '∈'){
                    $parameter[1] = 'LIKE';
                    $parameter[2] = '%'.$parameter[2].'%';
                }

                if($parameter[1] == '!~'){
                    $parameter[1] = 'not like';
                    $parameter[2] = '%'.$parameter[2].'%';
                }
                array_push($filter, $parameter);
            }

            /*$products = DB::table('tblproduct_Walmart_To_Amazon')->select('id','asin','upc','sku','title','brand','price','color','cost','productType','currencyCode','packageHeight','packageLength','packageWidth','packageWeight','packagequantity','size','submissionId','processingStatus','currentStatus')->where($filter)->orderby('id','DESC')->get();*/

            $products = WalmartScrap::select('id','productid','walmartid','name','price','amazonPrice','images','model','brand','productType','upc','shortdesc','description','delivery','delivery_days','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','profit','roi')->where($filter)->where('uploadedOnMWS', 0)->where('created_by',auth()->user()->id)->orderby('id','DESC')->get();

            /*for ($i=0; $i < count($products); $i++) { 
                if(Storage::has('public/walmartImg/'.$products[$i]['images'])){
                    $products[$i]['images'] = URL::asset('storage/walmartImg/'.$products[$i]['images']);
                } else { 
                    $products[$i]['images'] = ''; 
                }
            }*/

            $return_arr = !empty($products)?$products:array();
            echo json_encode($return_arr);
            exit;
        }
    }
}
