<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\SessionOccurrence;
use App\Models\Wallet;
use App\Services\Wallet\WalletService;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    // POST /api/questions
    public function store(Request $request)
    {
        $request->validate([
            'occurrenceId' => 'required|exists:session_occurrences,id',
            'content' => 'required|string',
            'points' => 'required|integer|min:1',
        ]);
        $user = $request->user();
        $occurrence = SessionOccurrence::with('template.room')->findOrFail($request->occurrenceId);
        $creatorId = $occurrence->template->room->creator_id;

        $wallet = $user->wallet;
        app(WalletService::class)->debit($wallet, (int)$request->points, 'QUESTION_ESCROW', $occurrence->id);

        $q = Question::create([
            'occurrence_id' => $occurrence->id,
            'user_id' => $user->id,
            'creator_id' => $creatorId,
            'content' => $request->input('content'),
            'points_bid' => (int)$request->points,
            'status' => 'queued',
        ]);

        return response()->json($q, 201);
    }

    // POST /api/questions/{id}/mark-answered
    public function markAnswered(Request $request, Question $question)
    {
        $user = $request->user();
        if ($user->role !== 'creator' || $user->id !== $question->creator_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($question->status !== 'queued') {
            return response()->json(['error' => 'Invalid state'], 400);
        }

        $question->update(['status' => 'answered']);

        $creatorWallet = $question->occurrence->template->room->user->wallet;
        app(WalletService::class)->credit($creatorWallet, $question->points_bid, 'QUESTION_PAYOUT', $question->id);

        return response()->json(['message' => 'Marked answered']);
    }

    // POST /api/questions/{id}/refund
    public function refund(Request $request, Question $question)
    {
        if ($question->status !== 'queued') {
            return response()->json(['error' => 'Invalid state'], 400);
        }
        $question->update(['status' => 'refunded']);
        $userWallet = $question->user->wallet;
        app(WalletService::class)->credit($userWallet, $question->points_bid, 'QUESTION_REFUND', $question->id);
        return response()->json(['message' => 'Refunded']);
    }
}


