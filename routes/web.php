<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelperController;
use App\Http\Controllers\UpstoxController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\TwoFactorController;
use App\Models\BrokerIntegration;
use App\Services\UpstoxService;
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

    Route::get('/journal/{hash}', function ($hash) {
        $all_trades = TradeController::getAll();
        return view('pages/trade-journal', compact('all_trades', 'hash'));
    })->name('journal');

    Route::get('/analytics', function () {
        return view('pages/analytics');
    })->name('journal');
    Route::get('/stocks', function () {
        return view('pages/stocks');
    })->name('journal');

    Route::get('/settings', function () {
        return view('pages/settings/settings');
    })->name('settings');
    Route::get('/integrate', [UpstoxController::class, 'integratePage'])->name('integrate');
    Route::get('/disconnect-upstox', [UpstoxController::class, 'disconnectUpstox']);
    /**
     * Pages End
     ***********************/




    /**
     * Upstx OAuth Start
     */
    // Route::get('/connect-upstox', [
    //     UpstoxController::class,
    //     'connect'
    // ]);

    // Route::get('/integrate-callback', [
    //     UpstoxController::class,
    //     'callback'
    // ])->name('upstox.callback');

    // Route::post('/integrations/upstox/import', [
    //     UpstoxController::class,
    //     'importTrades'
    // ])->name('upstox.import');

    // Route::delete('/integrations/upstox', [
    //     UpstoxController::class,
    //     'disconnect'
    // ])->name('upstox.disconnect');
    /**
     * Upstx OAuth End
     */


    /***********************
     * APIs Start
     */
    Route::post('/user/{id}/savesettings', [UserController::class, 'saveSettings']);
    Route::post('/user/{id}/saveprofile', [UserController::class, 'saveProfile']);
    Route::post('/user/{id}/save-theme', [UserController::class, 'saveTheme']);
    Route::post('/trade', [TradeController::class, 'addTrade']);
    Route::post('/generate-livesharelink', [TradeController::class, 'generateLiveShareLink']);
    Route::post('/stop-liveshare', [TradeController::class, 'stopLiveShare']);
    Route::post('/filter-journal-items', [TradeController::class, 'filterJournalItems']);
    Route::delete('/trade', [TradeController::class, 'deleteItem']);
    Route::delete('/trades', [TradeController::class, 'deleteItems']);
    Route::put('/trade', [TradeController::class, 'editTrade']);
    Route::post('/upload-image', [TradeController::class, 'uploadScreenshots']);
    Route::delete('/delete-image', [TradeController::class, 'deleteScreenshot']);
    Route::delete('/save-notes', [TradeController::class, 'updateNotes']);
    Route::get('/exporttrades', [TradeController::class, 'exportCsv']);
    Route::post('/save-customized-analytics', [TradeController::class, 'saveCstmAnalytics']);
    Route::post('/loadmorestocks', [UpstoxController::class, 'loadMoreData']);
    Route::post('/sync-upstox-data', [UpstoxController::class, 'syncUpstoxData']);
    /**
     * APIs End
     **********************/


    /**
     * Single Pages
     **/
    Route::post('/mainsummery/{period}', [TradeController::class, 'getMainSummery']);
    Route::post('/pnl/{period}', [TradeController::class, 'getPnL']);
    Route::get('/trade/{id}', [TradeController::class, 'getTrade']);
    Route::get('/journal/{id}', [TradeController::class, 'getTrade']);


    /***********************
     * Two-Factor Authentication (2FA) Management — requires authenticated session
     * These endpoints are called from the Settings page.
     **/
    Route::post('/user/two-factor/enable', [TwoFactorController::class, 'enable']);
    Route::get('/user/two-factor/setup', [TwoFactorController::class, 'setup']);
    Route::post('/user/two-factor/confirm', [TwoFactorController::class, 'confirm']);
    Route::post('/user/two-factor/disable', [TwoFactorController::class, 'disable']);
    Route::post('/user/two-factor/recovery-codes', [TwoFactorController::class, 'regenerateCodes']);
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


Route::get('/connect-upstox', [
    UpstoxController::class,
    'connect'
]);

Route::get('/integrate-callback', [
    UpstoxController::class,
    'callback'
])->name('upstox.callback');

/***********************
 * Two-Factor Challenge — for users who are mid-login (not yet fully authenticated)
 **/
Route::get('/two-factor-authenticate', [TwoFactorController::class, 'showChallenge'])->name('two-factor.challenge');
Route::post('/two-factor-authenticate', [TwoFactorController::class, 'challenge']);
/**
 * 2FA Challenge End
 **********************/

Route::get('/help', function () {
    return view('pages/help');
})->name('help');

Route::get('/liveshare/{id}', [TradeController::class, 'liveShare']);

Route::middleware('guest')->group(function () {
    Route::post('/filter-journal-items-public', [TradeController::class, 'filterJournalItemsPublic']);
    Route::get('/login', function () {
        return view('pages/login');
    })->name('login');
    Route::get('/register', function () {
        return view('pages/register');
    })->name('register');
    Route::get('/forget-password', function () {
        return view('pages/forget-password');
    })->name('forget_password');
    Route::get('/verify-email', function () {
        return view('pages/verify-email');
    })->name('verify_email');
    Route::get('/set-password', function () {
        return view('pages/set-password');
    })->name('set_password');
});
