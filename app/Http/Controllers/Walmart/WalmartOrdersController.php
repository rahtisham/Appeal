<?php

namespace App\Http\Controllers\Walmart;

use App\Http\Controllers\Controller;
use App\WalmartItemAlert;
use Illuminate\Http\Request;
use App\walmart_order_details;

class WalmartOrdersController extends Controller
{
    public function walmart_orders()
    {
        $walmart_orders = walmart_order_details::all();
        return view('walmarts.walmart_order' , ['walmart_orders' => $walmart_orders]);
    }

    public function order_status()
    {
        return view('walmartIntegration.order_status');
    }
}
