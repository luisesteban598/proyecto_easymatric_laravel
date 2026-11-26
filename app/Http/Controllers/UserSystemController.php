<?php

namespace App\Http\Controllers;

use App\Models\UserSystem;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserSystemController extends Controller
{
    //
    public function index()
    {
        $user_systems = UserSystem::all();
        return response()->json($user_systems);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_last_name' => 'nullable|string|max:255',
            'document' => 'required|string|unique:user_systems,document|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'required|string|email|unique:user_systems,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'photo_url' => 'nullable|string|max:255',
            'photo_public_id' => 'nullable|string|max:255',
            'document_type' => 'nullable|string|max:255',
            'username' => 'required|string|unique:user_systems,username|max:255',
            'status' => 'required|boolean',
            'institution_id' => 'nullable|integer|exists:institutions,id',
            'rol_id' => 'nullable|integer|exists:rols,id',
        ]);

        unset($data['password_confirmation']);
        $data['password'] = Hash::make($data['password']);

        $userSystem = UserSystem::create($data);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'data' => $userSystem,
        ], 201);
    }

    public function show($id)
    {
        $user_systems = UserSystem::find($id);
        return response()->json($user_systems);
    }

    public function update(Request $request, UserSystem $user_system)
    {
        $user_system->update($request->all());
        return response()->json($user_system);
    }
    public function destroy(UserSystem $user_system)
    {
        $user_system->delete();
        return response()->json($user_system);
    }
}
