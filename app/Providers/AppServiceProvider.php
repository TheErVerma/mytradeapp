<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Auth;

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
            if ($user) {
                $total_trades = TradeController::getAll();
                $portfolioSummry = $user && $user->initial_balance ? TradeController::summary($user->initial_balance ? $user->initial_balance : 1) : [];
                $currency = $user->default_country;
                $currency = $currency ? ($currency) : 'USD';
                $view->with('trades', $total_trades);
                $view->with('total_trades', count($total_trades));
                $view->with('portfolioSummry', $portfolioSummry);
                $view->with('currency', $currency);
            }
        });
        // View::composer('pages.*', function ($view) {
        //     dd($view->getName());
        // });
    }
}
