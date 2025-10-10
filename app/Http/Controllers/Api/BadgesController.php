<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use Illuminate\Http\Request;

class BadgesController extends Controller
{
    public function index()
    {
        return response()->json(Badge::orderBy('order')->get());
    }

    public function myBadges(Request $request)
    {
        $user = $request->user();
        return response()->json($user->load('badgeAwards.badge')->badgeAwards->pluck('badge'));
    }
}


