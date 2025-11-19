<?php
/**
 * Script de Diagnóstico para cPanel
 * Acesse: https://seu-dominio.com.br/diagnostico.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Diagnóstico CBF</title>";
echo "<style>body{font-family:Arial;max-width:800px;margin:20px auto;padding:20px;}";
echo ".ok{color:green;font-weight:bold;} .erro{color:red;font-weight:bold;}";
echo "h2{background:#f0f0f0;padding:10px;border-left:4px solid #333;}";
echo "pre{background:#f5f5f5;padding:10px;overflow:auto;}</style></head><body>";
echo "<h1>🔍 Diagnóstico - CBF Antidoping</h1>";

// 1. Versão PHP
echo "<h2>1. Versão PHP</h2>";
$phpVersion = phpversion();
echo "Versão: <strong>$phpVersion</strong><br>";
if (version_compare($phpVersion, '8.1.0', '>=')) {
    echo "<span class='ok'>✅ PHP 8.1+ detectado</span><br>";
} else {
    echo "<span class='erro'>❌ PHP 8.1+ necessário (atual: $phpVersion)</span><br>";
}

// 2. Extensões PHP
echo "<h2>2. Extensões PHP</h2>";
$extensoes = [
    'pdo' => 'PDO',
    'pdo_mysql' => 'PDO MySQL',
    'mbstring' => 'MBString',
    'openssl' => 'OpenSSL',
    'fileinfo' => 'FileInfo',
    'tokenizer' => 'Tokenizer',
    'xml' => 'XML',
    'ctype' => 'CTYPE',
    'json' => 'JSON',
];

foreach ($extensoes as $ext => $nome) {
    $status = extension_loaded($ext);
    if ($status) {
        echo "<span class='ok'>✅ $nome</span><br>";
    } else {
        echo "<span class='erro'>❌ $nome (FALTANDO)</span><br>";
    }
}

// 3. Estrutura de Diretórios
echo "<h2>3. Estrutura de Diretórios</h2>";
$basePath = dirname(__DIR__);
echo "Caminho base: <code>$basePath</code><br><br>";

$dirs = [
    'vendor' => 'Dependências Composer',
    'storage' => 'Armazenamento',
    'storage/framework' => 'Framework Storage',
    'storage/logs' => 'Logs',
    'bootstrap/cache' => 'Cache Bootstrap',
    'app' => 'Aplicação',
    'config' => 'Configuração',
];

foreach ($dirs as $dir => $desc) {
    $path = $basePath . '/' . $dir;
    $exists = is_dir($path);
    $writable = $exists && is_writable($path);
    
    if ($exists) {
        echo "<span class='ok'>✅ $desc</span> ";
        if ($writable) {
            echo "<span class='ok'>(gravável)</span><br>";
        } else {
            echo "<span class='erro'>(NÃO GRAVÁVEL - ajuste permissões para 755)</span><br>";
        }
    } else {
        echo "<span class='erro'>❌ $desc (NÃO ENCONTRADO)</span><br>";
    }
}

// 4. Arquivo .env
echo "<h2>4. Arquivo .env</h2>";
$envPath = $basePath . '/.env';
if (file_exists($envPath)) {
    echo "<span class='ok'>✅ Arquivo .env encontrado</span><br>";
    
    $envContent = file_get_contents($envPath);
    $hasAppKey = strpos($envContent, 'APP_KEY=') !== false && strpos($envContent, 'APP_KEY=base64:') !== false;
    $hasDbConfig = strpos($envContent, 'DB_CONNECTION=mysql') !== false;
    
    if ($hasAppKey) {
        echo "<span class='ok'>✅ APP_KEY configurado</span><br>";
    } else {
        echo "<span class='erro'>❌ APP_KEY não configurado (execute: php artisan key:generate)</span><br>";
    }
    
    if ($hasDbConfig) {
        echo "<span class='ok'>✅ Configuração de banco encontrada</span><br>";
    } else {
        echo "<span class='erro'>❌ Configuração de banco não encontrada</span><br>";
    }
} else {
    echo "<span class='erro'>❌ Arquivo .env NÃO encontrado</span><br>";
    echo "Crie o arquivo .env na raiz do projeto!<br>";
}

// 5. Teste de Conexão com Banco
echo "<h2>5. Teste de Conexão com Banco</h2>";
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    $dbHost = $env['DB_HOST'] ?? 'localhost';
    $dbPort = $env['DB_PORT'] ?? '3306';
    $dbName = $env['DB_DATABASE'] ?? '';
    $dbUser = $env['DB_USERNAME'] ?? '';
    $dbPass = $env['DB_PASSWORD'] ?? '';
    
    if ($dbName && $dbUser) {
        try {
            $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4";
            $pdo = new PDO($dsn, $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<span class='ok'>✅ Conexão com banco: OK</span><br>";
            
            // Verificar tabelas
            $tables = ['usuarios', 'atletas', 'testes', 'sessions'];
            echo "<br><strong>Tabelas:</strong><br>";
            foreach ($tables as $table) {
                $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
                if ($stmt->rowCount() > 0) {
                    echo "<span class='ok'>✅ $table</span><br>";
                } else {
                    echo "<span class='erro'>❌ $table (NÃO EXISTE - execute: php artisan migrate)</span><br>";
                }
            }
        } catch (PDOException $e) {
            echo "<span class='erro'>❌ Erro de conexão: " . htmlspecialchars($e->getMessage()) . "</span><br>";
        }
    } else {
        echo "<span class='erro'>❌ Credenciais de banco não configuradas no .env</span><br>";
    }
} else {
    echo "<span class='erro'>❌ Arquivo .env não encontrado</span><br>";
}

// 6. Composer Autoload
echo "<h2>6. Composer Autoload</h2>";
$autoloadPath = $basePath . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    echo "<span class='ok'>✅ vendor/autoload.php encontrado</span><br>";
} else {
    echo "<span class='erro'>❌ vendor/autoload.php NÃO encontrado</span><br>";
    echo "Execute: <code>composer install</code><br>";
}

// 7. Mod Rewrite
echo "<h2>7. Mod Rewrite (Apache)</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<span class='ok'>✅ mod_rewrite está ativo</span><br>";
    } else {
        echo "<span class='erro'>❌ mod_rewrite NÃO está ativo</span><br>";
    }
} else {
    echo "⚠️ Não foi possível verificar mod_rewrite (normal em alguns servidores)<br>";
}

// 8. Caminhos
echo "<h2>8. Caminhos Importantes</h2>";
echo "<pre>";
echo "__DIR__ (este arquivo): " . __DIR__ . "\n";
echo "Base Path: $basePath\n";
echo "Public Path: " . __DIR__ . "\n";
echo "Storage Path: $basePath/storage\n";
echo "</pre>";

echo "<hr>";
echo "<p><strong>Próximos passos:</strong></p>";
echo "<ol>";
echo "<li>Se houver erros, corrija-os conforme indicado acima</li>";
echo "<li>Execute: <code>php artisan key:generate</code></li>";
echo "<li>Execute: <code>php artisan migrate</code></li>";
echo "<li>Execute: <code>php artisan db:seed</code></li>";
echo "<li>Acesse a aplicação: <a href='/'>Início</a></li>";
echo "</ol>";

echo "</body></html>";

