<?php
/**
 * Arquivo de Teste - Verifica se PHP está funcionando
 */

echo "<!DOCTYPE html>";
echo "<html><head><meta charset='UTF-8'><title>Teste PHP</title></head><body>";
echo "<h1>✅ PHP está funcionando!</h1>";
echo "<p>Versão PHP: " . phpversion() . "</p>";
echo "<p>Servidor: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Filename: " . __FILE__ . "</p>";
echo "<hr>";
echo "<h2>Teste de Conexão com Banco</h2>";

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "<p style='color: green;'>✅ Conexão com banco: OK</p>";
    
    // Testar tabelas
    $tables = ['usuarios', 'atletas', 'testes'];
    foreach ($tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<p style='color: green;'>✅ Tabela '$table' existe</p>";
        } else {
            echo "<p style='color: red;'>❌ Tabela '$table' NÃO existe</p>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h2>Links</h2>";
echo "<ul>";
echo "<li><a href='login.php'>Login</a></li>";
echo "<li><a href='index.php'>Index</a></li>";
echo "</ul>";
echo "</body></html>";

