<?php

namespace App\Http\Controllers;

use App\Events\UserRegister;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);

        event(new UserRegister($user));

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        // $user = User::where('email', $request->email)->first();

        $user = Cache::remember('user' . $request->email, 60, function () use ($request) {
            return User::where('email', $request->email)->first();
        });
        

        if (!$user || !Hash::check($request->password,$user->password)) {
            return [
                'message' => 'The credentials are incorrect.'
            ];
        }


        $token = $user->createToken($user->name);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.'
        ];
    }
}
