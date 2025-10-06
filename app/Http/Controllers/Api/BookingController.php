<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SessionOccurrence;
use App\Models\Booking;
use App\Events\BookingCreated;
use App\Events\BookingCancelled;

class BookingController extends Controller
{
    // POST /api/sessions/{occurrenceId}/book
    public function book(SessionOccurrence $occurrence, Request $request)
    {
        $user = $request->user();

        if ($occurrence->bookings()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Already booked'], 400);
        }

        $bookedCount = $occurrence->bookings()->where('status', 'booked')->count();
        $status = $bookedCount < $occurrence->capacity ? 'booked' : 'waitlisted';

        if ($bookedCount >= $occurrence->capacity) {
            return response()->json(['error' => 'Session is full'], 400);
        }

        $booking = $occurrence->bookings()->create([
            'user_id' => $user->id,
            'status' => 'booked',
            'booked_at' => now(),
        ]);

        event(new BookingCreated($booking));

        return response()->json($booking, 201);
    }

    // POST /api/sessions/{occurrenceId}/waitlist
    public function waitlist(SessionOccurrence $occurrence, Request $request)
    {
        $user = $request->user();

        if ($occurrence->bookings()->where('user_id', $user->id)->exists()) {
            return response()->json(['error' => 'Already booked or waitlisted'], 400);
        }

        $booking = $occurrence->bookings()->create([
            'user_id' => $user->id,
            'status' => 'waitlisted',
            'booked_at' => now(),
        ]);

        return response()->json($booking, 201);
    }

    // DELETE /api/sessions/{occurrenceId}/book (cancel)
    public function cancel(SessionOccurrence $occurrence, Request $request)
    {
        $user = $request->user();
        $booking = $occurrence->bookings()->where('user_id', $user->id)->where('status', 'booked')->first();
        if (!$booking) {
            return response()->json(['error' => 'No active booking'], 404);
        }

        $booking->delete();
        event(new BookingCancelled($booking));

        return response()->json(['message' => 'Cancelled']);
    }
}
