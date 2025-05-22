<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class WalletController extends Controller
{

    public function getBalance(Request $request)
    {
        $wallet = $request->user()->wallet;

        return response()->json([
            'balance' => $wallet->balance,
        ]);
    }



    
        public function deposit(Request $request)
        {
            $request->validate(['amount' => 'required|numeric|min:1']);

            $user = auth()->user();
            $user->increment('wallet_balance', $request->amount);

            $user->transactions()->create([
                'type' => 'deposit',
                'total_amount' => $request->amount,
            ]);

            return response()->json(['wallet_balance' => $user->wallet_balance], 200);
        }

        public function withdraw(Request $request)
        {
            $request->validate(['amount' => 'required|numeric|min:1']);

            $user = auth()->user();

            if ($user->wallet_balance < $request->amount) {
                return response()->json(['error' => 'Insufficient funds'], 400);
            }

            $user->decrement('wallet_balance', $request->amount);

            $user->transactions()->create([
                'type' => 'withdraw',
                'total_amount' => $request->amount,
            ]);

            return response()->json(['wallet_balance' => $user->wallet_balance], 200);
        }
}
