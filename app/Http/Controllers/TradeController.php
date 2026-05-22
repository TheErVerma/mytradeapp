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
}
