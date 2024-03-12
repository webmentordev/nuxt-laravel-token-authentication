<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class PasswordController extends Controller
{
    // Send Password Reset Email
    public function reset_request(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status != Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], 401);
        }
        return response()->json([
            'message' => 'Email reset link has been sent!'
        ], 201);
    }

    // Reset password using the token, email, passwords
    public function reset_password(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5|max:255|string',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();
                event(new PasswordReset($user));
            }
        );
        if ($status != Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Something went wrong!'
            ], 401);
        }
        return response()->json([
            'message' => 'Password has been reset!'
        ], 201);
    }
}