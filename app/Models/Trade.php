<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'trd_symbol',
        'trd_action',
        'trd_date',
        'trd_time',
        'trd_shares',
        'trd_price',
        'user_id',
        'trd_lot',
        'trd_type',
        'trd_screenshots'
    ];
}
