<?php

namespace App\Http\Controllers;

use App\Models\Instruments;
use DB;
use Illuminate\Http\Request;
use App\Services\UpstoxService;
use Upstox\Client\Api\UserApi;
use Upstox\Client\Api\InstrumentsApi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpstoxController extends Controller
{

    static public function fetchData($search = 'a', $type = null, $page = 1)
    {
        // $data = Cache::remember(
        //     'upstox_api_data_'.$page,
        //     now()->addSecond(1),
        //     function () use ($search, $type, $page) {
        // $upstox = app(UpstoxService::class);

        // $instrumentInstance = new InstrumentsApi(
        //     $upstox->client(),
        //     $upstox->config()
        // );

        // $resp = $instrumentInstance->searchInstrument(
        //     $search,
        //     null,
        //     $type,
        //     null,
        //     null,
        //     null,
        //     $page,
        //     20
        // );

        // $upstox_data = $resp->getData();
        // return self::refineUpstoxData($upstox_data);
        return false;
        //     }
        // );

        // return $data;
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
            ->orderByRaw("
                CASE
                    WHEN segment LIKE '%_FO' THEN 1
                    WHEN segment LIKE '%_EQ' THEN 2
                    ELSE 3
                END
            ")
            ->orderBy('id', 'asc');

        Log::debug($instruments_qry->toSql());
        $instruments = $instruments_qry->paginate(10);

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
}