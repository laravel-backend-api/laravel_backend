<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SessionOccurrence;

class SessionOccurrenceController extends Controller
{
    // GET /api/sessions
    public function index(Request $request)
    {
        $query = SessionOccurrence::with('template.room.user');

        if ($request->category_id) {
            $query->whereHas('template.room.user.categories', fn($q) =>
            $q->where('id', $request->category_id));
        }

        if ($request->creator_id) {
            $query->whereHas('template.room', fn($q) =>
            $q->where('creator_id', $request->creator_id));
        }

        if ($request->date_from) $query->where('start_at', '>=', $request->date_from);
        if ($request->date_to) $query->where('start_at', '<=', $request->date_to);

        if ($request->sort === 'popularity') {
            $query->orderByRaw('JSON_LENGTH(stats_cached_json->"$.bookings") DESC');
        } else {
            $query->orderBy('start_at', 'asc');
        }

        return response()->json($query->paginate(20));
    }

    // GET /api/sessions/{occurrenceId}
    public function show(SessionOccurrence $occurrence)
    {
        $occurrence->load('template.room.user');
        $booked = $occurrence->bookings()->where('status', 'booked')->count();

        return response()->json([
            'occurrence' => $occurrence,
            'booked' => $booked,
            'max' => $occurrence->capacity,
        ]);
    }

    // POST /api/sessions/{occurrenceId}/drive-link
    public function addDriveLink(Request $request, SessionOccurrence $occurrence)
    {
        $user = $request->user();
        if ($user->id !== $occurrence->template->room->creator_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate(['drive_link' => 'required|url']);

        $occurrence->update(['drive_link' => $request->drive_link]);

        return response()->json($occurrence);
    }
}
