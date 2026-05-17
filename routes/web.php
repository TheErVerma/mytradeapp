<?php

use App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TradeController;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\post;



Route::group(['middleware' => ['auth']], function () {
    // Logout Path
    Route::get('/logout', [UserController::class, 'logout']);

    // Home Page
    Route::get('/', function () {
        // return Redirect::to('/trade-journal');
        $user = Auth::user();
        $apiObj = new ApiController();
        return view('home', compact('user', 'apiObj'));
    })->name('home');


    // Edit Profile
    Route::get('/profile', function () {
        $user = Auth::user();
        return view('settings/profile', compact('user'));
    })->name('Edit Profile');

    Route::post('/user/{id}/save_profile/', [UserController::class, 'saveProfile']);
    
    
    Route::post('/trade', [TradeController::class, 'addTrade']);
    Route::get('/trade-journal', function(){
        $user = Auth::user();
        $all_trades = TradeController::getAll();
        return view('trade-journal', compact('user', 'all_trades'));
    });

});



Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');
    Route::get('/register', function () {
        return view('register');
    })->name('register');
});



