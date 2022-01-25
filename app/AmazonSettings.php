<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmazonSettings extends Model
{
    protected $table = 'amazon_settings';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'client_id', 'client_secret', 'access_key','secret_key','refresh_token'
    ];
}
