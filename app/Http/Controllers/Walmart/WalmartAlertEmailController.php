<?php

namespace App\Http\Controllers\Walmart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WalmartItemAlert;

class WalmartAlertEmailController extends Controller
{
    public function index()
    {
        $walmart_alert_email = WalmartItemAlert::all();
        return view('walmarts.walmart_alert_email_template' , ['walmart_alert_email' => $walmart_alert_email]);
    }

    public function email_template($id)
    {
        $walmart_amail_alert_view = WalmartItemAlert::where('sku' , $id)
            ->first();
        return view('walmarts.email_template' , ['walmart_amail_alert_view' => $walmart_amail_alert_view]);
    }
}
