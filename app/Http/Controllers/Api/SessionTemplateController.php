<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SessionTemplate;
use App\Models\SessionRule;
use App\Models\Room;
use App\Models\SessionOccurrence;

class SessionTemplateController extends Controller
{
    // POST /api/creator/session-templates
    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'creator') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $room = $user->rooms()->findOrFail($request->room_id);

        $template = $room->sessionTemplates()->create([
            'title' => $request->title,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'status' => 'active',
        ]);

        return response()->json($template, 201);
    }

    // POST /api/creator/session-templates/{id}/rules
    public function addRules(Request $request, SessionTemplate $template)
    {
        $user = $request->user();
        if ($user->id !== $template->room->creator_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'rules' => 'required|array|min:1',
            'rules.*.weekday' => 'required|integer|between:0,6',
            'rules.*.start_time' => 'required|date_format:H:i',
            'rules.*.end_time' => 'required|date_format:H:i|after:rules.*.start_time',
        ]);

        foreach ($request->rules as $rule) {
            $template->sessionRules()->create($rule);
        }

        return response()->json($template->sessionRules, 201);
    }

    // POST /api/creator/session-templates/{id}/generate
    public function generateOccurrences(Request $request, SessionTemplate $template)
    {
        $user = $request->user();
        if ($user->id !== $template->room->creator_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'weeks' => 'required|integer|min:1|max:52'
        ]);

        $weeks = $request->weeks;
        $occurrences = [];

        foreach ($template->sessionRules as $rule) {
            for ($i = 0; $i < $weeks; $i++) {
                $start = now()->startOfWeek()
                    ->addDays($rule->weekday)
                    ->addWeeks($i)
                    ->setTimeFromTimeString($rule->start_time);
                $end = now()->startOfWeek()
                    ->addDays($rule->weekday)
                    ->addWeeks($i)
                    ->setTimeFromTimeString($rule->end_time);

                $occurrences[] = $template->sessionOccurrences()->create([
                    'start_at' => $start,
                    'end_at' => $end,
                    'capacity' => $template->capacity,
                    'status' => 'active',
                ]);
            }
        }

        return response()->json($occurrences, 201);
    }
}
