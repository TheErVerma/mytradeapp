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
            $user = Auth::user();
            $total_trades = TradeController::getAll();
            $view->with('total_trades', count($total_trades));
        });
        // View::composer('pages.*', function ($view) {
        //     dd($view->getName());
        // });
    }
}
