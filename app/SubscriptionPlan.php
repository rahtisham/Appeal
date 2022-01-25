<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
     protected $table = 'subscription_plans';
     public $timestamps = false;

     protected $fillable = [
        'price', 'month', 'description'
    ];
}
