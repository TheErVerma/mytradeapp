<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrokerIntegration extends Model
{
    protected $fillable = [
        'user_id',
        'broker',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'broker_user_id',
        'is_active',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
