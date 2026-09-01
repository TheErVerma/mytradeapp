<?php

namespace App\Http\Controllers;

use App\Models\BrokerIntegration;
use App\Models\Instruments;
use App\Models\Trade;
use App\Models\User;
use Auth;
use DB;
use Http;
use Illuminate\Http\Request;
use App\Services\UpstoxService;
use Str;
use Upstox\Client\Api\UserApi;
use Upstox\Client\Api\InstrumentsApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpstoxController extends Controller
{

    public function connect()
    {
        $query = http_build_query([
            'client_id' => config('services.upstox.client_id'),
            'redirect_uri' => config('services.upstox.redirect_uri'),
            'response_type' => 'code',
        ]);

        $url = 'https://api.upstox.com/v2/login/authorization/dialog?' . $query;

        return redirect()->away($url);
    }

    public function callback(Request $request)
    {
        $usr_id = Auth::id();

        if ($usr_id) {
            if (!$request->filled('code')) {
                return redirect()
                    ->route('brokers.index')
                    ->with('error', 'Upstox authorization failed.');
            }

            $service = app(UpstoxService::class);

            $token = $service->getAccessToken(
                $request->code
            );

            // Store token for authenticated user
            BrokerIntegration::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'broker' => 'upstox',
                ],
                [
                    'access_token' => $token['access_token'],
                    'is_active' => true,
                ]
            );

            return redirect()
                ->route('integrate')
                ->with('success', 'Upstox connected successfully.');
        } else {

            session()->forget('upstox_oauth_state');

            if (!$request->code) {
                Log::debug("No Code");
                return redirect()
                    ->route('login')
                    ->withErrors([
                        'upstox' => 'Upstox authentication failed.',
                    ]);
            }

            /*
             * Exchange authorization code for access token.
             */
            $response = Http::asForm()
                ->withHeaders([
                    'Accept' => 'application/json',
                ])
                ->post(
                    'https://api.upstox.com/v2/login/authorization/token',
                    [
                        'code' => $request->code,
                        'client_id' => config('services.upstox.client_id'),
                        'client_secret' => config('services.upstox.client_secret'),
                        'redirect_uri' => config('services.upstox.redirect_uri'),
                        'grant_type' => 'authorization_code',
                    ]
                );

            if ($response->failed()) {
                Log::debug(print_r($response->json(), true));
                return redirect()
                    ->route('login')
                    ->withErrors([
                        'upstox' => $response->json('message')
                            ?? 'Unable to authenticate with Upstox.',
                    ]);
            }

            $upstox = $response->json();

            DB::transaction(function () use ($upstox, &$user) {

                /*
                 * Find existing Laravel user.
                 */
                $user = User::where('email', $upstox['email'])->first();

                /*
                 * Create new Laravel user.
                 */
                if (!$user) {
                    $user = User::create([
                        'name' => $upstox['user_name'],
                        'email' => $upstox['email'],
                        'password' => bcrypt(str()->random(32)),
                    ]);
                }

                /*
                 * Create/update Upstox integration.
                 */
                BrokerIntegration::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'broker' => 'upstox',
                    ],
                    [
                        'broker_user_id' => $upstox['user_id'],
                        'access_token' => $upstox['access_token'],
                        'refresh_token' => $upstox['refresh_token'] ?? null,
                        'token_expires_at' => isset($upstox['expires_at'])
                            ? now()->addSeconds($upstox['expires_at'])
                            : null,
                        'is_active' => true,
                    ]
                );
            });

            Auth::login($user, true);

            $request->session()->regenerate();

            return redirect()->intended('/journal');
        }
    }

    static public function fetchData($search = 'a', $type = null, $page = 1)
    {
        return false;
    }

    public function loadMoreData(Request $request)
    {
        $validated = $request->validate([
            // 'page' => 'required',
            'search' => '',
        ]);

        $srch_str = isset($validated['search']) && $validated['search'] != "" ? $validated['search'] : 'a';
        // return Instruments::where('name', 'LIKE', '%'.$srch_str.'%')->get();

        $searchOperator = DB::connection()->getDriverName() === 'pgsql'
            ? 'ILIKE'
            : 'LIKE';

        $searchableColumns = [
            'name',
            'segment',
            'exchange',
            'isin',
            'expiry',
            'country',
            'latency',
            'description',
            'currency',
            'weekly',
            'instrument_key',
            'exchange_token',
            'trading_symbol',
            'short_name',
            'tick_size',
            'lot_size',
            'instrument_type',
            'freeze_quantity',
            'underlying_key',
            'underlying_type',
            'underlying_symbol',
            'last_trading_date',
            'strike_price',
            'price_quote_unit',
            'qty_multiplier',
            'minimum_lot',
            'start_time',
            'end_time',
            'week_days',
            'general_denominator',
            'general_numerator',
            'price_numerator',
            'price_denominator',
            'mtf_enabled',
            'mtf_bracket',
            'security_type',
        ];

        $searchTerms = preg_split('/\s+/', trim($srch_str), -1, PREG_SPLIT_NO_EMPTY);

        $instruments_qry = Instruments::query()
            ->where(function ($query) use ($searchTerms, $searchableColumns, $searchOperator) {

                foreach ($searchTerms as $term) {

                    $query->where(function ($q) use ($term, $searchableColumns, $searchOperator) {

                        $search = "%{$term}%";

                        foreach ($searchableColumns as $column) {
                            $q->orWhere($column, $searchOperator, $search);
                        }

                    });

                }

            })
            ->whereNot('exchange', ['GLOBAL'])
            //     ->orderByRaw(
            //         DB::connection()->getDriverName() === 'pgsql'
            //         ? "CASE
            //     WHEN LOWER(trading_symbol) LIKE LOWER(?) THEN 1
            //     WHEN trading_symbol ~ '^[A-Za-z]' THEN 2
            //     ELSE 3
            //   END"
            //         : "CASE
            //     WHEN LOWER(trading_symbol) LIKE LOWER(?) THEN 1
            //     WHEN trading_symbol REGEXP '^[A-Za-z]' THEN 2
            //     ELSE 3
            //   END",
            //         [$searchTerms[0] . '%']
            //     )
            //     ->orderBy('trading_symbol', 'ASC')
            ->orderByRaw("
                CASE
                    WHEN underlying_type = 'COM' AND instrument_type = 'FUT' THEN 1
                    WHEN instrument_type = 'A' THEN 2
                    WHEN instrument_type = 'COM' THEN 3
                    WHEN instrument_type = 'INDEX' THEN 4
                    WHEN instrument_type IN ('EQ', 'A') THEN 5
                    WHEN instrument_type = 'FUT' THEN 6
                    WHEN instrument_type IN ('CE', 'PE') THEN 7
                    WHEN instrument_type IN ('F', 'N1', 'N0') THEN 8

                    ELSE 4
                END
            ")
            ->orderBy('id', 'asc');

        // Log::debug($instruments_qry->toSql());
        $instruments = $instruments_qry->paginate(100);

        return $instruments;

        // return self::fetchData($srch_str, null, $validated['page']);
    }

    static private function refineUpstoxData($resp_data)
    {
        $final_upstx_data = [];
        if (!empty($resp_data)) {
            foreach ($resp_data as $upstox_item) {
                $final_upstx_itm = [
                    "name" => $upstox_item->getName(),
                    "segment" => $upstox_item->getSegment(),
                    "exchange" => $upstox_item->getExchange(),
                    "isin" => $upstox_item->getIsin(),
                    "expiry" => $upstox_item->getExpiry(),
                    "country" => $upstox_item->getCountry(),
                    "latency" => $upstox_item->getLatency(),
                    "description" => $upstox_item->getDescription(),
                    "currency" => $upstox_item->getCurrency(),
                    "weekly" => $upstox_item->getWeekly() ?? false,
                    "instrument_key" => $upstox_item->getInstrumentKey(),
                    "exchange_token" => $upstox_item->getExchangeToken(),
                    "trading_symbol" => $upstox_item->getTradingSymbol(),
                    "short_name" => $upstox_item->getShortName(),
                    "tick_size" => $upstox_item->getTickSize(),
                    "lot_size" => $upstox_item->getLotSize(),
                    "instrument_type" => $upstox_item->getInstrumentType(),
                    "freeze_quantity" => $upstox_item->getFreezeQuantity(),
                    "underlying_key" => $upstox_item->getUnderlyingKey(),
                    "underlying_type" => $upstox_item->getUnderlyingType(),
                    "underlying_symbol" => $upstox_item->getUnderlyingSymbol(),
                    "last_trading_date" => $upstox_item->getLastTradingDate(),
                    "strike_price" => $upstox_item->getStrikePrice(),
                    "price_quote_unit" => $upstox_item->getPriceQuoteUnit(),
                    "qty_multiplier" => $upstox_item->getQtyMultiplier(),
                    "minimum_lot" => $upstox_item->getMinimumLot(),
                    "start_time" => $upstox_item->getStartTime(),
                    "end_time" => $upstox_item->getEndTime(),
                    "week_days" => $upstox_item->getWeekDays(),
                    "general_denominator" => $upstox_item->getGeneralDenominator(),
                    "general_numerator" => $upstox_item->getGeneralNumerator(),
                    "price_numerator" => $upstox_item->getPriceNumerator(),
                    "price_denominator" => $upstox_item->getPriceDenominator(),
                    "mtf_enabled" => $upstox_item->getMtfEnabled(),
                    "mtf_bracket" => $upstox_item->getMtfBracket(),
                    "security_type" => $upstox_item->getSecurityType(),
                ];
                $final_upstx_data[] = $final_upstx_itm;

                $instrument_obj = Instruments::updateOrCreate(
                    [
                        'instrument_key' => $final_upstx_itm['instrument_key'],
                    ],
                    $final_upstx_itm
                );
            }
        }
        return $final_upstx_data;
    }
    public function profile(UpstoxService $upstox)
    {
        $api = new UserApi(
            $upstox->client(),
            $upstox->config()
        );

        try {
            $response = $api->getProfile('2.0');

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function syncUpstoxData()
    {
        $UpstoxService = new UpstoxService();
        $getPortfolio = $UpstoxService->getPortfolio();
        $req_log = [];
        if (isset($getPortfolio['positions'])) {
            $positions = $getPortfolio['positions'];
            if (is_array($positions) && !empty($positions)) {
                foreach ($positions as $position) {
                    $instrument_arr = collect(Instruments::where('instrument_key', (isset($position["instrument_token"]) ? $position["instrument_token"] : ''))->first())->toArray();
                    $new_data = [
                        'trd_symbol' => $instrument_arr['trading_symbol'] . (isset($instrument_arr['short_name']) && $instrument_arr['short_name'] != "" ? ' (' . $instrument_arr['short_name'] . ')' : ''),
                        'trd_symbol_key' => $instrument_arr['instrument_key'],
                        'trd_action' => 'Long',
                        'trd_date' => date('Y-m-d'),
                        'trd_exit_date' => null,
                        'trd_shares' => isset($position["quantity"]) ? $position["quantity"] : 0,
                        'trd_price' => isset($position["buy_price"]) ? $position["buy_price"] : 0,
                        'trd_exit_price' => isset($position["sell_price"]) ? $position["sell_price"] : '',
                        'trd_charges_amount' => 0,
                        'trd_lot' => isset($position["quantity"]) ? $position["quantity"] : 0,
                        'trd_type' => 'Cash',
                        'user_id' => Auth::id(),
                        // isset($position["exchange"]) ? $position["exchange"] : '',
                        // isset($position["multiplier"]) ? $position["multiplier"] : '',
                        // isset($position["value"]) ? $position["value"] : '',
                        // isset($position["pnl"]) ? $position["pnl"] : '',
                        // isset($position["product"]) ? $position["product"] : '',

                        // isset($position["average_price"]) ? $position["average_price"] : '',
                        // isset($position["buy_value"]) ? $position["buy_value"] : '',
                        // isset($position["overnight_quantity"]) ? $position["overnight_quantity"] : '',
                        // isset($position["day_buy_value"]) ? $position["day_buy_value"] : '',
                        // isset($position["day_buy_price"]) ? $position["day_buy_price"] : '',
                        // isset($position["overnight_buy_amount"]) ? $position["overnight_buy_amount"] : '',
                        // isset($position["overnight_buy_quantity"]) ? $position["overnight_buy_quantity"] : '',
                        // isset($position["day_buy_quantity"]) ? $position["day_buy_quantity"] : '',
                        // isset($position["day_sell_value"]) ? $position["day_sell_value"] : '',
                        // isset($position["day_sell_price"]) ? $position["day_sell_price"] : '',
                        // isset($position["overnight_sell_amount"]) ? $position["overnight_sell_amount"] : '',
                        // isset($position["overnight_sell_quantity"]) ? $position["overnight_sell_quantity"] : '',
                        // isset($position["day_sell_quantity"]) ? $position["day_sell_quantity"] : '',

                        // isset($position["last_price"]) ? $position["last_price"] : '',
                        // isset($position["unrealised"]) ? $position["unrealised"] : '',
                        // isset($position["realised"]) ? $position["realised"] : '',
                        // isset($position["sell_value"]) ? $position["sell_value"] : '',
                        // isset($position["tradingsymbol"]) ? $position["tradingsymbol"] : '',

                        // isset($position["close_price"]) ? $position["close_price"] : '',
                        // isset($position["buy_price"]) ? $position["buy_price"] : '',
                        // isset($position["sell_price"]) ? $position["sell_price"] : '',
                    ];
                    $new_row = Trade::create($new_data);

                    $req_log[] = $new_data;
                }
            }
        }
        return response()->json([
            "status" => 200,
            "data" => $req_log,
        ]);
    }

    public function integratePage(){
        $upstox_connected = false;
        $broker_init = collect(BrokerIntegration::where('user_id', Auth::id())->get())->toArray();
        if($broker_init && !empty($broker_init)){
            foreach($broker_init as $brokerinit){
                if($brokerinit['broker'] == 'upstox' && $brokerinit['access_token'] != ""){
                    $upstox_connected = true;
                }
            }
        }
        $upser = new UpstoxService();
        $portfolio = $upser->getPortfolio();
        return view('pages/settings/integrate', ['portfolio' => $portfolio, 'upstox_connected' => $upstox_connected]);
    }

    public function disconnectUpstox(){
        BrokerIntegration::where('user_id', Auth::id())->delete();
        return redirect()->intended('/integrate');
    }

}