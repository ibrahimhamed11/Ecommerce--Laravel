<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function all()
    {
        $users = User::all();

        $selectedUserData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,

                'created_at' => $user->created_at->toDateTimeString(),
                'updated_at' => $user->updated_at->toDateTimeString(),
            ];
        });

        return $this->successResponse($selectedUserData);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->successResponse($user);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'phone' => 'required|string',
                'password' => 'required|string|min:6',
                'role' => 'string|in:user,admin',
            ]);

            // Determine the role based on the request or default to 'user'
            $role = $request->input('role', 'user');

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('password')),
                'role' => $role,
            ]);

            return $this->successResponse($user, 201);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|string',
            ]);

            $user->update($request->all());

            return $this->successResponse($user);
        } catch (ValidationException $e) {
            return $this->errorResponse($e->errors(), 422);
        }
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $this->successResponse(['message' => 'User deleted successfully']);
    }

    private function successResponse($data, $status = 200)
    {
        return response()->json(['data' => $data], $status);
    }

    private function errorResponse($errors, $status)
    {
        return response()->json(['error' => $errors], $status);
    }
}
