<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\ProcessTrade;

class TradeController extends Controller
{

   public function store(Request $request)
    {
        $request->validate([
            'symbol' => 'required|string',
            'type' => 'required|in:buy,sell',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Dispatch to queue
        TradeJob::dispatch([
            'user_id' => auth()->id(),
            'symbol' => $request->symbol,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json(['status' => 'Trade queued.']);
    }

 

    public function placeTrade(Request $request)
        {
            $request->validate([
                'stock_symbol' => 'required|string',
                'type' => 'required|in:buy,sell',
                'quantity' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0.01',
            ]);

            $user = auth()->user();

            $totalAmount = $request->quantity * $request->price;

            // Wallet check for 'buy' trades
            if ($request->type === 'buy' && $user->wallet_balance < $totalAmount) {
                return response()->json(['error' => 'Insufficient funds'], 400);
            }

            if ($request->type === 'buy') {
                $user->decrement('wallet_balance', $totalAmount);
            }

            $tradeData = [
                'user_id' => $user->id,
                'stock_symbol' => $request->stock_symbol,
                'type' => $request->type,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total_amount' => $totalAmount,
                'timestamp' => now(),
            ];

            // Push to Redis queue
            ProcessTrade::dispatch($tradeData);

            return response()->json(['status' => 'Trade submitted successfully']);
        }


}
