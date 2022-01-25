<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalmartScrap extends Model
{
    protected $table = 'tblwalmart_product';
    public $timestamps = true;

    protected $casts = [
        'price' => 'float'
    ];

    protected $fillable = [
    	'productid',
    	'walmartid',
        'name',
        'price',
        'amazonPrice',
        'images',
        'path',
        'model',
        'brand',
        'productType',
        'upc',
        'specifications',
        'shortdesc',
        'description',
        'delivery',
        'delivery_days',
        'totalFees',
        'referralFee',
        'closingFee',
        'perItemFee',
        'fbaFees',
        'estimatedsales',
        'shippingcost',
        'fixedadditionalcost',
        'percentadditionalcost',
        'profit',
        'roi',
        'uploadedOnMWS',
        'feedResponse',
        'add_date',
        'update_date',
        'ip_address',
    ];
}
