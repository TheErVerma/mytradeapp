<?php

namespace App\Providers;

use App\Models\Trade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UpstoxController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        View::composer('pages.*', function ($view) {
            if (!Auth::check()) {
                // Default values for guests
                $view->with([
                    'trades' => [],
                    'total_trades' => 0,
                    'portfolioSummry' => [],
                    'currency' => 'USD',
                ]);
                return;
            }
            $user = Auth::user();


            $upstox_data = UpstoxController::fetchData('TATA');


            $dailyPnl = Trade::where('user_id', Auth::id())
                ->join('instruments', 'instruments.instrument_key', '=', 'trades.trd_symbol_key')
                ->whereNotNull('trades.trd_exit_price')
                ->selectRaw("
                    DATE(trades.trd_date) AS date,

                    SUM(
                        CASE
                            WHEN trades.trd_action = 'Long' THEN
                                (
                                    (
                                        trades.trd_exit_price - trades.trd_price
                                    )
                                    *
                                    (
                                        CASE
                                            WHEN trades.trd_type = 'F&O' THEN
                                                trades.trd_lot *
                                                CASE
                                                    WHEN instruments.qty_multiplier <= 1
                                                        THEN instruments.lot_size
                                                    ELSE 1
                                                END
                                            WHEN trades.trd_type = 'Cash' THEN
                                                trades.trd_shares
                                            ELSE 0
                                        END
                                        * instruments.qty_multiplier
                                    )
                                )
                                - trades.trd_charges_amount

                            WHEN trades.trd_action = 'Short' THEN
                                (
                                    (
                                        trades.trd_price - trades.trd_exit_price
                                    )
                                    *
                                    (
                                        CASE
                                            WHEN trades.trd_type = 'F&O' THEN
                                                trades.trd_lot *
                                                CASE
                                                    WHEN instruments.qty_multiplier <= 1
                                                        THEN instruments.lot_size
                                                    ELSE 1
                                                END
                                            WHEN trades.trd_type = 'Cash' THEN
                                                trades.trd_shares
                                            ELSE 0
                                        END
                                        * instruments.qty_multiplier
                                    )
                                )
                                - trades.trd_charges_amount

                            ELSE 0
                        END
                    ) AS pnl
                ")
                ->groupByRaw('DATE(trades.trd_date)')
                ->orderBy('date', 'ASC')
                ->get()
                ->map(function ($trade) {
                    return [
                        'date' => $trade->date,
                        'pnl'  => (float) $trade->pnl,
                    ];
                })
                ->values()
                ->toArray();

            $all_trades_count = Trade::where('user_id', Auth::id())->count();
            if ($user) {
                $total_trades = TradeController::getAll();
                $portfolioSummry = TradeController::summary();
                $TradeController = new TradeController();
                $all_matrics = $TradeController->getTradeMetrics($total_trades);
                $currency = $user->default_country;
                $currency = $currency ? ($currency) : 'USD';
                $view->with('user', $user);
                $view->with('trades', $total_trades);
                $view->with('total_trades', count($total_trades));
                $view->with('portfolioSummry', $portfolioSummry);
                $view->with('all_trades_count', $all_trades_count);
                $view->with('all_matrics', $all_matrics);

                $view->with('currency', $currency);
                $view->with('upstox', $upstox_data);
                $view->with('headMapData', $dailyPnl);
                // $view->with('theme', $user->);
            }
        });
        // View::composer('pages.*', function ($view) {
        //     dd($view->getName());
        // });
    }



    private function fetchLiveData(){

    }
}
