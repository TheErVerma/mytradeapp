<?php

namespace App\Http\Controllers;

use App\Models\User;
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
use Illuminate\Support\Number;


class TradeController extends Controller
{
    static public function getNetAmount()
    {
        return Trade::where('user_id', Auth::id())->where('trd_action', 'Buy')->sum('trd_price');
    }

    static public function getAll()
    {
        // $trades = Trade::orderBy('id', 'ASC')->get()->toArray();;
        // $trades = Trade::where('user_id', Auth::id())->orderBy('id', 'ASC')->get()->toArray();
        $perPage = 10;
        $page = 1;

        $alltrd_obj = Trade::where('user_id', Auth::id())
            ->with('instrument')
            ->orderBy('id', 'DESC')
            ->paginate($perPage, ['*'], 'page', $page);

        // $counter = $alltrd_obj->total() - (($page - 1) * $perPage);
        $counter = 1 + (($page - 1) * $perPage);

        $alltrd_obj->through(function ($trade) use (&$counter) {
            $trade->counter = $counter++;
            return $trade;
        });
        // ->get()
        // ->toArray();
        // $all_trades = $alltrd_obj->items();

        // $current_page = $alltrd_obj->currentPage();
        // $total_pages = ceil($alltrd_obj->total() / $perPage);
        // $has_more = $alltrd_obj->hasMorePages();

        return $alltrd_obj;
    }

