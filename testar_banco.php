<?php
/**
 * Script para testar conexão e criar usuários
 * Acesse: http://localhost/cbf/testar_banco.php
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/models/Usuario.php';

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Teste de Banco - CBF Antidoping</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 2rem; border-radius: 5px; }
        .ok { color: #4caf50; }
        .erro { color: #f44336; }
        .aviso { color: #ff9800; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Teste de Conexão e Usuários</h1>
        
        <?php
        try {
            $db = Database::getInstance()->getConnection();
            echo "<p class='ok'>✅ Conexão com banco: OK</p>";
            
            $tables = ['usuarios', 'atletas', 'testes'];
            foreach ($tables as $table) {
                $stmt = $db->query("SHOW TABLES LIKE '$table'");
                if ($stmt->rowCount() > 0) {
                    echo "<p class='ok'>✅ Tabela '$table' existe</p>";
                } else {
                    echo "<p class='erro'>❌ Tabela '$table' NÃO existe - Execute database.sql</p>";
                }
            }
            
            $usuarioModel = new Usuario();
            $usuarios = $usuarioModel->listar();
            
            if (empty($usuarios)) {
                echo "<p class='aviso'>⚠️ Nenhum usuário encontrado. Criando usuários...</p>";
                
                $usuariosParaCriar = [
                    ['nome' => 'Administrador', 'email' => 'admin@cbf.com.br', 'senha' => 'admin123', 'perfil' => 'admin'],
                    ['nome' => 'Operador', 'email' => 'operador@cbf.com.br', 'senha' => 'operador123', 'perfil' => 'operacional']
                ];
                
                foreach ($usuariosParaCriar as $usuario) {
                    if ($usuarioModel->criar($usuario)) {
                        echo "<p class='ok'>✅ Usuário criado: {$usuario['email']}</p>";
                    } else {
                        echo "<p class='erro'>❌ Erro ao criar: {$usuario['email']}</p>";
                    }
                }
            } else {
                echo "<p class='ok'>✅ Usuários encontrados:</p><ul>";
                foreach ($usuarios as $usuario) {
                    echo "<li>{$usuario['email']} ({$usuario['perfil']})</li>";
                }
                echo "</ul>";
                
                $admin = $usuarioModel->buscarPorEmail('admin@cbf.com.br');
                if ($admin) {
                    $senhaOk = $usuarioModel->verificarSenha('admin123', $admin['senha']);
                    if ($senhaOk) {
                        echo "<p class='ok'>✅ Senha do admin está correta!</p>";
                    } else {
                        echo "<p class='erro'>❌ Senha do admin está INCORRETA! Recriando usuário...</p>";
                        $usuarioModel->excluir($admin['id']);
                        $usuarioModel->criar([
                            'nome' => 'Administrador',
                            'email' => 'admin@cbf.com.br',
                            'senha' => 'admin123',
                            'perfil' => 'admin'
                        ]);
                        echo "<p class='ok'>✅ Usuário admin recriado!</p>";
                    }
                }
            }
            
        } catch (Exception $e) {
            echo "<p class='erro'>❌ Erro: " . htmlspecialchars($e->getMessage()) . "</p>";
            echo "<p>Verifique o config.php e se o banco cbf_antidoping existe.</p>";
        }
        ?>
        
        <hr>
        <p><a href="login.php">← Voltar para Login</a></p>
    </div>
</body>
</html>
