<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($fields);

        return [
            'user' => $user
        ];
    }

    public function show(User $user)
    {
        return ['user' => $user];
    }

    public function update(Request $request, User $user)
    {
        $fields = $request->validate([
            'first_name' => 'sometimes|max:255',
            'last_name' => 'sometimes|max:255',
            'username' => 'sometimes|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes',
        ]);

        if (isset($fields['password'])) {
            $fields['password'] = Hash::make($fields['password']);
        }

        $user->update($fields);

        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password reset successfully']);
    }

    public function disable(User $user)
    {
        $user->disabled = true;
        $user->save();

        return response()->json(['message' => 'User disabled successfully']);
    }
}
