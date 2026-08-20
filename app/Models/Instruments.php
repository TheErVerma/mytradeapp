<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instruments extends Model
{
    protected $fillable = [
        "name",
        "segment",
        "exchange",
        "isin",
        "expiry",
        "country",
        "latency",
        "description",
        "currency",
        "weekly",
        "instrument_key",
        "exchange_token",
        "trading_symbol",
        "short_name",
        "tick_size",
        "lot_size",
        "instrument_type",
        "freeze_quantity",
        "underlying_key",
        "underlying_type",
        "underlying_symbol",
        "last_trading_date",
        "strike_price",
        "price_quote_unit",
        "qty_multiplier",
        "minimum_lot",
        "start_time",
        "end_time",
        "week_days",
        "general_denominator",
        "general_numerator",
        "price_numerator",
        "price_denominator",
        "mtf_enabled",
        "mtf_bracket",
        "security_type",
    ];
    
}
