<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WalmartSettings extends Model
{
    protected $table = 'walmart_settings';
    public $timestamps = false;

    protected $fillable = [
        'client_id','client_secret','walmart_service_name', 'correlation_id', 'access_token'
    ];
}
