<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Walmart extends Model
{
    protected $table = 'tblwlamartItems';
    public $timestamps = true;

    protected $casts = [
        'price' => 'float'
    ];

    protected $fillable = [
        'id',
        'mart',
        'wpid',
        'sku',
        'upc',
        'gtin',
        'productName',
        'productType',
        'price',
        'currency',
        'publishedStatus',
        'updated_by',
        'updated_at',
        'created_by',
        'created_at',
    ];
}
