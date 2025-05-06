<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordRecoveryController extends Controller
{
    
    public function sendPasswordRecoveryEmail(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'E-mail não encontrado.'], 400);
        }

        
        $response = Password::sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'E-mail de recuperação enviado com sucesso!']);
        }

        return response()->json(['message' => 'Falha ao enviar e-mail de recuperação.'], 500);
    }
}
