<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\HelperController;

class ApiController extends Controller
{
    static public function fetchStockData($symbol)
    {
        $crnt_cache_key = 'cache_'.$symbol;
        $symbol_value = '';
        if(Cache::has($crnt_cache_key)){
            $symbol_value = json_decode(base64_decode(Cache::get($crnt_cache_key), true));
        }else{
            // $response = Http::withHeaders([
            //     'X-Api-Key' => 'GXKgD2b3P9v40kRjIKqL61FiDAYQeF1yL2csEHKB',
            // ])->get('https://api.api-ninjas.com/v1/stockprice', [
            //     'ticker' => strtoupper($symbol),
            // ]);

            // $symbol_value = json_decode(json_encode($response->json()), true);
            // if(is_array($symbol_value) && isset($symbol_value['name'])){
            //     Cache::put($crnt_cache_key, base64_encode(json_encode($symbol_value)), $seconds = 3600);
            // }
            // return $symbol_value;
        }

        return $symbol_value;
    }

}
