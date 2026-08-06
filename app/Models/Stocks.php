<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $fillable = [
        "symbol",
        "title",
        "exchange",
        "instrument_type",
        "series",
        "isin",
        "sector",
        "industry",
        "lot_size",
        "tick_size",
        "face_value",
        "description",
        "logo",
        "website",
        "is_active",
        "sort_order",
    ];
}
