<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Create or update a user
    public function createOrUpdate(Request $request)
    {
        $userData = $request->validate([
            'fio' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            'gender' => 'required|string'
        ]);

        $user = User::updateOrCreate(['username' => $userData['username']], $userData);
        return response()->json($user);
    }

    // Retrieve all users
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    // Get a user by username
    public function getUserByUsername($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    // Delete a user by username
    public function deleteUserByUsername($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
