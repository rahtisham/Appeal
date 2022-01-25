<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MSKU extends Model
{
    protected $table = 'tblItem_msku_assign';
    public $timestamps = true;

    protected $fillable = [
            'id',
            'msku',
            'asin',
    ];
}
