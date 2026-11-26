<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSystem;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = UserSystem::with('rol')
            ->where(function ($query) use ($credentials) {
                $query->where('email', $credentials['identifier'])
                    ->orWhere('username', $credentials['identifier']);
            })
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Credenciales incorrectas.'], 401);
        }

        if (!$user->status) {
            return response()->json(['message' => 'La cuenta está inactiva.'], 403);
        }

        $teacherId = $user->teacher()->value('id');

        return response()->json([
            'token' => $user->createToken('web')->plainTextToken,
            'user' => [
                'id' => $user->id,
                'rol_id' => $user->rol_id,
                'rol' => $user->rol,
                'teacher_id' => $teacherId,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente.']);
    }
}
