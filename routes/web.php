<?php

use App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\post;



Route::group(['middleware' => ['auth']], function () {
    // Logout Path
    Route::get('/logout', [UserController::class, 'logout']);

    // Home Page
    Route::get('/', function () {
        $user = Auth::user();
        $apiObj = new ApiController();
        $symbols = Controller::preDefinedSymbols();
        return view('home', compact('user', 'symbols', 'apiObj'));
    })->name('home');

    // About Page
    Route::get('/about', function () {
        $user = Auth::user();
        return view('about', compact('user'));
    })->name('about');



    // Single Symbol Info
    Route::get('/symbols/{symbol}', function ($symbol) {
        $user = Auth::user();
        $allowed = array_keys(Controller::preDefinedSymbols());
        if (!in_array(strtolower($symbol), $allowed)) {
            return Redirect::to('/');
        }
        $stockdata = ApiController::fetchStockData($symbol);
        return view('single/symbol', compact('user', 'symbol', 'stockdata'));
    });

    // Redirect Symbols To Home
    Route::get('/symbols', function () {
        return Redirect::to('/');
    });


    // Edit Profile
    Route::get('/profile', function () {
        $user = Auth::user();
        return view('settings/profile', compact('user'));
    })->name('Edit Profile');

    Route::post('/user/{id}/save_profile/', [UserController::class, 'saveProfile']);
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



