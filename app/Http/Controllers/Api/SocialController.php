<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SessionOccurrence;
use App\Models\User;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function follow(Request $request, int $id)
    {
        $user = $request->user();

        if ($user->id === $id) {
            return response()->json(['message' => 'Cannot follow yourself'], 422);
        }

        $creator = User::creators()->findOrFail($id);

        $user->following()->syncWithoutDetaching([$creator->id]);

        return response()->json(['message' => 'Followed']);
    }

    public function unfollow(Request $request, int $id)
    {
        $user = $request->user();
        $creator = User::creators()->findOrFail($id);

        $user->following()->detach($creator->id);

        return response()->json(['message' => 'Unfollowed']);
    }

    public function feed(Request $request)
    {
        $user = $request->user();
        $followedCreatorIds = $user->following()->pluck('users.id');

        $now = now();

        $occurrences = SessionOccurrence::query()
            ->whereHas('template.room', function ($q) use ($followedCreatorIds) {
                $q->whereIn('creator_id', $followedCreatorIds);
            })
            ->where('start_at', '>=', $now)
            ->orderBy('start_at')
            ->with(['template.room.user'])
            ->paginate(20);

        return response()->json($occurrences);
    }
}


