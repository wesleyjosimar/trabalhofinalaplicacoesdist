<?php
/**
 * Arquivo de Teste - Diagnóstico do Sistema
 * Acesse: http://localhost/cbf/teste.php
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Database.php';

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste do Sistema - CBF Antidoping</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 2rem; border-radius: 5px; }
        h1 { color: #0066cc; }
        .ok { color: #4caf50; }
        .erro { color: #f44336; }
        .info { background: #e3f2fd; padding: 1rem; border-radius: 5px; margin: 1rem 0; }
        ul { list-style: none; padding: 0; }
        li { padding: 0.5rem 0; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏆 Teste do Sistema CBF Antidoping</h1>
        
        <div class="info">
            <h2>Informações do Servidor</h2>
            <ul>
                <li><strong>PHP:</strong> <?= phpversion() ?></li>
                <li><strong>Servidor:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></li>
                <li><strong>Document Root:</strong> <?= $_SERVER['DOCUMENT_ROOT'] ?? 'N/A' ?></li>
            </ul>
        </div>

        <div class="info">
            <h2>Teste de Conexão com Banco</h2>
            <?php
            try {
                $db = Database::getInstance()->getConnection();
                echo "<p class='ok'>✅ Conexão com banco: OK</p>";
                
                $tables = ['usuarios', 'atletas', 'testes', 'sessions'];
                foreach ($tables as $table) {
                    $stmt = $db->query("SHOW TABLES LIKE '$table'");
                    if ($stmt->rowCount() > 0) {
                        echo "<p class='ok'>✅ Tabela '$table' existe</p>";
                    } else {
                        echo "<p class='erro'>❌ Tabela '$table' NÃO existe</p>";
                    }
                }
            } catch (Exception $e) {
                echo "<p class='erro'>❌ Erro: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            ?>
        </div>

        <div class="info">
            <h2>Links do Sistema</h2>
            <ul>
                <li><a href="login.php">Login</a></li>
                <li><a href="index.php">Página Inicial</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
