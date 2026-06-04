<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $apiObj = new ApiController();
        $net_amount = TradeController::getNetAmount();

        $tradingStats = TradeController::getTradingStats();
        return view('pages/home', compact('apiObj', 'net_amount', 'tradingStats'));
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
        return view('pages/settings/settings');
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
    Route::post('/user/{id}/savesettings', [UserController::class, 'saveSettings']);
    Route::post('/user/{id}/saveprofile', [UserController::class, 'saveProfile']);
    Route::post('/trade', [TradeController::class, 'addTrade']);
    Route::delete('/trade', [TradeController::class, 'deleteItem']);
    Route::put('/trade', [TradeController::class, 'editTrade']);
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


    /***********************
     * Two-Factor Authentication (2FA) Management — requires authenticated session
     * These endpoints are called from the Settings page.
     **/
    Route::post('/user/two-factor/enable',           [TwoFactorController::class, 'enable']);
    Route::get('/user/two-factor/setup',             [TwoFactorController::class, 'setup']);
    Route::post('/user/two-factor/confirm',          [TwoFactorController::class, 'confirm']);
    Route::post('/user/two-factor/disable',          [TwoFactorController::class, 'disable']);
    Route::post('/user/two-factor/recovery-codes',   [TwoFactorController::class, 'regenerateCodes']);
    /**
     * 2FA Management End
     **********************/

});



Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/forget-password', [UserController::class, 'forgetPassword']);
Route::post('/verify-otp', [UserController::class, 'verifyOTP']);
Route::post('/reset-password', [UserController::class, 'resetPassword']);
Route::post('/reset-all-data', [UserController::class, 'resetAllData']);


/***********************
 * Two-Factor Challenge — for users who are mid-login (not yet fully authenticated)
 **/
Route::get('/two-factor-authenticate',  [TwoFactorController::class, 'showChallenge'])->name('two-factor.challenge');
Route::post('/two-factor-authenticate', [TwoFactorController::class, 'challenge']);
/**
 * 2FA Challenge End
 **********************/


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('pages/login');
    })->name('login');
    Route::get('/register', function () {
        return view('pages/register');
    })->name('register');
    Route::get('/forget-password', function () {
        return view('pages/forget-password');
    })->name('forget_password');
});
