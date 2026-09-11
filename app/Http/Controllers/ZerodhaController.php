<?php

namespace App\Http\Controllers;

use App\Mail\OTPEmail;
use App\Models\BrokerIntegration;
use App\Models\Instruments;
use App\Models\Trade;
use App\Models\User;
use App\Services\ZerodhaService;
use Auth;
use Crypt;
use Hash;
use Http;
use Illuminate\Http\Request;
use Log;
use Mail;




class ZerodhaController extends Controller
{

    public function redirectToZerodha()
    {
        $url = 'https://kite.zerodha.com/connect/login?v=3&api_key=' . config('services.zerodha.api_key');

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        $api_key = config('services.zerodha.api_key');
        $secret_key = config('services.zerodha.secret_key');

        $requestToken = $request->input('request_token');

        $checksum = hash(
            'sha256',
            $api_key
            . $requestToken
            . $secret_key
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
        if ($user_id && Auth::check()) {

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
        } else {

            $profileResponse = Http::withHeaders([
                'X-Kite-Version' => '3',
                'Authorization' => 'token ' . $api_key . ':' . $accessToken,
            ])->get('https://api.kite.trade/user/profile');

            if ($profileResponse->failed()) {
                return redirect('/login')
                    ->with('error', 'Unable to fetch Zerodha profile.');
            }

            $profile = data_get($profileResponse->json(), 'data');

            if (isset($profile['email'])) {
                $user = User::where('email', $profile['email'])->first();

                if (!$user) {
                    $user = User::create([
                        'name' => $profile['user_name'],
                        'email' => $profile['email'],
                        'password' => bcrypt(str()->random(32)),
                    ]);
                }

                BrokerIntegration::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'broker' => 'kite',
                    ],
                    [
                        'access_token' => $accessToken,
                        'is_active' => true,
                    ]
                );

                Auth::login($user, true);

                return redirect('/')->with('success', 'Login Successful.');
            }
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

        $slctTrdEntry = $request->input('slctTrdEntry');

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

        $req_resp = [];
        $new_data = [];
        if (is_array($all_trades) && !empty($all_trades)) {
            foreach ($all_trades as $position) {
                $instrument_arr = collect(Instruments::where('instrument_key', 'LIKE', '%' . $position["isin"] . '%')
                    ->where('instrument_key', 'LIKE', '%' . $position["exchange"] . '%')->first())->toArray();

                $trd_type = match ($instrument_arr['instrument_type']) {
                    'EQ' => 'Cash',
                    'FUT', 'CE', 'PE' => 'F&O',
                    default => 'Other',
                };

                if ($trd_type == 'Other') {
                    $segment = last(explode('_', $instrument_arr['segment']));
                    $trd_type = match ($segment) {
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
                // Log::debug(print_r($new_data, true));
                if ($selectTrades != "no" && $slctTrdEntry == "") {
                    $new_data['instrument'] = $instrument_arr;
                } else {
                    // Log::debug(trim($instrument_arr['instrument_key']));
                    if ($slctTrdEntry) {
                        if (in_array($instrument_arr['instrument_key'], $slctTrdEntry)) {
                            $new_row = Trade::updateOrCreate(['user_id' => Auth::id(), 'trd_symbol_key' => trim($instrument_arr['instrument_key'])], $new_data);
                        }
                    } else {
                        $new_row = Trade::updateOrCreate(['user_id' => Auth::id(), 'trd_symbol_key' => trim($instrument_arr['instrument_key'])], $new_data);
                    }
                }
                $req_resp[] = $new_data;
            }
        }
        if ($slctTrdEntry || $selectTrades == "no") {
            return response()->json([
                "status" => 200,
                "entry" => $slctTrdEntry,
                "new_row" => $req_resp
            ]);
        } else {
            return response()->json([
                "status" => 200,
                "data" => $req_resp,
                "html" => $selectTrades == "yes" ? view('components.broker-trades', ['broker_data' => $req_resp])->render() : '',
            ]);
        }
    }

}