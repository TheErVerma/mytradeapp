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
use Illuminate\Support\Facades\Log;


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
            'trd_type' => 'nullable|string',
            'trd_lot' => 'nullable|numeric',
            'trd_notes' => 'nullable|string',
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
            'trd_type' => !empty($validated['trd_type']) ? $validated['trd_type'] : 'F&O',
            'notes' => !empty($validated['trd_notes']) ? $validated['trd_notes'] : '',
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

    public function getTrade(Request $request, $id)
    {
        $trade_obj = Trade::where('id', $id)->first();
        $trade = $trade_obj ? $trade_obj->toArray() : [];
        if (!empty($trade['trd_screenshots']) && $request->is('trade/*')) {
            $trade['trd_screenshots'] = unserialize($trade['trd_screenshots']);
        }
        if($request->is('journal/*')) {
            return view('pages.single.trade', ['trade' => $trade]);
        }
        return $trade;
    }

    public function editTrade(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'trd_symbol' => 'required|string|max:255',
            'trd_date' => 'required|date',
            'trd_time' => 'required',

            'trd_shares' => 'nullable|integer',

            'trd_price' => 'required|numeric',
            'trd_type' => 'nullable|string',
            'trd_lot' => 'nullable|numeric',
            'trd_notes' => 'nullable|string',
        ]);

        $trade = Trade::where('id', '=', $validated['id'], false)->first();

        if (!$trade) {
            return response()->json([
                'status' => 404,
                'message' => 'Trade not found',
                'data' => null
            ]);
        }

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
        $update = [
            'trd_symbol' => $validated['trd_symbol'] ?? $trade->trd_symbol,
            'trd_action' => $validated['trd_action'] ?? $trade->trd_action,

            'trd_date' => $validated['trd_date'] ?? $trade->trd_date,
            'trd_time' => $validated['trd_time'] ?? $trade->trd_time,

            'trd_shares' => $validated['trd_shares'] ?? $trade->trd_shares,

            'trd_price' => $validated['trd_price'] ?? $trade->trd_price,
            'trd_lot' => $validated['trd_lot'] ?? $trade->trd_lot,
            'trd_type' => $validated['trd_type'] ?? $trade->trd_type,
            'trd_screenshots' => !empty($screenshots) ? serialize($screenshots) : $trade->trd_screenshots,
            'notes' => $validated['trd_notes'] ?? $trade->notes,
        ];
        $trade->update( $update );

        return response()->json([
            'status' => 200,
            'message' => 'Trade updated successfully',
            'data' => $trade
        ]);

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
            $shares = $shares == 0 ? (float) $trade->trd_lot : $shares;
            $price = (float) $trade->trd_price;

            Log::debug('Shares: ' . $shares);
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


    public static function getTradingStats()
    {
        $userId = Auth::id();

        $trades = Trade::where('user_id', $userId)
            ->orderBy('trd_date')
            ->orderBy('trd_time')
            ->get();

        $groupedTrades = $trades->groupBy(function ($trade) {
            return $trade->trd_symbol . '_' . $trade->trd_lot;
        });

        $totalPnL = 0;

        $winTrades = 0;
        $lossTrades = 0;

        $grossProfit = 0;
        $grossLoss = 0;

        foreach ($groupedTrades as $group) {

            $buyTrades = $group->where('trd_action', 'Buy');

            $sellTrades = $group->where('trd_action', 'Sell');

            if ($buyTrades->isEmpty() || $sellTrades->isEmpty()) {
                continue;
            }

            $buyValue = $buyTrades->sum(function ($trade) {
                return $trade->trd_price * $trade->trd_shares;
            });

            $sellValue = $sellTrades->sum(function ($trade) {
                return $trade->trd_price * $trade->trd_shares;
            });

            $pnl = $sellValue - $buyValue;

            $totalPnL += $pnl;

            if ($pnl > 0) {

                $winTrades++;

                $grossProfit += $pnl;

            } elseif ($pnl < 0) {

                $lossTrades++;

                $grossLoss += abs($pnl);
            }
        }

        $totalTrades = $winTrades + $lossTrades;

        $winRate = $totalTrades > 0
            ? ($winTrades / $totalTrades) * 100
            : 0;

        $profitFactor = $grossLoss > 0
            ? $grossProfit / $grossLoss
            : 0;

        $expectancy = $totalTrades > 0
            ? $totalPnL / $totalTrades
            : 0;

        $avgWin = $winTrades > 0
            ? $grossProfit / $winTrades
            : 0;

        $avgLoss = $lossTrades > 0
            ? $grossLoss / $lossTrades
            : 0;

        $avgWinLossRatio = $avgLoss > 0
            ? $avgWin / $avgLoss
            : 0;

        return [
            'net_realised_pnl' => round($totalPnL, 2),

            'total_trades' => $totalTrades,

            'win_rate' => round($winRate, 2),

            'won_trades' => $winTrades,

            'lost_trades' => $lossTrades,

            'profit_factor' => round($profitFactor, 2),

            'expectancy' => round($expectancy, 2),

            'avg_win' => round($avgWin, 2),

            'avg_loss' => round($avgLoss, 2),

            'avg_win_loss_ratio' => round($avgWinLossRatio, 2),
        ];
    }

    public function uploadScreenshots(Request $request)
    {

        $validated = $request->validate([
            'trade_id' => 'required|integer|exists:trades,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'existing_images' => 'nullable|array',
            'existing_images.*' => 'string',
        ]);

        $trade = Trade::where('id', $validated['trade_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $existingImages = $validated['existing_images'] ?? [];

        $dbImages = [];

        if (!empty($trade->trd_screenshots)) {
            $dbImages = @unserialize($trade->trd_screenshots);
            if (!is_array($dbImages)) {
                $dbImages = [];
            }
        }

        $existingImages = array_merge($dbImages, $existingImages);

        $newPaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                if (!$image->isValid()) continue;

                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('screenshots', $imageName, 'public');

                $newPaths[] = asset('storage/' . $path);
            }
        }

        $finalImages = array_values(array_unique(array_merge($existingImages, $newPaths)));

        $update = [
            'trd_screenshots' => serialize($finalImages),
        ];

        $trade->update($update);

        return response()->json([
            'success' => true,
            'trade_id' => $trade->id,
            'images' => $finalImages,
        ]);
    }

    public function deleteScreenshot(Request $request)
    {

        $validated = $request->validate([
            'trade_id' => 'required|integer',
            'screenshotURL' => 'required|string',
        ]);

        $trade = Trade::where('id', $validated['trade_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $screenshots = unserialize($trade->trd_screenshots);
        $updatedScreenshots = [];
        foreach($screenshots as $screenshot) {
            if( $screenshot == $validated['screenshotURL'] ) {
                $screenshot = parse_url( $screenshot, PHP_URL_PATH );
                $screenshot = ltrim(str_replace('/storage', '', $screenshot));
                if( Storage::disk('public')->exists($screenshot) ) {
                    Storage::disk('public')->delete($screenshot);
                }
            } else {
                $updatedScreenshots[] = $screenshot;
            }
        }

        $update = [
            'trd_screenshots' => serialize($updatedScreenshots),
        ];
        $trade->update($update);

        return response()->json([
            'success' => true,
            $updatedScreenshots
        ]);
    }

    public function updateNotes() {
        $validated = request()->validate([
            'trade_id' => 'required|integer',
            'journal_notes' => 'required|string',
        ]);

        $trade = Trade::where('id', $validated['trade_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $update = [
            'notes' => $validated['journal_notes'],
        ];
        $trade->update($update);

        return response()->json([
            'success' => true
        ]);
    }
}
