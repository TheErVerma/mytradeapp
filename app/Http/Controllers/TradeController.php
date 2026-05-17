<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Trade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;



class TradeController extends Controller
{
    static public function getAll(){
        $trades = Trade::orderBy('id', 'ASC')->get()->toArray();;
        return $trades;
    }

    public function addTrade(Request $request)
    {
        $validated = $request->validate([
            'trd_market_name' => 'required|string|max:255',
            'trd_symbol' => 'required|string|max:255',
            'trd_action' => 'required|string|max:50',

            'trd_date' => 'required|date',
            'trd_time' => 'required',

            'trd_shares' => 'required|integer',

            'trd_price' => 'required|numeric',
            'trd_commissions' => 'nullable|numeric',
            'trd_fees' => 'nullable|numeric',
        ]);

        $trade = Trade::create([
            'trd_market_name' => $validated['trd_market_name'],
            'trd_symbol' => $validated['trd_symbol'],
            'trd_action' => $validated['trd_action'],

            'trd_date' => $validated['trd_date'],
            'trd_time' => $validated['trd_time'],

            'trd_shares' => $validated['trd_shares'],

            'trd_price' => $validated['trd_price'],
            'trd_commissions' => $validated['trd_commissions'] ?? 0,
            'trd_fees' => $validated['trd_fees'] ?? 0,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Trade added successfully',
            'data' => $trade,
        ]);
    }
}
