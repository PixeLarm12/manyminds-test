<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {   
        $request->validate([
            "email" => ["required", "string", "email"],
            "password" => ["required", "string"]
        ]);

        $credentials = $request->only("email", "password");

        if(! $token = Auth::attempt($credentials)) {
            return response()->json(["error" => "Unauthorized"], 401);
        }
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout() 
    {
        return auth()->logout();
    }
}