    public function addTrade(Request $request)
    {

        $validated = $request->validate([
            'trd_symbol' => 'required|string|max:255',
            'trd_symbol_key' => 'required|string|max:255',
            'trd_date' => 'required|date',
            // 'trd_time' => 'required',

            'trd_shares' => 'nullable|integer',

            'trd_price' => 'required',
            // 'trd_exit_price' => 'required',
            // 'trd_charges_amount' => 'required',
            'trd_type' => 'nullable|string',
            'trd_lot' => 'nullable|numeric',
            // 'trd_notes' => 'nullable|string',
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

        $trd_entr_price = (float) str_replace(',', '', ($validated['trd_price'] ?? 0));
        $trd_ext_price = (float) str_replace(',', '', ($request->input('trd_exit_price') ?? 0));
        $trd_chrgs_amount = (float) str_replace(',', '', ($request->input('trd_charges_amount') ?? 0));
        $trd_notes_val = $request->input('trd_notes');

        $trade = Trade::create([

            'trd_symbol' => $validated['trd_symbol'] ?? '',
            'trd_symbol_key' => $validated['trd_symbol_key'] ?? '',
            'trd_action' => !empty($request->input('trd_action')) ? $request->input('trd_action') : 'Long',

            'trd_date' => $validated['trd_date'] ?? 0,
            // 'trd_time' => $validated['trd_time'] ?? 0,

            'trd_shares' => $validated['trd_shares'] ?? 0,

            'trd_price' => $trd_entr_price,
            'trd_exit_price' => $trd_ext_price,
            'trd_charges_amount' => $trd_chrgs_amount,
            'trd_lot' => $validated['trd_lot'] ?? 0,
            'trd_type' => !empty($validated['trd_type']) ? $validated['trd_type'] : 'Cash',
            'notes' => !empty($trd_notes_val) ? $trd_notes_val : '',
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
        $trade_obj = Trade::where('id', $id)->with('instrument')->first();
        $trade = $trade_obj ? $trade_obj->toArray() : [];
        if (!empty($trade['trd_screenshots']) && $request->is('trade/*')) {
            $trade['trd_screenshots'] = unserialize($trade['trd_screenshots']);
        }

        if ($request->is('journal/*')) {
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
            'trd_shares' => 'nullable|integer',

            'trd_price' => 'required',
            'trd_exit_price' => 'required',
            'trd_type' => 'nullable|string',
            'trd_lot' => 'nullable|numeric',
            'trd_notes' => 'nullable|string',
            'trd_charges_amount' => 'nullable',
            'trd_symbol_key' => 'required|string|max:255',
        
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

        $trd_entr_price = (float) str_replace(',', '', ($validated['trd_price'] ?? 0));
        $trd_ext_price = (float) str_replace(',', '', ($validated['trd_exit_price'] ?? 0));
        $trd_chrgs_amount = (float) str_replace(',', '', ($validated['trd_charges_amount'] ?? 0));
        $trd_old_screenshots = $request->input('trd_old_screenshots');
        $trd_old_screenshots_arr = json_decode(base64_decode($trd_old_screenshots), true);
        if(!$trd_old_screenshots_arr){
            $trd_old_screenshots_arr = [];
        }
        
        $screenshots = array_merge($trd_old_screenshots_arr, $screenshots);

        $update = [
            'trd_symbol' => $validated['trd_symbol'] ?? $trade->trd_symbol,
            'trd_action' => !empty($request->input('trd_action')) ? $request->input('trd_action') : 'Long',

            'trd_date' => $validated['trd_date'] ?? $trade->trd_date,
            // 'trd_time' => $validated['trd_time'] ?? $trade->trd_time,

            'trd_shares' => $validated['trd_shares'] ?? $trade->trd_shares,

            'trd_price' => $trd_entr_price,
            'trd_exit_price' => $trd_ext_price,
            'trd_lot' => $validated['trd_lot'] ?? $trade->trd_lot,
            'trd_type' => !empty($validated['trd_type']) ? $validated['trd_type'] : 'Cash',
            'trd_screenshots' => serialize($screenshots),
            'notes' => $validated['trd_notes'] ?? $trade->notes,
            'trd_charges_amount' => $trd_chrgs_amount, 
            'trd_symbol_key' => $validated['trd_symbol_key'] ?? '',
            'user_id' => Auth::id(),
        ];
        $trade->update($update);

        return response()->json([
            'status' => 200,
            'message' => 'Trade updated successfully',
            'data' => $trade
        ]);

    }


    public static function summary()
    {
        $userId = Auth::id();

        $trades = Trade::where('user_id', $userId)
            ->with('instrument')
            ->orderBy('id', 'ASC')
            ->get();

        $totalPnL = 0;
        $winningTrades = 0;
        $losingTrades = 0;
        $breakevenTrades = 0;

        foreach ($trades as $trade) {

            if ($trade->trd_type == "F&O") {
                $qty = (float) ($trade->trd_lot) * ($trade->instrument['qty_multiplier'] <= 1 ? $trade->instrument['lot_size'] : 1);
            }
            if ($trade->trd_type == "Cash") {
                $qty = (float) ($trade->trd_shares);
            }
                
            $qty *= $trade->instrument['qty_multiplier'];
            $entry = (float) $trade->trd_price;
            $exit = (float) $trade->trd_exit_price;

            // Skip if trade is still open
            if (!$exit) {
                continue;
            }

            if ($trade->trd_action === 'Long') {

                $pnl = ((($exit - $entry) * $qty) - $trade->trd_charges_amount);

            } elseif ($trade->trd_action === 'Short') {

                $pnl = ((($entry - $exit) * $qty) - $trade->trd_charges_amount);

            } else {

                $pnl = 0;
            }

            $totalPnL += $pnl;

            if ($pnl > 0) {
                $winningTrades++;
            } elseif ($pnl < 0) {
                $losingTrades++;
            } else {
                $breakevenTrades++;
            }
        }

        return [
            'net_pnl' => round($totalPnL, 2),
            'winning_trades' => $winningTrades,
            'losing_trades' => $losingTrades,
            'breakeven_trades' => $breakevenTrades,
            'total_trades' => $winningTrades + $losingTrades + $breakevenTrades,
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
            // ->orderBy('trd_time')
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

                if (!$image->isValid())
                    continue;

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
        foreach ($screenshots as $screenshot) {
            if ($screenshot == $validated['screenshotURL']) {
                $screenshot = parse_url($screenshot, PHP_URL_PATH);
                $screenshot = ltrim(str_replace('/storage', '', $screenshot));
                if (Storage::disk('public')->exists($screenshot)) {
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

    public function updateNotes()
    {
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

    public function exportCsv()
    {
        $data = self::getAll();
        array_walk($data, function (&$row) {
            unset($row['trd_screenshots']);
        });

        $fileName = 'Trades_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // CSV Header Row
            fputcsv($file, array_keys($data[0]));

            // CSV Data Rows
            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, $fileName, $headers);
    }


    public function getPnL(Request $request, $period)
    {
        $user = Auth::user();
        $resp = ['status' => 400, 'message' => 'Invalid Request'];

        $startDate = date('Y-m-d', strtotime('today'));
        $endDate = date('Y-m-d', strtotime('+1 day'));

        if ($period != 'today') {
            $endDate = date('Y-m-d', strtotime('-1 day'));
        }

        if ($period == 'last_week') {
            $startDate = date('Y-m-d', strtotime('-1 week'));
        }

        if ($period == 'last_month') {
            $startDate = date('Y-m-d', strtotime('first day of last month'));
            $endDate = date('Y-m-d', strtotime('first day of this month'));
        }

        if ($period == 'last_3_month') {
            $startDate = date('Y-m-d', strtotime('first day of -3 months'));
            $endDate = date('Y-m-d', strtotime('first day of this month'));
        }

        if ($period == 'last_6_month') {
            $startDate = date('Y-m-d', strtotime('first day of -6 months'));
            $endDate = date('Y-m-d', strtotime('first day of this month'));
        }

        if ($period == 'last_year') {
            $startDate = date('Y-m-d', strtotime('first day of -1 year'));
            $endDate = date('Y-m-d', strtotime('first day of this month'));
        }

        if ($period == 'last_3_year') {
            $startDate = date('Y-m-d', strtotime('first day of -3 years'));
            $endDate = date('Y-m-d', strtotime('first day of this month'));
        }

        if ($period == 'last_5_year') {
            $startDate = date('Y-m-d', strtotime('first day of -5 years'));
            $endDate = date('Y-m-d', strtotime('first day of this month'));
        }

        if ($period == 'last_10_year') {
            $startDate = date('Y-m-d', strtotime('first day of -10 years'));
            $endDate = date('Y-m-d', strtotime('first day of this month'));
        }



        $trades = Trade::where('user_id', Auth::id())
            ->with('instrument')
            ->whereBetween('trd_date', [$startDate, $endDate])
            ->orderBy('id', 'ASC')
            ->get();
            
        // $trades = Trade::where('user_id', Auth::id())->whereBetween('trd_date', [$startDate, $endDate])->get();

        $total_trades = 0;
        $totalPnL = 0;
        $pnl = 0;
        foreach ($trades as $trade) {
            $total_trades++;

            if ($trade->trd_type == "F&O") {
                $qty = (float) ($trade->trd_lot) * ($trade->instrument['qty_multiplier'] <= 1 ? $trade->instrument['lot_size'] : 1);
            }
            if ($trade->trd_type == "Cash") {
                $qty = (float) ($trade->trd_shares);
            }

            $qty *= $trade->instrument['qty_multiplier'];
            $entry = (float) $trade->trd_price;
            $exit = (float) $trade->trd_exit_price;

            if (!$exit) {
                continue;
            }

            if ($trade->trd_action === 'Long') {
                $pnl = (($exit - $entry) * $qty) - $trade->trd_charges_amount;
            } elseif ($trade->trd_action === 'Short') {
                $pnl = (($entry - $exit) * $qty) - $trade->trd_charges_amount;
            } else {
                $pnl = 0;
            }

            $totalPnL += $pnl;
        }

        $currency = $user->default_country;
        $currency = $currency ? ($currency) : 'USD';
        $totalPnL_ = Number::currency($totalPnL, in: $currency);
        $resp = ['status' => 200, 'message' => $period, 'date_range' => [$startDate, $endDate], 'total_entries' => $total_trades, 'trade_num' => $totalPnL, 'trades' => $totalPnL_];

        return response()->json($resp);
    }


    public function generateLiveShareLink(Request $request)
    {
        $validated = $request->validate([
            'share_time_period' => 'required|string',
            '_token' => 'required|string',
        ]);

        $userObj = Auth::user();
        $user = User::findOrFail($userObj->id);

        $live_link_key = bin2hex(random_bytes(16));

        $time_period_stamp = strtotime('+' . $validated['share_time_period']);
        $new_share_link = [
            'key' => $live_link_key,
            'timeperiod' => $time_period_stamp,
            'period' => $validated['share_time_period'],
            'hash' => "{$request->root()}/liveshare/{$live_link_key}"
        ];

        $user->live_sharing = $new_share_link;

        $user->save();

        $resp = [
            'status' => 200,
            'message' => 'Success',
            'live_link' => $new_share_link['hash']
        ];

        return response()->json($resp);
    }


    public function liveShare(Request $request, $id)
    {

        $user = null;
        $all_trades = [];
        $sharing_data = '';
        $expiry_time = 0;
        $users = User::where('live_sharing', 'LIKE', "%{$id}%")->get();
        if (!empty($users)) {
            foreach ($users as $usr) {
                $user = $usr;
            }
        }

        if ($user != null) {
            $sharing_data = $user->live_sharing;
            $sharing_arr = json_decode($sharing_data, true);
            if (isset($sharing_arr['timeperiod'])) {
                $expiry_time = $sharing_arr['timeperiod'];
                if ($sharing_arr['timeperiod'] > time()) {
                    $all_trades = Trade::where('user_id', $user->id)->get()->toArray();
                } else {
                    $user = null;
                }
            }
        }

        return view('pages/liveShare', compact('all_trades', 'user', 'expiry_time'));
    }

    public function filterJournalItems(Request $request)
    {
        $action = $request->input('trd_action');
        $search = $request->input('trd_search');
        $dateFrom = $request->input('trd_dateFrom');
        $dateTo = $request->input('trd_dateTo');
        $perPage = (int) $request->input('trd_perPage', 20);
        $page = (int) $request->input('trd_page', 1);

        $query = Trade::query()
            ->where('user_id', Auth::id())
            ->with('instrument')
            ->when($action, function ($query, $action) {
                $query->where('trd_action', $action);
            })
            ->when($search, function ($query, $search) {
                $search = strtolower($search);

                $query->where(function ($query) use ($search) {
                    $query->whereRaw(
                        'LOWER(trd_symbol) LIKE ?',
                        ["%{$search}%"]
                    )
                        ->orWhereHas('instrument', function ($query) use ($search) {
                            $query->whereRaw(
                                'LOWER(name) LIKE ?',
                                ["%{$search}%"]
                            )
                                ->orWhereRaw(
                                    'LOWER(trading_symbol) LIKE ?',
                                    ["%{$search}%"]
                                )
                                ->orWhereRaw(
                                    'LOWER(short_name) LIKE ?',
                                    ["%{$search}%"]
                                );
                        });
                });
            })
            ->when($dateFrom, function ($query, $dateFrom) {
                $query->whereDate('trd_date', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query, $dateTo) {
                $query->whereDate('trd_date', '<=', $dateTo);
            })
            ->orderBy('id', 'ASC');

        $alltrd_obj = $query
            ->paginate($perPage, ['*'], 'page', $page);

        // $counter = $alltrd_obj->total() - (($page - 1) * $perPage);
        $counter = 1 + (($page - 1) * $perPage);

        $alltrd_obj->through(function ($trade) use (&$counter) {
            $trade->counter = $counter++;
            return $trade;
        });

        $all_trades = collect($alltrd_obj->items())->toArray();

        $current_page = $alltrd_obj->currentPage();
        $total_pages = ceil($alltrd_obj->total() / $perPage);
        $has_more = $alltrd_obj->hasMorePages();

        $user = Auth::user();
        $currency = $user->default_country;
        $currency = $currency ? ($currency) : 'INR';

        return response()->json([
            'status' => 200,
            'html' => view('components.journalRows', ['all_trades' => $all_trades, 'currency' => $currency])->render(),
            'trades' => $all_trades,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'has_more' => $has_more,
        ]);
    }
}
