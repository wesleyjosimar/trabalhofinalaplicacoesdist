<?php
/**
 * Script para verificar se o deploy está correto
 * Execute após fazer upload dos arquivos
 * Acesse: https://seu-dominio.com.br/verificar_deploy.php
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
    <title>Verificação de Deploy - CBF Antidoping</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 2rem; border-radius: 5px; }
        h1 { color: #0066cc; }
        .ok { color: #4caf50; font-weight: bold; }
        .erro { color: #f44336; font-weight: bold; }
        .aviso { color: #ff9800; font-weight: bold; }
        .info { background: #e3f2fd; padding: 1rem; border-radius: 5px; margin: 1rem 0; }
        ul { list-style: none; padding: 0; }
        li { padding: 0.5rem 0; border-bottom: 1px solid #eee; }
        .checklist { margin: 1rem 0; }
        .checklist-item { padding: 0.5rem; margin: 0.5rem 0; border-left: 4px solid #ddd; }
        .checklist-item.ok { border-left-color: #4caf50; background: #e8f5e9; }
        .checklist-item.erro { border-left-color: #f44336; background: #ffebee; }
        .checklist-item.aviso { border-left-color: #ff9800; background: #fff3e0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Verificação de Deploy - CBF Antidoping</h1>
        
        <div class="checklist">
            <h2>Checklist de Verificação</h2>
            
            <?php
            $erros = 0;
            $avisos = 0;
            
            // 1. Verificar PHP
            echo '<div class="checklist-item ok">';
            echo '✅ PHP Version: ' . phpversion();
            echo '</div>';
            
            // 2. Verificar extensões necessárias
            $extensoes = ['pdo', 'pdo_mysql', 'session'];
            foreach ($extensoes as $ext) {
                if (extension_loaded($ext)) {
                    echo '<div class="checklist-item ok">✅ Extensão ' . $ext . ' carregada</div>';
                } else {
                    echo '<div class="checklist-item erro">❌ Extensão ' . $ext . ' NÃO encontrada</div>';
                    $erros++;
                }
            }
            
            // 3. Verificar conexão com banco
            try {
                $db = Database::getInstance()->getConnection();
                echo '<div class="checklist-item ok">✅ Conexão com banco: OK</div>';
                
                // 4. Verificar tabelas
                $tables = ['usuarios', 'atletas', 'testes', 'sessions'];
                foreach ($tables as $table) {
                    $stmt = $db->query("SHOW TABLES LIKE '$table'");
                    if ($stmt->rowCount() > 0) {
                        echo '<div class="checklist-item ok">✅ Tabela \'' . $table . '\' existe</div>';
                    } else {
                        echo '<div class="checklist-item erro">❌ Tabela \'' . $table . '\' NÃO existe</div>';
                        $erros++;
                    }
                }
                
                // 5. Verificar usuários
                require_once __DIR__ . '/models/Usuario.php';
                $usuarioModel = new Usuario();
                $usuarios = $usuarioModel->listar();
                if (count($usuarios) > 0) {
                    echo '<div class="checklist-item ok">✅ Usuários encontrados: ' . count($usuarios) . '</div>';
                } else {
                    echo '<div class="checklist-item aviso">⚠️ Nenhum usuário encontrado - Execute inserir_usuarios.sql</div>';
                    $avisos++;
                }
                
            } catch (Exception $e) {
                echo '<div class="checklist-item erro">❌ Erro de conexão: ' . htmlspecialchars($e->getMessage()) . '</div>';
                echo '<div class="checklist-item aviso">⚠️ Verifique o config.php</div>';
                $erros++;
            }
            
            // 6. Verificar APP_DEBUG
            if (APP_DEBUG) {
                echo '<div class="checklist-item aviso">⚠️ APP_DEBUG está TRUE - Altere para FALSE em produção!</div>';
                $avisos++;
            } else {
                echo '<div class="checklist-item ok">✅ APP_DEBUG está FALSE (correto para produção)</div>';
            }
            
            // 7. Verificar HTTPS
            $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
            if ($isHttps) {
                echo '<div class="checklist-item ok">✅ HTTPS está ativo</div>';
            } else {
                echo '<div class="checklist-item aviso">⚠️ HTTPS não detectado - Configure SSL em produção</div>';
                $avisos++;
            }
            
            // 8. Verificar arquivos importantes
            $arquivos = ['config.php', 'Database.php', 'login.php', '.htaccess'];
            foreach ($arquivos as $arquivo) {
                if (file_exists($arquivo)) {
                    echo '<div class="checklist-item ok">✅ Arquivo \'' . $arquivo . '\' existe</div>';
                } else {
                    echo '<div class="checklist-item erro">❌ Arquivo \'' . $arquivo . '\' NÃO encontrado</div>';
                    $erros++;
                }
            }
            ?>
        </div>
        
        <div class="info">
            <h3>Resumo</h3>
            <?php if ($erros == 0 && $avisos == 0): ?>
                <p class="ok">✅ Tudo está correto! Sistema pronto para uso.</p>
            <?php elseif ($erros == 0): ?>
                <p class="aviso">⚠️ Sistema funcional, mas há alguns avisos. Verifique acima.</p>
            <?php else: ?>
                <p class="erro">❌ Encontrados <?= $erros ?> erro(s). Corrija antes de usar em produção.</p>
            <?php endif; ?>
        </div>
        
        <div class="info">
            <h3>Próximos Passos</h3>
            <ul>
                <li><a href="login.php">Testar Login</a></li>
                <li><a href="atletas.php">Testar Atletas</a></li>
                <li><a href="relatorios.php">Testar Relatórios</a></li>
            </ul>
        </div>
        
        <div class="info" style="background: #ffebee; margin-top: 2rem;">
            <p><strong>⚠️ IMPORTANTE:</strong> Após verificar tudo, remova ou proteja este arquivo (verificar_deploy.php) por segurança!</p>
        </div>
    </div>
</body>
</html>

