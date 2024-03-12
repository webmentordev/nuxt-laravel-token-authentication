<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ApiVerifyEmail;
use Illuminate\Auth\Events\Registered;

class AuthenticationController extends Controller
{
    // Fetch user information
    public function index(Request $request){
        return $request->user();
    }

    // Register a new user and generate token
    public function register(Request $request){
        $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|confirmed|min:5|max:255|string'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        $user->notify(new ApiVerifyEmail);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token
        ], 201);
    }

    // Authenticate user and generate token
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Bad login credientials'
            ], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token
        ], 201);
    }

    // Logout and delete tokens
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logged Out!',
        ], 201);
    }
}