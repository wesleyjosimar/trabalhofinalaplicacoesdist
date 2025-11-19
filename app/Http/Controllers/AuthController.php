<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('usuario_id')) {
            return redirect('/atletas');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if (!$usuario || !$usuario->verificarSenha($request->senha)) {
            return back()->with('erro', 'Email ou senha incorretos.');
        }

        session([
            'usuario_id' => $usuario->id,
            'usuario_nome' => $usuario->nome,
            'usuario_perfil' => $usuario->perfil,
        ]);

        return redirect('/atletas')->with('sucesso', 'Login realizado com sucesso!');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login')->with('sucesso', 'Logout realizado com sucesso!');
    }
}

