<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function login(Request $request) {
        if (Auth::attempt($request->only('email','password'))) {
            $token = $request->user()->createToken('tarefa')->plainTextToken;
            return response()->json(['mensagem' => 'Autorizado.', 'token' => $token], status: 200);
        }
        return response()->json(['mensagem' => 'Não autorizado.'], status: 401);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['mensagem' => 'Token removido.'], status: 200);
    }
}
