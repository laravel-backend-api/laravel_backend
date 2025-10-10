<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leaderboard;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,weekly,monthly,lifetime',
            'role' => 'required|in:user,creator',
        ]);

        $lb = Leaderboard::where('period', $request->period)
            ->where('role', $request->role)
            ->first();

        return response()->json($lb ? $lb->rank_json : []);
    }
}


