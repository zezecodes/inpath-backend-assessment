<?php

namespace App\Http\Controllers;

use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
        $user = User::create($fields);
        $token = $user->createToken($request->username);
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

        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return [
                "message" => "The provided credentials are incorrect"
            ];
        }
        $token = $user->createToken($user->username);
        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            "message"=> "You are logged out"
        ];
    }

}
