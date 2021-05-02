<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validData = $this->validateData($request);
        dd($validData);

        $validData['password'] = Hash::make($validData['password']);

        $user = User::create($validData);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if (!Auth::attempt($loginData)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid credentials',
                // 'data'=>'data',
            ], 401);
        }

        return response()->json([
            'status' => 'Success',
            'access_token' => auth()->user()->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer'
        ], 200);
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);
    }
}
