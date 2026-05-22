<?php

use App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\post;



Route::group(['middleware' => ['auth']], function () {
    /**
     * Logout Path
     **/
    Route::get('/logout', [UserController::class, 'logout']);




    /***********************
     * Pages Start
     **/
    Route::get('/', function () {
        $apiObj = new ApiController();
        return view('pages/home', compact('apiObj'));
    })->name('home');

    Route::get('/profile', function () {
        return view('pages/settings/profile');
    })->name('Edit Profile');

    Route::get('/journal', function () {
        $all_trades = TradeController::getAll();
        return view('pages/trade-journal', compact('all_trades'));
    })->name('journal');

    Route::get('/analytics', function () {
        return view('pages/analytics');
    })->name('journal');

    Route::get('/settings', function () {
        return view('pages/settings');
    })->name('settings');

    Route::get('/help', function () {
        return view('pages/help');
    })->name('help');
    /**
     * Pages End
     ***********************/




    /***********************
     * APIs Start
     */
    Route::post('/trade', [TradeController::class, 'addTrade']);
    Route::delete('/trade', [TradeController::class, 'deleteItem']);
    /**
     * APIs End
     **********************/





    /**
     * Single Pages
     **/
    Route::get('/trade/{id}', [TradeController::class, 'getTrade']);
    Route::get('/journal/{id}', function ($id) {
        $TradeController = new TradeController();
        $trade = $TradeController->getTrade($id);
        return view('pages/single/trade', ['trade' => $trade]);
    });

});



Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('pages/login');
    })->name('login');
    Route::get('/register', function () {
        return view('pages/register');
    })->name('register');
});



