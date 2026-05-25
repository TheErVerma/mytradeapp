<?php

namespace App\Http\Controllers;
use App\Models\Options;

abstract class Controller
{
    public function updateOption($key, $value)
    {

        $value = is_array($value) ? serialize($value) : $value;

        $opt_value = $this->getOption($key);

        if ($opt_value) {
            $option = Options::where('option_name', $key)->update([
                'option_value' => $value
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Option Updated successfully',
                'option' => $option,
            ]);
        }

        $option = Options::create([
            'option_name' => $key,
            'option_value' => $value
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Option Added successfully',
            'option' => $option,
        ]);
    }

    public function getOption($key)
    {
        $option_obj = Options::where('option_name', $key)->first();
        if (isset($option_obj['option_value'])) {
            return $option_obj['option_value'];
        }

        return false;
    }
}
