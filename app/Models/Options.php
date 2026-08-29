<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $fillable = [
        'user_id',
        'option_name',
        'option_value',
        'created_at',
        'updated_at',
    ];
}
