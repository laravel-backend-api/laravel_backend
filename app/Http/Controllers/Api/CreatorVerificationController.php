<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CreatorEmailVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CreatorVerificationController extends Controller
{
    // POST /api/creator/email/request-otp
    public function requestOtp(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'creator') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $otp = (string) random_int(100000, 999999);
        $user->verification_otp = $otp;
        $user->verification_otp_sent_at = now();
        $user->save();

        Mail::to($user->email)->queue(new CreatorEmailVerification($otp));

        return response()->json(['otp' => $otp, 'message' => 'OTP sent']);
    }

    // POST /api/creator/email/confirm
    public function confirm(Request $request)
    {
        $user = $request->user();
        if ($user->role !== 'creator') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $request->validate([
            'otp' => 'required|string',
        ]);
        if (!$user->verification_otp || $user->verification_otp !== $request->otp) {
            return response()->json(['error' => 'Invalid code'], 400);
        }
        if ($user->verification_otp_sent_at && now()->diffInMinutes($user->verification_otp_sent_at) > 15) {
            return response()->json(['error' => 'Code expired'], 400);
        }

        $user->email_verified_at = now();
        $user->verification_otp = null;
        $user->verification_otp_sent_at = null;
        $user->save();

        return response()->json(['message' => 'Email verified']);
    }
}


