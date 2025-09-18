<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreatorController extends Controller
{
    // GET /api/creators
    public function index(Request $request)
    {
        $query = User::creators()->with('rooms');

        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
        }

        if ($request->has('sort')) {
            $query->orderBy($request->sort, $request->get('direction', 'asc'));
        }

        return $query->paginate(10);
    }

    // GET /api/creators/{id}
    public function show($id)
    {
        return User::creators()->with('rooms')->findOrFail($id);
    }

    // GET /api/creators/{id}/room
    public function rooms($id)
    {
        $creator = User::creators()->findOrFail($id);
        return $creator->rooms; // returns all rooms
    }

    // POST /api/creator/room
    public function storeRoom(Request $request)
    {
        $request->validate([
            'zoom_link' => 'required|url',
            'is_active' => 'boolean'
        ]);

        $creator = auth()->user();
        if ($creator->role !== 'creator') {
            return response()->json(['message' => 'Not authorized'], 403);
        }

        // If you want multiple rooms, just create a new one
        $room = Room::create([
            'creator_id' => $creator->id,
            'zoom_link' => $request->zoom_link,
            'is_active' => $request->get('is_active', true),
        ]);

        return response()->json($room, 201);
    }
}
