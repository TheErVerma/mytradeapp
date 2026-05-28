<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Trade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


class TradeController extends Controller
{
    static public function getNetAmount()
    {
        return Trade::where('user_id', Auth::id())->where('trd_action', 'Buy')->sum('trd_price');
    }

    static public function getAll()
    {
        // $trades = Trade::orderBy('id', 'ASC')->get()->toArray();;
        $trades = Trade::where('user_id', Auth::id())->orderBy('id', 'ASC')->get()->toArray();
        ;
        return $trades;
    }

    public function addTrade(Request $request)
    {

        $validated = $request->validate([
            'trd_symbol' => 'required|string|max:255',
            'trd_date' => 'required|date',
            'trd_time' => 'required',

            'trd_shares' => 'nullable|integer',

            'trd_price' => 'required|numeric',
            // 'trd_type' => 'nullable|string',
            'trd_lot' => 'nullable|numeric',
        ]);


        $screenshots = [];
        $screenshots_log = [];
        if ($request->hasFile('trade_screenshots')) {
            $trade_screenshots = $request->file('trade_screenshots');
            if (!empty($trade_screenshots)) {
                foreach ($trade_screenshots as $file) {
                    if (!$file->isValid()) {
                        continue;
                    }

                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('screenshots', $filename, 'public');
                    $url = asset('storage/' . $path);

                    $screenshots[] = $url;
                    $screenshots_log[] = $url;
                }
            }
        }

        $trade = Trade::create([

            'trd_symbol' => $validated['trd_symbol'] ?? 0,
            'trd_action' => !empty($request->input('trd_action')) ? $request->input('trd_action') : 'Sell',

            'trd_date' => $validated['trd_date'] ?? 0,
            'trd_time' => $validated['trd_time'] ?? 0,

            'trd_shares' => $validated['trd_shares'] ?? 0,

            'trd_price' => $validated['trd_price'] ?? 0,
            'trd_lot' => $validated['trd_lot'] ?? 0,
            'trd_type' => !empty($validated['trd_type']) ? $validated['trd_type'] : 'f&o',
            'user_id' => Auth::id(),
            'trd_screenshots' => serialize($screenshots)
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Trade added successfully',
            'data' => $trade,
            'sss' => $screenshots_log
        ]);
    }

    public function deleteItem(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $trade = Trade::where('id', $request->input('id'))->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Trade deleted successfully',
            'data' => $trade
        ]);
    }

    public function getTrade($id)
    {
        $trade_obj = Trade::where('id', $id)->first();
        $trade = $trade_obj ? $trade_obj->toArray() : [];
        return $trade;
    }


    public static function summary($startingBalance = 500000)
    {
        $userId = Auth::id();
        $trades = Trade::where('user_id', $userId)
            ->orderBy('trd_date', 'asc')
            ->get();

        $positions = [];

        $realizedPnL = 0;
        $deployedCapital = 0;
        $unrealizedPnL = 0;

        /**
         * PROCESS TRADES
         */
        foreach ($trades as $trade) {

            $symbol = strtoupper($trade->trd_symbol);

            if (!isset($positions[$symbol])) {

                $positions[$symbol] = [
                    'qty' => 0,
                    'avg_price' => 0,
                ];
            }

            $qty = (float) $positions[$symbol]['qty'];
            $avg = (float) $positions[$symbol]['avg_price'];

            $shares = (float) $trade->trd_shares;
            $price = (float) $trade->trd_price;

            /**
             * BUY
             */
            if ($trade->trd_action == 'Buy') {

                $newQty = $qty + $shares;

                $newAvg = $newQty > 0 ?
                    (
                        ($qty * $avg)
                        +
                        ($shares * $price)
                    ) / $newQty : 0;

                $positions[$symbol]['qty'] = $newQty;

                $positions[$symbol]['avg_price'] = $newAvg;
            }

            /**
             * SELL
             */
            if ($trade->trd_action == 'Sell') {

                /**
                 * REALIZED PNL
                 */
                $profit =
                    ($price - $avg)
                    * $shares;

                $realizedPnL += $profit;

                /**
                 * REDUCE OPEN QTY
                 */
                $positions[$symbol]['qty']
                    = $qty - $shares;
            }
        }

        /**
         * CALCULATE OPEN POSITIONS
         */
        foreach ($positions as $symbol => $position) {

            $openQty = $position['qty'];

            if ($openQty <= 0) {
                continue;
            }

            $avgPrice = $position['avg_price'];

            /**
             * Replace with live market price API later
             */
            $currentPrice = self::marketPrice($symbol);

            /**
             * DEPLOYED CAPITAL
             */
            $deployedCapital +=
                $openQty * $avgPrice;

            /**
             * UNREALIZED PNL
             */
            $unrealizedPnL +=
                (
                    $currentPrice - $avgPrice
                ) * $openQty;
        }

        /**
         * AVAILABLE CASH
         */
        $availableCash =
            $startingBalance
            + $realizedPnL
            - $deployedCapital;

        /**
         * OPEN RISK %
         */
        $portfolioValue =
            $availableCash + $deployedCapital;

        $riskPercent = 0;

        if ($portfolioValue > 0) {

            $riskPercent =
                (
                    $deployedCapital
                    / $portfolioValue
                ) * 100;
        }

        return [

            'net_realized_pnl'
            => round($realizedPnL, 2),

            'unrealized_pnl'
            => round($unrealizedPnL, 2),

            'available_cash'
            => round($availableCash, 2),

            'deployed_capital'
            => round($deployedCapital, 2),

            'total_open_risk_percent'
            => round($riskPercent, 2),

            'total_open_risk_amount'
            => round($deployedCapital, 2),

            'starting_account_balance'
            => round($startingBalance, 2),

            'portfolio_value'
            => round(
                    $portfolioValue + $unrealizedPnL,
                    2
                ),

            'positions'
            => $positions
        ];
    }

    /**
     * TEMP MARKET PRICES
     */
    private static function marketPrice($symbol)
    {
        $prices = [

            'RELIANCE' => 2850,
            'TATA' => 1400,
            'AAPL' => 220,
            'TSLA' => 310,

        ];

        return $prices[$symbol] ?? 100;
    }
}
