<?php
/**
 * Script para gerar SQL com hashes corretos
 * Execute no servidor: php gerar_sql_usuarios.php
 */

echo "-- ============================================================================\n";
echo "-- SQL GERADO COM HASHES CORRETOS - COPIE E COLE NO phpMyAdmin\n";
echo "-- ============================================================================\n\n";

echo "USE amorexpr_teste;\n\n";

// Gerar hash para admin123
$hashAdmin = password_hash('admin123', PASSWORD_BCRYPT);
echo "-- Administrador\n";
echo "-- Email: admin@cbf.com.br\n";
echo "-- Senha: admin123\n";
echo "INSERT INTO usuarios (nome, email, senha, perfil, created_at, updated_at) \n";
echo "VALUES ('Administrador', 'admin@cbf.com.br', '$hashAdmin', 'admin', NOW(), NOW());\n\n";

// Gerar hash para operador123
$hashOperador = password_hash('operador123', PASSWORD_BCRYPT);
echo "-- Operador\n";
echo "-- Email: operador@cbf.com.br\n";
echo "-- Senha: operador123\n";
echo "INSERT INTO usuarios (nome, email, senha, perfil, created_at, updated_at) \n";
echo "VALUES ('Operador', 'operador@cbf.com.br', '$hashOperador', 'operacional', NOW(), NOW());\n\n";

echo "-- ============================================================================\n";
echo "-- LOGIN:\n";
echo "-- admin@cbf.com.br / admin123\n";
echo "-- operador@cbf.com.br / operador123\n";
echo "-- ============================================================================\n";

