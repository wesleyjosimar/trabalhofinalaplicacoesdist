<?php
/**
 * Arquivo de Teste para Ver Erros
 * Acesse: https://teste.amorexpress.com.br/teste_erro.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Teste de Erros</title>";
echo "<style>body{font-family:Arial;max-width:900px;margin:20px auto;padding:20px;background:#f5f5f5;}";
echo "pre{background:#fff;padding:15px;border:1px solid #ddd;overflow:auto;border-left:4px solid #e74c3c;}";
echo "h1{color:#e74c3c;} .ok{color:green;} .erro{color:red;}</style></head><body>";
echo "<h1>🔍 Teste de Erros - CBF Antidoping</h1>";

echo "<h2>1. Informações do PHP</h2>";
echo "<pre>";
echo "Versão PHP: " . phpversion() . "\n";
echo "SAPI: " . php_sapi_name() . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "\n";
echo "Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A') . "\n";
echo "</pre>";

echo "<h2>2. Caminhos</h2>";
echo "<pre>";
echo "__DIR__: " . __DIR__ . "\n";
echo "__FILE__: " . __FILE__ . "\n";
echo "Base Path: " . dirname(__DIR__) . "\n";
echo "</pre>";

echo "<h2>3. Testando Autoload</h2>";
$basePath = dirname(__DIR__);
$autoloadPath = $basePath . '/vendor/autoload.php';
echo "<pre>";
if (file_exists($autoloadPath)) {
    echo "✅ vendor/autoload.php encontrado: $autoloadPath\n";
    try {
        require $autoloadPath;
        echo "✅ Autoload carregado com sucesso!\n";
    } catch (Exception $e) {
        echo "❌ Erro ao carregar autoload: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ vendor/autoload.php NÃO encontrado em: $autoloadPath\n";
}
echo "</pre>";

echo "<h2>4. Testando Bootstrap</h2>";
$bootstrapPath = $basePath . '/bootstrap/app.php';
echo "<pre>";
if (file_exists($bootstrapPath)) {
    echo "✅ bootstrap/app.php encontrado: $bootstrapPath\n";
    try {
        $app = require_once $bootstrapPath;
        echo "✅ Bootstrap carregado!\n";
        echo "Tipo: " . get_class($app) . "\n";
    } catch (Exception $e) {
        echo "❌ Erro ao carregar bootstrap:\n";
        echo "Mensagem: " . $e->getMessage() . "\n";
        echo "Arquivo: " . $e->getFile() . "\n";
        echo "Linha: " . $e->getLine() . "\n";
        echo "\nStack Trace:\n" . $e->getTraceAsString() . "\n";
    } catch (Error $e) {
        echo "❌ Erro fatal ao carregar bootstrap:\n";
        echo "Mensagem: " . $e->getMessage() . "\n";
        echo "Arquivo: " . $e->getFile() . "\n";
        echo "Linha: " . $e->getLine() . "\n";
        echo "\nStack Trace:\n" . $e->getTraceAsString() . "\n";
    }
} else {
    echo "❌ bootstrap/app.php NÃO encontrado em: $bootstrapPath\n";
}
echo "</pre>";

echo "<h2>5. Testando .env</h2>";
$envPath = $basePath . '/.env';
echo "<pre>";
if (file_exists($envPath)) {
    echo "✅ Arquivo .env encontrado\n";
    $env = parse_ini_file($envPath);
    echo "APP_ENV: " . ($env['APP_ENV'] ?? 'NÃO DEFINIDO') . "\n";
    echo "APP_DEBUG: " . ($env['APP_DEBUG'] ?? 'NÃO DEFINIDO') . "\n";
    echo "APP_KEY: " . (isset($env['APP_KEY']) && !empty($env['APP_KEY']) ? 'DEFINIDO' : 'NÃO DEFINIDO') . "\n";
    echo "DB_DATABASE: " . ($env['DB_DATABASE'] ?? 'NÃO DEFINIDO') . "\n";
} else {
    echo "❌ Arquivo .env NÃO encontrado em: $envPath\n";
}
echo "</pre>";

echo "<h2>6. Testando Estrutura</h2>";
echo "<pre>";
$dirs = ['app', 'bootstrap', 'config', 'database', 'routes', 'storage', 'vendor'];
foreach ($dirs as $dir) {
    $path = $basePath . '/' . $dir;
    if (is_dir($path)) {
        echo "✅ $dir/\n";
    } else {
        echo "❌ $dir/ (NÃO ENCONTRADO)\n";
    }
}
echo "</pre>";

echo "<h2>7. Testando index.php</h2>";
$indexPath = $basePath . '/index.php';
echo "<pre>";
if (file_exists($indexPath)) {
    echo "✅ index.php encontrado: $indexPath\n";
    echo "Tamanho: " . filesize($indexPath) . " bytes\n";
} else {
    echo "❌ index.php NÃO encontrado em: $indexPath\n";
}
echo "</pre>";

echo "</body></html>";

