<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'tblbatch';
    public $timestamps = true;

    protected $fillable = [
            'id',
            'name',
            'ship_from',
            'packing_type',
            'channel',
            'workflow',
            'labeling',
            'box_content',
            'min_max',
            'ship_method'
    ];
}
