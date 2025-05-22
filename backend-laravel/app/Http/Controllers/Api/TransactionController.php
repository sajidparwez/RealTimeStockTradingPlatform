<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TransactionController extends Controller{
    public function index(Request $request)
    {
        $transactions = $request->user()->transactions()->latest()->take(20)->get();

        return response()->json($transactions);
    }

}

