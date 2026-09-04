<?php

namespace App\Services;

class TradeService
{
    static public function getJournalColumns()
    {
        return [

            [
                "label" => "S.No.",
                "id" => "s_no",
                "desc" => "The serial number of the trade."
            ],

            [
                "label" => "Instrument",
                "id" => "instrument",
                "desc" => "The stock, security, or financial instrument traded."
            ],

            [
                "label" => "Type",
                "id" => "type",
                "desc" => "The type of instrument, such as Equity, Future, or Option."
            ],

            [
                "label" => "Date",
                "id" => "date",
                "desc" => "The date on which the trade was executed."
            ],

            // [
            //     "label" => "Shares",
            //     "id" => "shares",
            //     "desc" => "The number of shares traded."
            // ],

            // [
            //     "label" => "Lot",
            //     "id" => "lot",
            //     "desc" => "The number of lots involved in the trade."
            // ],

            [
                "label" => "QTY",
                "id" => "qty",
                "desc" => "The total quantity of units traded."
            ],

            [
                "label" => "Product",
                "id" => "product",
                "desc" => "The product or order type used for the trade."
            ],

            [
                "label" => "Entry Price",
                "id" => "entry_price",
                "desc" => "The price at which the trade was entered."
            ],

            [
                "label" => "Exit Price",
                "id" => "exit_price",
                "desc" => "The price at which the trade was exited."
            ],

            [
                "label" => "P&L",
                "id" => "p_l",
                "desc" => "The profit or loss generated from the trade."
            ],

        ];
    }
}