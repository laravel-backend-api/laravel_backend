<?php

namespace App\Services\Badge;

use App\Models\Badge;
use App\Models\BadgeAward;
use App\Models\User;

class BadgeService
{
    public function evaluateAndAward(User $user, string $roleTarget, int $lifetimePoints): void
    {
        $badges = Badge::where('role_target', $roleTarget)
            ->orderBy('threshold_points')
            ->get();

        foreach ($badges as $badge) {
            if ($lifetimePoints >= $badge->threshold_points) {
                BadgeAward::firstOrCreate(
                    ['badge_id' => $badge->id, 'user_id' => $user->id],
                    ['awarded_at' => now()]
                );
            }
        }
    }
}


