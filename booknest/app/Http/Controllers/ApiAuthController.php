<?php

namespace App\Http\Controllers\Api; // Importante o namespace!

use App\Http\Controllers\Controller;
use App\Models\User; // Certifique-se de importar o modelo User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; // Para lançar erros de validação bonitinhos

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:45', // Usando 'username' como você tem no formulário de cadastro
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' requer 'password_confirmation' no request
        ]);

        $user = User::create([
            'username' => $request->username, // Certifique-se de usar 'username' se for o campo do seu banco
            'email' => $request->email,
            'password' => bcrypt($request->password), // Sempre bcrypt a senha
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Cadastro bem-sucedido',
            'user' => $user, // Retorna dados do usuário (opcional)
            'token' => $token,
        ], 201); // 201 Created
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['email' => ['Credenciais inválidas.']], 401);
        }

        $user = $request->user(); // Pega o usuário autenticado
        $token = $user->createToken('authToken')->plainTextToken; // Gera o token para a sessão da API

        return response()->json([
            'message' => 'Login bem-sucedido',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Revoga todos os tokens do usuário para Sanctum

        return response()->json(['message' => 'Logout bem-sucedido']);
    }
}