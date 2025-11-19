<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AtletaController;
use App\Http\Controllers\TesteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AdminMiddleware;

// Health check para Render
Route::get('/up', function () {
    return response()->json(['status' => 'ok']);
});

// Rotas públicas
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas (requerem autenticação)
Route::middleware([AuthMiddleware::class])->group(function () {
    // Atletas
    Route::get('/', function () {
        return redirect('/atletas');
    });
    Route::resource('atletas', AtletaController::class);
    
    // Testes
    Route::resource('testes', TesteController::class)->except(['destroy']);
    
    // Usuários (apenas admin)
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
    });
});

