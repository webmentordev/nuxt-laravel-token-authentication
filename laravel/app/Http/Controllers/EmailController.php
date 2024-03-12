<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Notifications\ApiVerifyEmail;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailController extends Controller
{
    // Send Verification email
    public function send_verification(Request $request){
        if($request->user()->hasVerifiedEmail()){
            return response()->json([
                'message' => 'You are already verified!'
            ], 401);
        }
        $request->user()->notify(new ApiVerifyEmail);
        return response()->json([
            'message' => 'Verification email has been sent!'
        ], 201);
    }

    // Verify the user email!
    public function verify_email(EmailVerificationRequest $request){
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified!'
            ], 201);
        }
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        return response()->json([
            'message' => 'Email has been verified!'
        ], 201);
    }
}