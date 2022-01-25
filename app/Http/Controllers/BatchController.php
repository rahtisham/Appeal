<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batch;
use DB;
use App\Http\Controllers\Controller;
use \ClouSale\AmazonSellingPartnerAPI AS AmazonSellingPartnerAPI;

class BatchController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = array('pageTitle' => "All Batches");
        $data['batches'] = Batch::select()->orderby('id','DESC')->get();
        
        return view('batch.index')->with($data);
    }

    public function list(){

        /*--------------------------------*/

        /*$controller = new Controller();
        $config = $controller->getConfig();

        $apiInstance = new AmazonSellingPartnerAPI\Api\CatalogApi($config);

        $marketplace_id = "ATVPDKIKX0DER"; // string | A marketplace identifier. Specifies the marketplace for the item.
        $asin = "B08CST1LJF"; // string | The Amazon Standard Identification Number (ASIN) of the item.

        try {
            $result = $apiInstance->getCatalogItem($marketplace_id, $asin);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling CatalogApi->getCatalogItem: ', $e->getMessage(), PHP_EOL;
        }*/
        /*--------------------------------*/

        $data = array('pageTitle' => "Batches");
        $data['batch_id'] = !empty($_GET['id'])?$_GET['id']:'';

        $data['batches'] = Batch::select()->orderby('id','DESC')->get();
        
        return view('batch.list')->with($data);
    }

    public function searchAsin(Request $request){
        $asin = !empty($request->input('txt'))?$request->input('txt'):'';
        if(!empty($asin)){

            $controller = new Controller();
            $config = $controller->getConfig();

            $apiInstance = new \ClouSale\AmazonSellingPartnerAPI\Api\CatalogApi($config);

            $marketplace_id = "ATVPDKIKX0DER"; // string | A marketplace identifier. Specifies the marketplace for the item.
            //$asin = "B08CST1LJF"; // string | The Amazon Standard Identification Number (ASIN) of the item.
            //seller_id = "1630654090";

            try {
                $result = $apiInstance->getCatalogItem($marketplace_id, $asin);
                $item = $result->getPayload()->getAttributeSets();
                $salserank = $result->getPayload()['sales_rankings'];
                $item_array = array(
                    'asin' => $asin,
                    'marketplace_id' => $marketplace_id,
                    'title' => $item[0]['title'],
                    'product_group' => $item[0]['product_group'],
                    'image' => $item[0]['small_image']['url'],
                    'rank' => $salserank[0]['rank']
                );
                
            } catch (Exception $e) {
                $item_array = array();
            }

            

            $return_arr = !empty($item_array)?$item_array:array();
            echo json_encode($return_arr);
            exit;
        }
    }

    public function createmsku(Request $request){
        
        $data=array(
                'msku' => $request->input('msku'),
                'asin' => $request->input('itemasin'),
                'created_by' => $request->user()->id,
                'created_at' => date('Y-m-d H:i:s')
            );
        DB::table('tblItem_msku_assign')->insert($data);

        echo "MSKU created successfully";
    }

    public function addBatch(Request $request){

        $data = array('pageTitle' => "Add Batch");
        return view('batch.create')->with($data);
    }

    public function store(Request $request){

        $this->validate($request, [
            'batch_name' => 'required|unique:tblbatch,name',
            //'permission' => 'required',
        ]);

        $batch = Batch::create(['name' => $request->input('batch_name'),
                                'ship_from' => $request->input('ship_from'),
                                'packing_type' => $request->input('packing_type'),
                                'channel' => $request->input('channel'),
                                'workflow' => $request->input('workflow'),
                                'labeling' => $request->input('labeling'),
                                'box_content' => $request->input('box_content'),
                                'min_max' => $request->input('min_max'),
                                'ship_method' => $request->input('ship_method')
                        ]);

        return redirect()->route('batch')->with('success','Batch created successfully');
    }

}
