<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    public function findById(int $id)
    {
        if (!$user = User::find($id)) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User found successfully',
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users',
        ]);

        $request->user()->update($validated);

        return response()->json(['message' => 'Usuário atualizado com sucesso']);
    }

    public function delete(Request $request)
    {
        $request->user()->delete();

        return response()->json(['message' => 'Usuário deletado com sucesso']);
    }
}
