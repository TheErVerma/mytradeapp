<?php

namespace App\Services;

use App\Models\Options;
use Auth;
use GuzzleHttp\Client;
use Upstox\Client\Configuration;

class OptionService
{
    static public function updateOption($key, $value, $user_id = null)
    {

        if ($user_id == null && Auth::id()) {
            $user_id = Auth::id();
        }

        $new_option = Options::updateOrCreate(
            [
                'option_name' => $key,
                'user_id' => $user_id,
            ],
            [
                'option_value' => is_array($value) ? json_encode($value) : $value,
                'user_id' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return $new_option;
    }

    public static function getOption($key, $user_id = null)
    {
        $user_id ??= Auth::id();

        $option = Options::where([
            'option_name' => $key,
            'user_id' => $user_id,
        ])->value('option_value');

        if ($option === null) {
            return null;
        }

        $decoded = json_decode($option, true);

        return json_last_error() === JSON_ERROR_NONE
            ? $decoded
            : $option;
    }
}