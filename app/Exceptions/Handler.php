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

    public function render($request, Throwable $exception)
    {
        // Em modo debug, mostrar erros detalhados
        if (config('app.debug')) {
            return parent::render($request, $exception);
        }

        // Em produção, mostrar página genérica
        return parent::render($request, $exception);
    }

}

