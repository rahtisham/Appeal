<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'subscribers';
    public $timestamps = false;

    protected $fillable = [
        'price', 'name', 'description'
    ];
}
