<?php

namespace App\Http\Controllers;

abstract class Controller
{
    static public function preDefinedSymbols(){
        $symbols = [
            'aapl' => "Apple",
            'msft' => "Microsoft Corporation",
            'nvda' => "NVIDIA Corporation",
            // 'amzn' => "Amazon.com, Inc.",
            // 'meta' => 'Meta Platforms, Inc.'
        ];
        return $symbols;
    }
}
