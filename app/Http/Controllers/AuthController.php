<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token)
        {
            return ResponseFormatter::error([], 'Incorrect username or password!', 401);
        }

        $user = Auth::user();
        return ResponseFormatter::success([
            'user' => $user,
            'access_token' => [
                'token' => $token,
                'type' => 'Bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
            ],
        ]);

    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return ResponseFormatter::success([
            'user' => $user,
            'access_token' => [
                'token' => $token,
                'type' => 'Bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
            ],
        ], 'User created successfully');
    }

    public function logout()
    {
        Auth::logout();
        return ResponseFormatter::success([], 'Successfully logged out');
    }

    public function refresh()
    {
        return ResponseFormatter::success([
            'user' => Auth::user(),
            'access_token' => [
                'token' => Auth::refresh(),
                'type' => 'Bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
            ],
        ]);
    }
}
