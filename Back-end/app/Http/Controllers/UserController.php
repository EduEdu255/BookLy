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

    public function update(Request $request, int $id)
    {
        //
    }

    public function delete(Request $request)
    {
        $request->user()->delete();

        return response()->json(['message' => 'Usuário deletado com sucesso']);
    }
}
