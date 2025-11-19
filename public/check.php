<?php
// Script para verificar se as tabelas existem
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Verificação de Tabelas</h1>";

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    echo "<h2>Testando conexão...</h2>";
    
    // Usar PDO diretamente
    $host = getenv('DB_HOST') ?: 'dpg-d4ev74u3jp1c738ov1v0-a.oregon-postgres.render.com';
    $port = getenv('DB_PORT') ?: '5432';
    $db = getenv('DB_DATABASE') ?: 'cbf_antidoping';
    $user = getenv('DB_USERNAME') ?: 'cbf_user';
    $pass = getenv('DB_PASSWORD') ?: 'Jwa4jbjLLmIfpkCNf34NfU3PXVpdfgxe';
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conectado ao banco<br><br>";
    
    echo "<h2>Verificando tabelas...</h2>";
    $tables = ['usuarios', 'atletas', 'testes', 'sessions'];
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM information_schema.tables WHERE table_schema = 'public' AND table_name = ?");
            $stmt->execute([$table]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result['count'] > 0) {
                // Verificar quantos registros tem
                $stmt2 = $pdo->prepare("SELECT COUNT(*) as count FROM $table");
                $stmt2->execute();
                $count = $stmt2->fetch(PDO::FETCH_ASSOC)['count'];
                echo "✅ Tabela '$table' existe ($count registros)<br>";
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
    echo "<br><br>";
    echo "<p>E depois execute o seed para criar usuários padrão:</p>";
    echo "<code>php artisan db:seed --force</code>";
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

