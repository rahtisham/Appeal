<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'tblamazonOrderList';
    public $timestamps = true;

    protected $casts = [
        'price' => 'float'
    ];

    protected $fillable = [
        'id',
    	'amazonOrderId',
    	'orderType',
        'purchaseDate',
        'latestShipDate',
        'isReplacementOrder',
        'numberOfItemsShipped',
        'shipServiceLevel',
        'orderStatus',
        'isBusinessOrder',
        'numberOfItemsUnshipped',
        'paymentMethod',
        'paymentMethodDetail',
        'isPremiumOrder',
        'amount',
        'currencyCode',
        'city',
        'postalCode',
        'stateOrRegion',
        'countryCode',
        'isAddressSharingConfidential',
        'shipmentServiceLevelCategory',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
}
