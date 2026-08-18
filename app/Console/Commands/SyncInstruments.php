<?php

namespace App\Console\Commands;

use App\Http\Controllers\UpstoxController;
use App\Models\Instruments;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

#[Signature('instruments:sync')]
#[Description('Command description')]
class SyncInstruments extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Log::debug("Cron Triggered: ".date('F d, Y H:i:s'));

        // $page = Cache::get('upstox_api_page', 1);
        // Log::debug("Page: ".$page);

        // $page++;

        // Cache::set('upstox_api_page', $page);

        // $upstox_data = UpstoxController::fetchData('a', null, $page);
        // Log::debug(print_r($upstox_data, true));




        $url = 'https://assets.upstox.com/market-quote/instruments/exchange/complete.json.gz';

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0',
            'Accept' => '*/*',
        ])->timeout(120)->get($url);

        if (!$response->successful()) {
            throw new Exception(
                'Failed to download instruments: ' . $response->status()
            );
        }

        $compressed = $response->body();

        $json = gzdecode($compressed);
        if ($json === false) {
            throw new Exception('Unable to decompress gzip file.');
        }

        $resp_data = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(
                'Invalid JSON: ' . json_last_error_msg()
            );
        }

        $toDateTime = function ($timestamp) {
            return !empty($timestamp)
                ? Carbon::createFromTimestampMs((int) $timestamp)
                : null;
        };

        if (!empty($resp_data)) {
            foreach ($resp_data as $upstox_item) {

                $final_upstx_itm = [
                    'name' => $upstox_item['name'] ?? null,
                    'segment' => $upstox_item['segment'] ?? null,
                    'exchange' => $upstox_item['exchange'] ?? null,
                    'isin' => $upstox_item['isin'] ?? null,

                    'expiry' => $toDateTime($upstox_item['expiry'] ?? null),

                    'country' => $upstox_item['country'] ?? null,
                    'latency' => $upstox_item['latency'] ?? null,
                    'description' => $upstox_item['description'] ?? null,
                    'currency' => $upstox_item['currency'] ?? null,
                    'weekly' => (bool) ($upstox_item['weekly'] ?? false),

                    'instrument_key' => $upstox_item['instrument_key'] ?? null,
                    'exchange_token' => $upstox_item['exchange_token'] ?? null,
                    'trading_symbol' => $upstox_item['trading_symbol'] ?? null,
                    'short_name' => $upstox_item['short_name'] ?? null,

                    'tick_size' => $upstox_item['tick_size'] ?? null,
                    'lot_size' => $upstox_item['lot_size'] ?? null,
                    'instrument_type' => $upstox_item['instrument_type'] ?? null,
                    'freeze_quantity' => $upstox_item['freeze_quantity'] ?? null,

                    'underlying_key' => $upstox_item['underlying_key'] ?? null,
                    'underlying_type' => $upstox_item['underlying_type'] ?? null,
                    'underlying_symbol' => $upstox_item['underlying_symbol'] ?? null,

                    'last_trading_date' => $toDateTime(
                        $upstox_item['last_trading_date'] ?? null
                    ),

                    'strike_price' => $upstox_item['strike_price'] ?? null,
                    'price_quote_unit' => $upstox_item['price_quote_unit'] ?? null,
                    'qty_multiplier' => $upstox_item['qty_multiplier'] ?? null,
                    'minimum_lot' => $upstox_item['minimum_lot'] ?? null,

                    'start_time' => $toDateTime(
                        $upstox_item['start_time'] ?? null
                    ),

                    'end_time' => $toDateTime(
                        $upstox_item['end_time'] ?? null
                    ),

                    'week_days' => $upstox_item['week_days'] ?? null,

                    'general_denominator' => $upstox_item['general_denominator'] ?? null,
                    'general_numerator' => $upstox_item['general_numerator'] ?? null,
                    'price_numerator' => $upstox_item['price_numerator'] ?? null,
                    'price_denominator' => $upstox_item['price_denominator'] ?? null,

                    'mtf_enabled' => isset($upstox_item['mtf_enabled'])
                        ? (bool) $upstox_item['mtf_enabled']
                        : null,

                    'mtf_bracket' => $upstox_item['mtf_bracket'] ?? null,
                    'security_type' => $upstox_item['security_type'] ?? null,
                ];

                Instruments::updateOrCreate(
                    [
                        'instrument_key' => $final_upstx_itm['instrument_key'],
                    ],
                    $final_upstx_itm
                );
            }
        }

    }
}
