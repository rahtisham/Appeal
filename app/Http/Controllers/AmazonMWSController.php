<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;

use Illuminate\Support\Facades\Session;
use DB;
use App\User;
use Auth;
use Hash;
use App\AmazonMWS;
use App\WalmartScrap;
use Storage;

class AmazonMWSController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {
    	$csvId = $request->input('fileID');
    	
    	if(isset($csvId) && !empty($csvId)){
    		$products = AmazonMWS::select('id','asin','title','brand','price','productType','currencyCode','packageHeight','packageLength','size','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','fixedadditionalcost','percentadditionalcost','profit','roi')->where('csv_id',$csvId)->orderby('id','DESC')->get();
    	} else {

    		$products = AmazonMWS::select('id','asin','title','brand','price','productType','currencyCode','packageHeight','packageLength','size','totalFees','referralFee','closingFee','perItemFee','fbaFees','estimatedsales','shippingcost','fixedadditionalcost','percentadditionalcost','profit','roi')->orderby('id','DESC')->get();
    	}

    	$data = array('pageTitle' => "Exported Products");
    	$data['amazonProducts'] = $products;

        return view('amazon.exported_list')->with($data);
    }

    function importedList()
    {
    	$data = array('pageTitle' => "Exported List");

       	$data['imported_csv'] = DB::select("SELECT * FROM `mwsImportExport` ORDER BY id DESC");
        return view('amazon.imported_csv_list')->with($data);
    }

	function fileImportExport()
    {
    	$data = array('pageTitle' => "Import Export Product");
       	return view('amazon.file-import')->with($data);
    }

    function product_list(Request $request)
    {
    	$status = !empty($request->input('mwsstatus'))?$request->input('mwsstatus'):'';

    	if(!empty($status)){
			$products = DB::table('tblproduct_Walmart_To_Amazon')->select('id','asin','upc','sku','title','brand','price','color','cost','productType','currencyCode','packageHeight','packageLength','size','submissionId','processingStatus','currentStatus')->where('processingStatus',$status)->orderby('id','DESC')->get();    		
    	} else {

			$products = DB::table('tblproduct_Walmart_To_Amazon')->select('id','asin','upc','sku','title','brand','price','color','cost','productType','currencyCode','packageHeight','packageLength','size','submissionId','processingStatus','currentStatus')->orderby('id','DESC')->get();
		}

    	$data = array('pageTitle' => "Amazon Listed Products");
    	$data['status'] = $status;
    	$data['amazonProducts'] = $products;

        return view('amazon.list')->with($data);
    }

    function fileExport()
    {
    	if(isset($_POST["import"])){
    		$filename=$_FILES["csvfile"]["tmp_name"];

		    if($_FILES["csvfile"]["size"] > 0)
		    {
		        $file = fopen($filename, "r");
		        $header = fgetcsv($file);

		        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		        {
		        	$fileData = array_change_key_case(array_combine($header, $getData),CASE_LOWER);

		        	$result = AmazonMWS::create($fileData);
		        }
		    }
		    return redirect()->route('amazonExportedList');
    	}
       	elseif(isset($_POST["export"])){
    
	    	$csvName=$_FILES["csvfile"]["name"];
	    	$filename=$_FILES["csvfile"]["tmp_name"];

		    if($_FILES["csvfile"]["size"] > 0)
		    {
		        $file = fopen($filename, "r");
		        $products_array = array();
		        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
		        {
		        	if(!empty($getData[0]) && !empty($getData[1])){
			        	if($getData[0] == 'asin' || $getData[1] == 'cost'){
			        		continue;
			        	}
			        	$asin = $getData[0];
			        	$cost = $getData[1];

				        $parameter = "ASINList.ASIN.1=".$asin."&AWSAccessKeyId=AKIAJ5LP6U6FDV6X3MDA&Action=GetMatchingProduct&MarketplaceId=ATVPDKIKX0DER&SellerId=AXZU3XORX7Q7L&SignatureMethod=HmacSHA256&SignatureVersion=2&Timestamp=".urlencode(gmdate("Y-m-d\TH:i:s\Z"))."&Version=2011-10-01";

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

				          	if(isset($xml->Error) && !empty($xml->Error)){
				          		continue;
				          	}else {

					          $attaributeArray = json_decode( json_encode($xml->GetMatchingProductResult->Product->AttributeSets) , 1);
					          
					          $attributeData = array();
					          if(!empty($attaributeArray)){
					            $attributeData['asin'] = $asin;
					            $attributeData['cost'] = $cost;
					            $attributeData['title'] = $attaributeArray['ItemAttributes']['Title'];
					            $attributeData['brand'] = $attaributeArray['ItemAttributes']['Brand'];
					            $attributeData['color'] = $attaributeArray['ItemAttributes']['Color'];
					            $attributeData['productType'] = $attaributeArray['ItemAttributes']['ProductTypeName'];
					            $attributeData['price'] = $attaributeArray['ItemAttributes']['ListPrice']['Amount'];
					            $attributeData['currencyCode'] = $attaributeArray['ItemAttributes']['ListPrice']['CurrencyCode'];
					            $attributeData['packageHeight'] = $attaributeArray['ItemAttributes']['PackageDimensions']['Height'];
					            $attributeData['packageLength'] = $attaributeArray['ItemAttributes']['PackageDimensions']['Length'];
					            $attributeData['packageWidth'] = $attaributeArray['ItemAttributes']['PackageDimensions']['Width'];
					            $attributeData['packageWeight'] = $attaributeArray['ItemAttributes']['PackageDimensions']['Weight'];
					            $attributeData['size'] = $attaributeArray['ItemAttributes']['Size'];
					          }

					          $asinData = !empty($xml->ListMatchingProductsResult->Products->Product->Identifiers->MarketplaceASIN)?$xml->ListMatchingProductsResult->Products->Product->Identifiers->MarketplaceASIN:'';
					          $result = json_decode( json_encode($asinData) , 1);
					          $asinId = $asin;

					          if(!empty($asinId)){

					            $priceparameter ="AWSAccessKeyId=AKIAJ5LP6U6FDV6X3MDA&Action=GetMyFeesEstimate&FeesEstimateRequestList.FeesEstimateRequest.1.IdType=ASIN&FeesEstimateRequestList.FeesEstimateRequest.1.IdValue=".$asinId."&FeesEstimateRequestList.FeesEstimateRequest.1.Identifier=request1&FeesEstimateRequestList.FeesEstimateRequest.1.IsAmazonFulfilled=true&FeesEstimateRequestList.FeesEstimateRequest.1.MarketplaceId=ATVPDKIKX0DER&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.ListingPrice.Amount=".$attributeData["price"]."&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.ListingPrice.CurrencyCode=".$attributeData["currencyCode"]."&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Points.PointsMonetaryValue.Amount=0&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Points.PointsMonetaryValue.CurrencyCode=".$attributeData["currencyCode"]."&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Points.PointsNumber=0&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Shipping.Amount=0&FeesEstimateRequestList.FeesEstimateRequest.1.PriceToEstimateFees.Shipping.CurrencyCode=".$attributeData["currencyCode"]."&SellerId=AXZU3XORX7Q7L&SignatureMethod=HmacSHA256&SignatureVersion=2&Timestamp=".urlencode(gmdate("Y-m-d\TH:i:s\Z"))."&Version=2011-10-01";

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
					              	$productobject = $xmlres->GetMyFeesEstimateResult->FeesEstimateResultList->FeesEstimateResult->FeesEstimate;

					              	$productPrice = json_decode( json_encode($productobject) , 1);

					              	$attributeData['totalFees'] = $productPrice['TotalFeesEstimate']['Amount'];
					              
					              	foreach ($productPrice['FeeDetailList']['FeeDetail'] as $feedetail) {
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
					              		$profit = $attributeData['price'] - $attributeData['totalFees'] - $cost;
					              		$attributeData['profit'] = $profit;
					              		$attributeData['roi'] = ($profit *  100)/$cost;
					              	}

					              	$id = DB::table('tblamazon_product')->where('asin', $asinId)->value('id');

					              	if(isset($id) && !empty($id)){

					              		array_push($products_array, $attributeData);
	                    			} else {

										if(!empty($csvId)){

											$attributeData['csv_id'] = $csvId;
										} else {

		                    				$csvId = DB::table('mwsImportExport')->insertGetId([
											    'csvName' => $csvName,
											    'created_at' => date('Y-m-d H:i:s', time()),
											    'created_by'     => auth()->user()->id
											]);
											$attributeData['csv_id'] = $csvId;
											$attributeData['created_at'] = date('Y-m-d H:i:s', time());
											$attributeData['created_by'] = auth()->user()->id;
		                    			}

						              	$result = AmazonMWS::create($attributeData);

						              	if($result){
				                            array_push($products_array, $attributeData);
				                        }
				                    }
					            }
					          }
					      	}
				        }
				    } else {
				    	Session::flash('message', 'Invalid CSV format.');
	      				Session::flash('alert-class', 'alert-danger');

				    	return redirect()->route('file_import_export');
				    }
		        }
		        //echo "<pre>";print_r(array_keys($attributeData));exit;
		        if(!empty($products_array)){
		        	$delimiter = ";";
		        	$filename = "amazonProducts.csv";
		        	$f = fopen('php://memory', 'w'); 
				    fputcsv($f, array_keys($attributeData), $delimiter); 
				    foreach ($products_array as $line) { 
				        fputcsv($f, $line, $delimiter); 
				    }
				    fseek($f, 0);
				    header('Content-Type: application/csv');
				    header('Content-Disposition: attachment; filename="'.$filename.'";');
				    fpassthru($f);
		        }

		        return redirect()->route('productImportedList');
		    } else {
		    	Session::flash('message', 'Invalid CSV format.');
  				Session::flash('alert-class', 'alert-danger');
		    	return redirect()->route('file_import_export');
		    }
		} else {
			return redirect()->route('file_import_export');
		}
    }

    function add(){

    	return view('amazon.add');
    }

    function upload(Request $request){

    	if(!empty($request->input('ids'))){
    		
    		foreach ($request->input('ids') as $productid) {
    			
    			$this->uploadProduct($productid,'');
    		}
    		
    	} else {
    		$productid = $request->input('productid');
    		$price = $request->input('newprice');

    		$this->uploadProduct($productid,$price);
    	}

    	return redirect()->route('walmartproductlist');
    }

    function uploadProduct($productid,$price=''){

    	$productDetail = WalmartScrap::find($productid);

    	//$productDetail = WalmartScrap::select('id','productid','walmartid','name','price','amazonPrice','images','model','brand','upc','shortdesc','description','delivery')->orderby('id','DESC')->get($productid);
    	//echo "<pre>";print_r($productDetail);exit;

    	if(empty($price)){
    		$price = $productDetail->price;
    	}
    	
    	$xml_string='<?xml version="1.0" encoding="iso-8859-1"?>
		<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		    xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
		  <Header>
		    <DocumentVersion>1.01</DocumentVersion>
		    <MerchantIdentifier>AXZU3XORX7Q7L</MerchantIdentifier>
		  </Header>
		  <MessageType>Product</MessageType>
		  <PurgeAndReplace>false</PurgeAndReplace>
		  <Message>
		    <MessageID>1</MessageID>
		    <OperationType>Update</OperationType>
		    <Product>
		      <SKU>'.@$productDetail->walmartid.'</SKU>
		      <StandardProductID>
		        <Type>UPC</Type>
		        <Value>'.@$productDetail->upc.'</Value>
		      </StandardProductID>
		      <ProductTaxCode>A_GEN_NOTAX</ProductTaxCode>
		      <DescriptionData>
		        <Title>'.@$productDetail->name.'</Title>
		        <Brand>'.@$productDetail->brand.'</Brand>
		        <Description>'.@$productDetail->description.'</Description>
		        <BulletPoint>'.@$productDetail->shortdesc.'</BulletPoint>
		        <MSRP currency="USD">'.@$price.'</MSRP>
		        <Manufacturer>'.@$productDetail->model.'</Manufacturer>
		        <ItemType>'.@$productDetail->productType.'</ItemType>
		      </DescriptionData>
		      <ProductData>
		        <Health>
		          <ProductType>
		            <HealthMisc>
		              <Ingredients>Example Ingredients</Ingredients>
		              <Directions>Example Directions</Directions>
		            </HealthMisc>
		          </ProductType>
		        </Health>
		      </ProductData>
		    </Product>
		  </Message>
		</AmazonEnvelope>';

		$var = base64_encode(md5(trim($xml_string),true));
 
		$param = array();
		$param['AWSAccessKeyId']   = 'AKIAJ5LP6U6FDV6X3MDA'; 
		$param['Action']           = 'SubmitFeed';  
		$param['ContentMD5Value']  = $var; 
		$param['FeedOptions']         = 'POST_TRANSACTION_PAYMENTS_BATCH_DATA';  
		$param['FeedType']         = '_POST_PRODUCT_DATA_';  
		//$param['MWSAuthToken']     = 'amzn.mws.**************-4565d8b3f16c';  
		$param['MarketplaceIdList.Id.1'] = 'A2EUQ1WTGCTBG2';    
		$param['Merchant']         = 'AXZU3XORX7Q7L'; 
		$param['PurgeAndReplace']  = 'false';  
		$param['SignatureMethod']  = 'HmacSHA256'; 
		$param['SignatureVersion'] = '2';
		$param['Timestamp'] = gmdate('Y-m-d\TH:i:s.u\Z'); 
		$param['Version']          = '2009-01-01';   
		 
		$secret = 'q4uEv7WGl7OsCIhffrJKuX4y4QnvEkmjEfQS5hMq';
		 
		$url = array();
		foreach ($param as $key => $val) {
		 
		    $key = str_replace("%7E", "~", rawurlencode($key));
		    $val = str_replace("%7E", "~", rawurlencode($val));
		    $url[] = "{$key}={$val}";
		}
		 
		sort($url);
		 
		$arr   = implode('&', $url);
		 
		$sign  = 'POST' . "\n";
		$sign .= 'mws.amazonservices.ca' . "\n";
		$sign .= '/Feeds/2009-01-01' . "\n";
		$sign .= $arr;
		 
		$signature = hash_hmac("sha256", $sign, $secret, true);
		$signature = urlencode(base64_encode($signature));
		 
		$link  = "https://mws.amazonservices.ca/Feeds/2009-01-01?";
		$link .= $arr . "&Signature=" . $signature;
		 
		$headers=array(
		    'Content-Type: application/xml',
		    'Content-Length: ' . strlen($xml_string),
		    'Content-MD5: ' . $var
		);
		 
		 
		$ch = curl_init($link);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_string);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		$err = curl_error($ch);
		curl_close($ch);

		if ($err) {
	      	Session::flash('message', 'Something went wrong');
	      	Session::flash('alert-class', 'alert-danger');
	      	return Back();
	    } else {
	      	$xmlres = simplexml_load_string($response);
	      	$feedResponse = json_decode( json_encode($xmlres->SubmitFeedResult->FeedSubmissionInfo) , 1);

	      	if($feedResponse['FeedProcessingStatus'] == '_SUBMITTED_'){

	      		DB::update('update tblwalmart_product set uploadedOnMWS = ? where id = ?',[1,$productDetail['id']]);

	      		$productid = DB::table('tblproduct_Walmart_To_Amazon')->insertGetId([
	      			'upc' => $productDetail->upc,
	      			'sku' => $productDetail->walmartid,
	      			'title' => $productDetail->name,
	      			'brand' => $productDetail->brand,
	      			//'color' => $productDetail->color,
	      			'productType' => $productDetail->productType,
	      			'price' => $price,
	      			//'size' => $productDetail->size,
				    'submissionId' => $feedResponse['FeedSubmissionId'],
				    'processingStatus' => $feedResponse['FeedProcessingStatus'],
				    'currentStatus' => 'Pending',
				    'created_at' => date('Y-m-d H:i:s', time()),
				    'created_by' => auth()->user()->id
				]);

	      		$logId = DB::table('mwsRequestLog')->insertGetId([
				    'submissionId' => $feedResponse['FeedSubmissionId'],
				    'requestType' => $feedResponse['FeedType'],
				    'processingStatus' => $feedResponse['FeedProcessingStatus'],
				    'currentStatus' => 'Pending',
				    'submittedDate' => date('Y-m-d H:i:s', time()),
				    'submittedBy' => auth()->user()->id
				]);

	      		Session::flash('message', 'Product Submited Successfully on Store');
		      	Session::flash('alert-class', 'alert-success');
		    } else {
		    	Session::flash('message', $feedResponse['FeedProcessingStatus']);
		      	Session::flash('alert-class', 'alert-danger');
		    }
	    }
    }

    public function filter(Request $request){

    	if(!empty($request->input('filter'))){

    		$filter = array();
    		foreach ($request->input('filter') as $parameter) {
    			array_pop($parameter);

    			if($parameter[0] == 'price' || $parameter[0] == 'packageHeight' || $parameter[0] == 'packageLength' || $parameter[0] == 'packageWidth' || $parameter[0] == 'packageWeight' || $parameter[0] == 'packagequantity' || $parameter[0] == 'size'){
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

    		$products = DB::table('tblproduct_Walmart_To_Amazon')->select('id','asin','upc','sku','title','brand','price','color','cost','productType','currencyCode','packageHeight','packageLength','packageWidth','packageWeight','packagequantity','size','submissionId','processingStatus','currentStatus')->where($filter)->orderby('id','DESC')->get();

    		$return_arr = !empty($products)?$products:array();
    		echo json_encode($return_arr);
    		exit;
    	}
    }
}
