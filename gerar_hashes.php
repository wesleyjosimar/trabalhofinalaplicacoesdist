<?php
// Script para gerar hashes bcrypt das senhas
// Execute: php gerar_hashes.php

echo "Gerando hashes bcrypt para as senhas:\n\n";

$senhas = [
    'admin123' => 'admin@cbf.com.br',
    'operador123' => 'operador@cbf.com.br'
];

foreach ($senhas as $senha => $email) {
    $hash = password_hash($senha, PASSWORD_BCRYPT);
    echo "Email: $email\n";
    echo "Senha: $senha\n";
    echo "Hash: $hash\n\n";
}

echo "\nUse estes hashes no arquivo database.sql\n";

