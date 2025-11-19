<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Usuario;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $usuarioId = session()->get('usuario_id');
        
        if (!$usuarioId) {
            return redirect('/login')->with('erro', 'Você precisa estar logado.');
        }

        $usuario = Usuario::find($usuarioId);
        
        if (!$usuario || !$usuario->isAdmin()) {
            return redirect('/atletas')->with('erro', 'Acesso negado. Apenas administradores podem acessar esta página.');
        }

        return $next($request);
    }
}

