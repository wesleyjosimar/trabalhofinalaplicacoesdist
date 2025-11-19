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
    echo "⚠️ Usuários já existem no banco.\n";
    echo "Deseja continuar mesmo assim? (s/n): ";
    $resposta = trim(fgets(STDIN));
    if (strtolower($resposta) !== 's') {
        exit;
    }
    // Deletar usuários existentes
    foreach ($usuarios as $usuario) {
        if (in_array($usuario['email'], ['admin@cbf.com.br', 'operador@cbf.com.br'])) {
            $usuarioModel->excluir($usuario['id']);
            echo "Usuário {$usuario['email']} removido.\n";
        }
    }
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

