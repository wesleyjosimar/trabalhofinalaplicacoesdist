<?php
/**
 * Diagnóstico Completo do Banco de Dados
 * Acesse: http://localhost/cbf/diagnostico_banco.php
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Diagnóstico do Banco - CBF Antidoping</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 2rem; border-radius: 5px; }
        h1 { color: #0066cc; }
        h2 { color: #333; border-bottom: 2px solid #0066cc; padding-bottom: 0.5rem; }
        .ok { color: #4caf50; font-weight: bold; }
        .erro { color: #f44336; font-weight: bold; }
        .aviso { color: #ff9800; font-weight: bold; }
        .info { background: #e3f2fd; padding: 1rem; border-radius: 5px; margin: 1rem 0; }
        .erro-box { background: #ffebee; padding: 1rem; border-radius: 5px; margin: 1rem 0; border-left: 4px solid #f44336; }
        .ok-box { background: #e8f5e9; padding: 1rem; border-radius: 5px; margin: 1rem 0; border-left: 4px solid #4caf50; }
        pre { background: #f5f5f5; padding: 1rem; border-radius: 5px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        th, td { padding: 0.5rem; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #0066cc; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Diagnóstico Completo do Banco de Dados</h1>
        
        <?php
        // 1. Verificar PHP
        echo '<h2>1. Informações do PHP</h2>';
        echo '<div class="info">';
        echo '<p><strong>Versão PHP:</strong> ' . phpversion() . '</p>';
        echo '<p><strong>Extensão PDO:</strong> ' . (extension_loaded('pdo') ? '<span class="ok">✅ Carregada</span>' : '<span class="erro">❌ Não encontrada</span>') . '</p>';
        echo '<p><strong>Extensão PDO MySQL:</strong> ' . (extension_loaded('pdo_mysql') ? '<span class="ok">✅ Carregada</span>' : '<span class="erro">❌ Não encontrada</span>') . '</p>';
        echo '</div>';
        
        // 2. Verificar config.php
        echo '<h2>2. Configurações do Banco</h2>';
        if (file_exists(__DIR__ . '/config.php')) {
            require_once __DIR__ . '/config.php';
            echo '<div class="info">';
            echo '<p><strong>DB_HOST:</strong> ' . (defined('DB_HOST') ? DB_HOST : '<span class="erro">Não definido</span>') . '</p>';
            echo '<p><strong>DB_PORT:</strong> ' . (defined('DB_PORT') ? DB_PORT : '<span class="erro">Não definido</span>') . '</p>';
            echo '<p><strong>DB_NAME:</strong> ' . (defined('DB_NAME') ? DB_NAME : '<span class="erro">Não definido</span>') . '</p>';
            echo '<p><strong>DB_USER:</strong> ' . (defined('DB_USER') ? DB_USER : '<span class="erro">Não definido</span>') . '</p>';
            echo '<p><strong>DB_PASS:</strong> ' . (defined('DB_PASS') ? (DB_PASS ? '*** (definida)' : '<span class="aviso">⚠️ Vazia</span>') : '<span class="erro">Não definida</span>') . '</p>';
            echo '</div>';
        } else {
            echo '<div class="erro-box">❌ Arquivo config.php não encontrado!</div>';
        }
        
        // 3. Testar conexão direta
        echo '<h2>3. Teste de Conexão</h2>';
        try {
            if (!defined('DB_HOST')) {
                throw new Exception('Configurações não carregadas');
            }
            
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=" . DB_CHARSET;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            
            echo '<div class="ok-box">✅ Conexão com MySQL estabelecida com sucesso!</div>';
            
            // Verificar versão do MySQL
            $stmt = $pdo->query("SELECT VERSION() as version");
            $version = $stmt->fetch();
            echo '<p><strong>Versão MySQL/MariaDB:</strong> ' . htmlspecialchars($version['version']) . '</p>';
            
            // Verificar se o banco existe
            $stmt = $pdo->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
            if ($stmt->rowCount() > 0) {
                echo '<div class="ok-box">✅ Banco de dados "' . DB_NAME . '" existe!</div>';
                
                // Conectar ao banco específico
                $pdo->exec("USE " . DB_NAME);
                
                // Listar tabelas
                echo '<h2>4. Tabelas do Banco</h2>';
                $stmt = $pdo->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                
                if (empty($tables)) {
                    echo '<div class="erro-box">❌ Nenhuma tabela encontrada! Execute database.sql</div>';
                } else {
                    echo '<div class="ok-box">✅ Encontradas ' . count($tables) . ' tabela(s):</div>';
                    echo '<ul>';
                    foreach ($tables as $table) {
                        echo '<li>' . htmlspecialchars($table) . '</li>';
                    }
                    echo '</ul>';
                    
                    // Verificar estrutura das tabelas principais
                    $tabelasEsperadas = ['usuarios', 'atletas', 'testes', 'sessions'];
                    echo '<h2>5. Verificação de Estrutura</h2>';
                    echo '<table>';
                    echo '<tr><th>Tabela</th><th>Status</th><th>Registros</th></tr>';
                    
                    foreach ($tabelasEsperadas as $tabela) {
                        if (in_array($tabela, $tables)) {
                            $stmt = $pdo->query("SELECT COUNT(*) as total FROM `$tabela`");
                            $count = $stmt->fetch()['total'];
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($tabela) . '</td>';
                            echo '<td><span class="ok">✅ Existe</span></td>';
                            echo '<td>' . $count . ' registro(s)</td>';
                            echo '</tr>';
                        } else {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($tabela) . '</td>';
                            echo '<td><span class="erro">❌ Não existe</span></td>';
                            echo '<td>-</td>';
                            echo '</tr>';
                        }
                    }
                    echo '</table>';
                }
                
                // Testar Database.php
                echo '<h2>6. Teste do Database.php</h2>';
                if (file_exists(__DIR__ . '/Database.php')) {
                    require_once __DIR__ . '/Database.php';
                    try {
                        $db = Database::getInstance()->getConnection();
                        echo '<div class="ok-box">✅ Database.php funcionando corretamente!</div>';
                    } catch (Exception $e) {
                        echo '<div class="erro-box">❌ Erro no Database.php: ' . htmlspecialchars($e->getMessage()) . '</div>';
                    }
                } else {
                    echo '<div class="erro-box">❌ Arquivo Database.php não encontrado!</div>';
                }
                
            } else {
                echo '<div class="erro-box">❌ Banco de dados "' . DB_NAME . '" NÃO existe!</div>';
                echo '<p>Execute no phpMyAdmin:</p>';
                echo '<pre>CREATE DATABASE ' . DB_NAME . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</pre>';
            }
            
        } catch (PDOException $e) {
            echo '<div class="erro-box">❌ Erro de conexão: ' . htmlspecialchars($e->getMessage()) . '</div>';
            echo '<h3>Possíveis causas:</h3>';
            echo '<ul>';
            echo '<li>MySQL/MariaDB não está rodando</li>';
            echo '<li>Credenciais incorretas no config.php</li>';
            echo '<li>Porta incorreta (padrão: 3306)</li>';
            echo '<li>Firewall bloqueando a conexão</li>';
            echo '</ul>';
            echo '<h3>Soluções:</h3>';
            echo '<ol>';
            echo '<li>Verifique se o MySQL está rodando no XAMPP Control Panel</li>';
            echo '<li>Teste a conexão no phpMyAdmin: <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></li>';
            echo '<li>Verifique o config.php (usuário padrão: root, senha: vazia)</li>';
            echo '<li>Verifique os logs do MySQL em: C:\\xampp\\mysql\\data\\*.err</li>';
            echo '</ol>';
        } catch (Exception $e) {
            echo '<div class="erro-box">❌ Erro: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        
        // 7. Verificar logs do MySQL
        echo '<h2>7. Sobre os Logs do MySQL</h2>';
        echo '<div class="info">';
        echo '<p><strong>Os logs que você viu são NORMAIS!</strong></p>';
        echo '<ul>';
        echo '<li><strong>[Note]</strong> = Apenas informações, não são erros</li>';
        echo '<li><strong>Crash recovery</strong> = Normal após desligamento não limpo</li>';
        echo '<li><strong>"ready for connections"</strong> = Servidor está funcionando!</li>';
        echo '<li><strong>InnoDB</strong> = Motor de armazenamento funcionando normalmente</li>';
        echo '</ul>';
        echo '<p>Se você ver <span class="erro">[Error]</span> ou <span class="aviso">[Warning]</span>, aí sim há problema.</p>';
        echo '</div>';
        ?>
        
        <hr>
        <div class="info">
            <h3>Próximos Passos</h3>
            <ul>
                <li><a href="testar_banco.php">Testar Banco e Criar Usuários</a></li>
                <li><a href="login.php">Testar Login</a></li>
                <li><a href="atletas.php">Testar Sistema</a></li>
            </ul>
        </div>
    </div>
</body>
</html>

