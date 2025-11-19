<?php
/**
 * Script para gerar hashes bcrypt das senhas
 * Execute: php gerar_hash_senhas.php
 */

echo "Gerando hashes bcrypt para as senhas:\n\n";

$senhas = [
    'admin123' => 'admin@cbf.com.br',
    'operador123' => 'operador@cbf.com.br'
];

echo "-- SQL para inserir usuários:\n\n";
echo "USE amorexpr_teste;\n\n";

foreach ($senhas as $senha => $email) {
    $hash = password_hash($senha, PASSWORD_BCRYPT);
    $nome = $senha === 'admin123' ? 'Administrador' : 'Operador';
    $perfil = $senha === 'admin123' ? 'admin' : 'operacional';
    
    echo "-- Email: $email\n";
    echo "-- Senha: $senha\n";
    echo "INSERT INTO `usuarios` (`nome`, `email`, `senha`, `perfil`, `created_at`, `updated_at`) \n";
    echo "VALUES ('$nome', '$email', '$hash', '$perfil', NOW(), NOW())\n";
    echo "ON DUPLICATE KEY UPDATE `nome` = VALUES(`nome`), `perfil` = VALUES(`perfil`);\n\n";
}

echo "\n-- Copie e cole o SQL acima no phpMyAdmin\n";

