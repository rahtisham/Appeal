<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmazonMWS extends Model
{
    protected $table = 'tblamazon_product';
    public $timestamps = true;

    protected $casts = [
        'price' => 'float'
    ];

    protected $fillable = [
        'csv_id',
    	'asin',
    	'title',
        'brand',
        'color',
        'productType',
        'salesrank',
        'cost',
        'price',
        'price',
        'currencyCode',
        'packageHeight',
        'packageLength',
        'packageWidth',
        'packageWeight',
        'packagequantity',
        'variationparent',
        'offers',
        'category',
        'size',
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
        'roi'
    ];
}
