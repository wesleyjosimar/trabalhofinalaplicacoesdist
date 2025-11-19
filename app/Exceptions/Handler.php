<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // Em produção, mostrar erro genérico se APP_DEBUG=false
        if (config('app.debug') === false) {
            if ($e instanceof \Illuminate\Database\QueryException) {
                return response()->view('errors.500', ['message' => 'Erro de conexão com o banco de dados'], 500);
            }
        }
        
        return parent::render($request, $e);
    }
}

