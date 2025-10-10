<?php

namespace App\Services\Wallet;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Services\Badge\BadgeService;
use App\Models\User;

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

    public function evaluateBadgesForUser(User $user): void
    {
        // Lifetime spent (user) and earned (creator) can be derived from transactions
        $wallet = $user->wallet;
        if (!$wallet) {
            return;
        }
        $spent = $wallet->transactions()->where('type', 'DEBIT')->sum('amount');
        $earned = $wallet->transactions()->where('type', 'CREDIT')->sum('amount');
        $badgeService = app(BadgeService::class);
        if ($user->role === 'user') {
            $badgeService->evaluateAndAward($user, 'user', (int)$spent);
        } else if ($user->role === 'creator') {
            $badgeService->evaluateAndAward($user, 'creator', (int)$earned);
        }
    }
}


