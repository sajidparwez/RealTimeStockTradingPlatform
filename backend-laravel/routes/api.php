<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TradeController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\TransactionController;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('/profile', fn (Request $request) => $request->user());
    // Route::post('/trade', [TradeController::class, 'store']);
    Route::get('/wallet', [WalletController::class, 'getBalance']);
    // Route::get('/wallet', fn() => auth()->user()->only(['id', 'wallet_balance']));

    Route::post('/wallet/deposit', [WalletController::class, 'deposit']);
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw']);
    Route::post('/trade', [TradeController::class, 'placeTrade']);

    Route::get('/transactions', [TransactionController::class, 'index']);
    
});
