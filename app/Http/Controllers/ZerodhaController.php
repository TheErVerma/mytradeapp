<?php

namespace App\Http\Controllers;

use App\Models\BrokerIntegration;
use App\Models\Instruments;
use App\Models\Trade;
use App\Services\ZerodhaService;
use Auth;
use Http;
use Illuminate\Http\Request;
use Log;




class ZerodhaController extends Controller
{

    public function redirectToZerodha()
    {
        $url = 'https://kite.zerodha.com/connect/login?v=3&api_key=' . config('services.zerodha.api_key');

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        $requestToken = $request->input('request_token');

        $checksum = hash(
            'sha256',
            config('services.zerodha.api_key')
            . $requestToken
            . config('services.zerodha.secret_key')
        );

        $response = Http::asForm()->post(
            'https://api.kite.trade/session/token',
            [
                'api_key' => config('services.zerodha.api_key'),
                'request_token' => $requestToken,
                'checksum' => $checksum,
            ]
        );

        $data = $response->json('data', []);

        $accessToken = isset($data['access_token']) ? $data['access_token'] : '';

        if (!$accessToken) {
            return redirect()
                ->route('integrate')
                ->with('error', 'Zerodha login failed.');
        }

        $user_id = Auth::id();
        if ($user_id) {

            BrokerIntegration::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'broker' => 'kite',
                ],
                [
                    'access_token' => $accessToken,
                    'is_active' => true,
                ]
            );

            return redirect()
                ->route('integrate')
                ->with('success', 'Zerodha connected successfully.');
        }

    }

    public function disconnect()
    {
        BrokerIntegration::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'broker' => 'kite',
            ],
            [
                'access_token' => '',
                'is_active' => false,
            ]
        );

        return redirect()
            ->route('integrate')
            ->with('success', 'Zerodha disconnected successfully.');
    }


    public function syncOrFetch(Request $request)
    {

        $selectTrades = $request->input('selectTrades');
        $user_id = Auth::id();
        $broker_init = BrokerIntegration::where('user_id', $user_id)->where('broker', 'kite')->first();
        $broker_init = collect($broker_init)->toArray();
        $token = isset($broker_init['access_token']) ? $broker_init['access_token'] : '';
        $kiteServ = new ZerodhaService(config('services.zerodha.api_key'), $token);

        $holdings = $kiteServ->holdings()['data'];
        // $positions = $kiteServ->positions()['data'];

        $all_trades = [];
        if (is_array($holdings)) {
            $all_trades = array_merge($all_trades, $holdings);
        }

        $selectTrades = 'yes';
        $req_resp = [];

        if (is_array($all_trades) && !empty($all_trades)) {
            Log::debug(print_r($all_trades, true));
            foreach ($all_trades as $position) {
                $instrument_arr = collect(Instruments::where('instrument_key', 'LIKE', '%' . $position["isin"] . '%')
                    ->where('instrument_key', 'LIKE', '%' . $position["exchange"] . '%')->first())->toArray();

                $trd_type = match ($instrument_arr['instrument_type']) {
                    'EQ' => 'Cash',
                    'FUT', 'CE', 'PE' => 'F&O',
                    default => 'Other',
                };

                if ($trd_type == 'Other') {
                    $trd_type = match ($instrument_arr['segment']) {
                        'EQ' => 'Cash',
                        'FUT', 'CE', 'PE' => 'F&O',
                        default => 'Other',
                    };
                }
                $new_data = [
                    'trd_symbol' => $instrument_arr['trading_symbol'] . (isset($instrument_arr['short_name']) && $instrument_arr['short_name'] != "" ? ' (' . $instrument_arr['short_name'] . ')' : ''),
                    'trd_symbol_key' => $instrument_arr['instrument_key'],
                    'trd_action' => $position['quantity'] > 0 ? 'Long' : 'Short',
                    'trd_date' => date('Y-m-d'),
                    'trd_exit_date' => null,
                    'trd_shares' => isset($position["quantity"]) ? $position["quantity"] : 0,
                    'trd_price' => isset($position["average_price"]) ? $position["average_price"] : 0,
                    'trd_exit_price' => isset($position["sell_price"]) ? $position["sell_price"] : 0,
                    'trd_charges_amount' => 0,
                    'trd_lot' => isset($position["quantity"]) ? $position["quantity"] : 0,
                    'trd_type' => $trd_type,
                    'user_id' => Auth::id(),
                ];
                if ($selectTrades != "no") {
                    $new_data['instrument'] = $instrument_arr;
                } else {
                    // $new_row = Trade::updateOrCreate($new_data, ['trd_symbol_key' => $instrument_arr['instrument_key']]);
                }
                $req_resp[] = $new_data;
            }
        }
        return response()->json([
            "status" => 200,
            "data" => $req_resp,
            "html" => $selectTrades == "yes" ? view('components.broker-trades', ['broker_data' => $req_resp])->render() : '',
        ]);
    }

}