<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    protected $fillable = [
        'trd_symbol',
        'trd_action',
        'trd_date',
        'trd_shares',
        'trd_price',
        'trd_exit_price',
        'user_id',
        'trd_lot',
        'trd_type',
        'trd_screenshots',
        'notes',
        'trd_charges_amount',
        'trd_symbol_key',
    ];

    public function instrument()
    {
        return $this->belongsTo(Instruments::class, 'trd_symbol_key', 'instrument_key');
    }
}
