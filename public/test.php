<?php
// Script de teste simples para diagnosticar problemas
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste de Diagnóstico</h1>";

echo "<h2>1. PHP Version</h2>";
echo "Versão: " . phpversion() . "<br>";

echo "<h2>2. Extensões PHP</h2>";
echo "PDO: " . (extension_loaded('pdo') ? 'OK' : 'FALTANDO') . "<br>";
echo "PDO_PGSQL: " . (extension_loaded('pdo_pgsql') ? 'OK' : 'FALTANDO') . "<br>";
echo "MBSTRING: " . (extension_loaded('mbstring') ? 'OK' : 'FALTANDO') . "<br>";

echo "<h2>3. Variáveis de Ambiente</h2>";
echo "APP_ENV: " . (getenv('APP_ENV') ?: 'NÃO DEFINIDO') . "<br>";
echo "DB_HOST: " . (getenv('DB_HOST') ?: 'NÃO DEFINIDO') . "<br>";
echo "DB_DATABASE: " . (getenv('DB_DATABASE') ?: 'NÃO DEFINIDO') . "<br>";
echo "DB_USERNAME: " . (getenv('DB_USERNAME') ?: 'NÃO DEFINIDO') . "<br>";
echo "APP_KEY: " . (getenv('APP_KEY') ? 'DEFINIDO' : 'NÃO DEFINIDO') . "<br>";

echo "<h2>4. Teste de Conexão com Banco</h2>";
try {
    // Usar valores das variáveis de ambiente (não fallback hardcoded)
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT') ?: '5432';
    $db = getenv('DB_DATABASE');
    $user = getenv('DB_USERNAME');
    $pass = getenv('DB_PASSWORD');
    
    if (!$host || !$db || !$user || !$pass) {
        echo "❌ Variáveis de ambiente não configuradas corretamente!<br>";
        echo "DB_HOST: " . ($host ?: 'NÃO DEFINIDO') . "<br>";
        echo "DB_DATABASE: " . ($db ?: 'NÃO DEFINIDO') . "<br>";
        echo "DB_USERNAME: " . ($user ?: 'NÃO DEFINIDO') . "<br>";
        echo "DB_PASSWORD: " . ($pass ? 'DEFINIDO' : 'NÃO DEFINIDO') . "<br>";
        echo "<br><strong>Configure as variáveis no Render: Environment → Edite cada variável</strong><br>";
        return;
    }
    
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    $pdo = new PDO($dsn, $user, $pass);
    echo "✅ Conexão com banco: OK<br>";
} catch (Exception $e) {
    echo "❌ Erro de conexão: " . $e->getMessage() . "<br>";
}

echo "<h2>5. Estrutura de Pastas</h2>";
echo "vendor/ existe: " . (is_dir(__DIR__ . '/../vendor') ? 'SIM' : 'NÃO') . "<br>";
echo "storage/ existe: " . (is_dir(__DIR__ . '/../storage') ? 'SIM' : 'NÃO') . "<br>";
echo "storage/ writable: " . (is_writable(__DIR__ . '/../storage') ? 'SIM' : 'NÃO') . "<br>";

echo "<h2>6. Teste Laravel</h2>";
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
    echo "✅ Autoload carregado<br>";
    
    try {
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        echo "✅ Bootstrap carregado<br>";
    } catch (Exception $e) {
        echo "❌ Erro no bootstrap: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ vendor/autoload.php não encontrado<br>";
}

