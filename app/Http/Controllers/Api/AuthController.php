<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function activeUser(Request $request, string $id)
    {
        $user = User::find($id);
        $user->update(['active' => true]);
        $user->active = true;
        $user->save();
        return response()->json([
            'message' => 'Usuario activado exitosamente.',
            'user' => $user,
        ], 201);

    }
    public function desactivateUser(Request $request, string $id)
    {
        $user = User::find($id);
        $user->update(['active' => false]);
        $user->active = false;
        $user->save();
        return response()->json([
            'message' => 'Usuario desactivado exitosamente.',
            'user' => $user,
        ], 201);

    }
    public function listarUsuarios()
    {
        // $users = User::with('role')->get();
        $users = User::with('role')
        ->whereHas('role', function($query) {
            $query->where('id', 2);
        })
        ->get();

        return response()->json($users);
    }
    public function deleteUsuario($id)
    {
        User::destroy($id);
        return response()->json([
            'message' => 'Usuario Eliminado.',
        ], 204);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('ruc', 'password');
        
        if (Auth::attempt($credentials) && Auth::user()->active) {
            
            $user = Auth::user();
            $token = $user->createToken('MyApp')->plainTextToken;
            $role = $user->role;
            $id_user = $user->id;
            $razon_social = $user->razon_social;
            $ruc = $user->ruc;

            return response()->json([
                'token' => $token,
                'role' => $role,
                'id_user' => $id_user,
                'razon_social' => $razon_social,
                'ruc' => $ruc,
            ]);
        } else {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
    }
    public function register(Request $request)
    {

        $user = User::create([
            'razon_social' => $request->razon_social,
            'ruc' => $request->ruc,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'email' => $request->email,
            'password' => Hash::make($request->ruc),
            'role_id' => 2
        ]);


        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'user' => $user,
        ], 201);
    }
}
