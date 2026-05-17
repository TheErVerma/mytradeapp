<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'trd_market_name',
        'trd_symbol',
        'trd_action',
        'trd_date',
        'trd_time',
        'trd_shares',
        'trd_price',
        'trd_commissions',
        'trd_fees',
    ];
}
