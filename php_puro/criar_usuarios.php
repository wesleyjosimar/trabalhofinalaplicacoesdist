<?php
/**
 * Script para criar usuários padrão
 * Execute: php criar_usuarios.php
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/models/Usuario.php';

$usuarioModel = new Usuario();

// Verificar se já existem usuários
$usuarios = $usuarioModel->listar();
if (!empty($usuarios)) {
    echo "Usuários já existem no banco.\n";
    exit;
}

// Criar usuários padrão
$usuarios = [
    [
        'nome' => 'Administrador',
        'email' => 'admin@cbf.com.br',
        'senha' => 'admin123',
        'perfil' => 'admin'
    ],
    [
        'nome' => 'Operador',
        'email' => 'operador@cbf.com.br',
        'senha' => 'operador123',
        'perfil' => 'operacional'
    ]
];

foreach ($usuarios as $usuario) {
    if ($usuarioModel->criar($usuario)) {
        echo "✅ Usuário criado: {$usuario['email']}\n";
    } else {
        echo "❌ Erro ao criar usuário: {$usuario['email']}\n";
    }
}

echo "\nUsuários criados com sucesso!\n";
echo "Login: admin@cbf.com.br / admin123\n";
echo "Login: operador@cbf.com.br / operador123\n";

