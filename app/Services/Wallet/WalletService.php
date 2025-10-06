<?php

namespace App\Services\Wallet;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function credit(Wallet $wallet, int $amount, string $refType, int|string|null $refId = null, array $meta = []): WalletTransaction
    {
        return DB::transaction(function () use ($wallet, $amount, $refType, $refId, $meta) {
            $wallet->balance_points += $amount;
            $wallet->save();
            return $wallet->transactions()->create([
                'type' => 'CREDIT',
                'amount' => $amount,
                'ref_type' => $refType,
                'ref_id' => $refId,
                'meta' => $meta,
            ]);
        });
    }

    public function debit(Wallet $wallet, int $amount, string $refType, int|string|null $refId = null, array $meta = []): WalletTransaction
    {
        return DB::transaction(function () use ($wallet, $amount, $refType, $refId, $meta) {
            if ($wallet->balance_points < $amount) {
                throw new \RuntimeException('Insufficient points');
            }
            $wallet->balance_points -= $amount;
            $wallet->save();
            return $wallet->transactions()->create([
                'type' => 'DEBIT',
                'amount' => $amount,
                'ref_type' => $refType,
                'ref_id' => $refId,
                'meta' => $meta,
            ]);
        });
    }
}


