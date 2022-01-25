<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Walmart;
use Auth;
use Hash;

class WalmartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        $items = Walmart::select('*')->where('created_by',auth()->user()->id)->orderby('id','DESC')->get();

        $data = array('pageTitle' => "Walmart Item List",'items' => $items);

        return view('walmart.list')->with($data);
    }
}
