<?php
// Script para verificar se as tabelas existem
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Verificação de Tabelas</h1>";

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    echo "<h2>Testando conexão...</h2>";
    $pdo = \DB::connection()->getPdo();
    echo "✅ Conectado ao banco<br><br>";
    
    echo "<h2>Verificando tabelas...</h2>";
    $tables = ['usuarios', 'atletas', 'testes', 'sessions'];
    
    foreach ($tables as $table) {
        try {
            $result = \DB::select("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_name = ?", [$table]);
            if ($result[0]->count > 0) {
                echo "✅ Tabela '$table' existe<br>";
            } else {
                echo "❌ Tabela '$table' NÃO existe<br>";
            }
        } catch (Exception $e) {
            echo "❌ Erro ao verificar '$table': " . $e->getMessage() . "<br>";
        }
    }
    
    echo "<br><h2>Executar migrations?</h2>";
    echo "<p>Se alguma tabela não existe, execute no Shell do Render:</p>";
    echo "<code>php artisan migrate --force</code>";
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

