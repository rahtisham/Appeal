<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLogs extends Model
{
    protected $table = 'payment_logs';
    protected $fillable = [
        'amount','response_code','transaction_id', 'auth_id','quantity','message_code','name_on_card'
    ];
}
