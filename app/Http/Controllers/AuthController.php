<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // $credentials = $request->validate([
        //     'email' => ['required', 'email'],
        //     'password' => ['required'],
        // ]);
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);

        if (Auth::guard('drivers')->attempt($credentials)) {
            $driver = Driver::where('email', $request->email)->first();
            $token = $driver->createToken('driver_token')->plainTextToken;

            return response()->json(['token' => $token]);
        }
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'No Autorizado'], 401);
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function register(Request $request)
    {

        $user = User::create([
            'razon_social' => $request->razon_social,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generar un token de acceso para el conductor.
        $token = $driver->createToken('driver_token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

}