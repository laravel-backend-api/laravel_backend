<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function show(Request $request)
    {
        $wallet = $request->user()->load('wallet.transactions')->wallet;
        return response()->json([
            'balance_points' => $wallet->balance_points,
        ]);
    }

    public function transactions(Request $request)
    {
        $wallet = $request->user()->load(['wallet.transactions' => function ($q) {
            $q->latest();
        }])->wallet;
        return response()->json($wallet->transactions);
    }
}


