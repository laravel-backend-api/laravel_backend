<?php

namespace App\Console\Commands;

use App\Models\Leaderboard;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ComputeLeaderboards extends Command
{
    protected $signature = 'leaderboards:compute';
    protected $description = 'Compute leaderboards for users and creators';

    public function handle(): int
    {
        $periods = ['daily', 'weekly', 'monthly', 'lifetime'];
        foreach ($periods as $period) {
            $this->computeForPeriod($period, 'user');
            $this->computeForPeriod($period, 'creator');
        }
        $this->info('Leaderboards computed');
        return self::SUCCESS;
    }

    private function computeForPeriod(string $period, string $role): void
    {
        [$start, $end] = $this->dateRange($period);
        if ($role === 'user') {
            // Users ranked by points spent
            $rows = DB::table('wallet_transactions as wt')
                ->join('wallets as w', 'w.id', '=', 'wt.wallet_id')
                ->join('users as u', 'u.id', '=', 'w.user_id')
                ->where('u.role', 'user')
                ->where('wt.type', 'DEBIT')
                ->when($start, fn($q) => $q->whereBetween('wt.created_at', [$start, $end]))
                ->select('u.id as user_id', DB::raw('SUM(wt.amount) as total'))
                ->groupBy('u.id')
                ->orderByDesc('total')
                ->limit(100)
                ->get();
        } else {
            // Creators ranked by points earned
            $rows = DB::table('wallet_transactions as wt')
                ->join('wallets as w', 'w.id', '=', 'wt.wallet_id')
                ->join('users as u', 'u.id', '=', 'w.user_id')
                ->where('u.role', 'creator')
                ->where('wt.type', 'CREDIT')
                ->when($start, fn($q) => $q->whereBetween('wt.created_at', [$start, $end]))
                ->select('u.id as user_id', DB::raw('SUM(wt.amount) as total'))
                ->groupBy('u.id')
                ->orderByDesc('total')
                ->limit(100)
                ->get();
        }

        $rank = [];
        $position = 1;
        foreach ($rows as $r) {
            $rank[] = ['user_id' => $r->user_id, 'points' => (int)$r->total, 'rank' => $position++];
        }

        Leaderboard::updateOrCreate(
            ['period' => $period, 'role' => $role],
            ['rank_json' => $rank, 'computed_at' => now()]
        );
    }

    private function dateRange(string $period): array
    {
        return match ($period) {
            'daily' => [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()],
            'weekly' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'monthly' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            default => [null, null],
        };
    }
}


