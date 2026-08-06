<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Stocks;
use Illuminate\Http\Request;

class StocksController extends Controller
{

    public function add(Request $request)
    {
        $validated = $request->validate([
            'stck_symbol'            => ['required', 'string', 'max:20'],
            'stck_title'             => ['required', 'string', 'max:255'],
            'stck_exchange'          => ['required', 'in:NSE,BSE'],
            'stck_instrument_type'   => ['required', 'in:EQ,ETF,FUT,CE,PE,INDEX'],
            'stck_series'            => ['nullable', 'string', 'max:10'],
            'stck_isin'              => ['nullable', 'string', 'size:12'],
            'stck_sector'            => ['nullable', 'string', 'max:100'],
            'stck_industry'          => ['nullable', 'string', 'max:100'],
            'stck_lot_size'          => ['required', 'integer', 'min:1'],
            'stck_tick_size'         => ['required', 'numeric', 'min:0'],
            'stck_face_value'        => ['nullable', 'numeric', 'min:0'],
            'stck_description'       => ['nullable', 'string'],
            'stck_logo'              => ['nullable', 'url', 'max:255'],
            'stck_website'           => ['nullable', 'url', 'max:255'],
            'stck_is_active'         => ['required', 'boolean'],
            'stck_sort_order'        => ['nullable', 'integer', 'min:0'],
        ]);

        $stock = Stocks::create([
            'symbol' => $validated['stck_symbol'],
            'title' => $validated['stck_title'],
            'exchange' => $validated['stck_exchange'],
            'instrument_type' => $validated['stck_instrument_type'],
            'series' => $validated['stck_series'],
            'isin' => $validated['stck_isin'],
            'sector' => $validated['stck_sector'],
            'industry' => $validated['stck_industry'],
            'lot_size' => $validated['stck_lot_size'],
            'tick_size' => $validated['stck_tick_size'],
            'face_value' => $validated['stck_face_value'],
            'description' => $validated['stck_description'],
            'logo' => $validated['stck_logo'],
            'website' => $validated['stck_website'],
            'is_active' => $validated['stck_is_active'],
            'sort_order' => $validated['stck_sort_order'],
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Trade added successfully',
            'data' => $stock,
        ]);
    }


}
