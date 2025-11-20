<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'CBF Antidoping' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header { background: #0066cc; color: white; padding: 1rem; }
        .header h1 { display: inline; }
        .nav { background: #004499; padding: 0.5rem; }
        .nav a { color: white; text-decoration: none; margin-right: 1rem; padding: 0.5rem; }
        .nav a:hover { background: #0066cc; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 0.5rem 1rem; background: #0066cc; color: white; text-decoration: none; border-radius: 3px; border: none; cursor: pointer; }
        .btn:hover { background: #004499; }
        .btn-danger { background: #cc0000; }
        .btn-success { background: #00cc00; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #ddd; }
        table th { background: #f0f0f0; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 3px; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 3px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .user-info { float: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏆 CBF Antidoping</h1>
        <div class="user-info">
            <?php if (isset($_SESSION['usuario_nome'])): ?>
                <span><?= htmlspecialchars($_SESSION['usuario_nome']) ?> (<?= $_SESSION['usuario_perfil'] ?>)</span>
                <a href="logout.php" style="color: white; margin-left: 1rem;">Sair</a>
            <?php endif; ?>
        </div>
        <div style="clear: both;"></div>
    </div>
    
    <?php if (isset($_SESSION['usuario_id'])): ?>
    <div class="nav">
        <a href="index.php">Início</a>
                <a href="atletas.php">Atletas</a>
                <a href="testes.php">Testes</a>
                <a href="relatorios.php">Relatórios</a>
        <?php if ($_SESSION['usuario_perfil'] === 'admin'): ?>
            <a href="usuarios.php">Usuários</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <div class="container">
        <?php if (isset($erro)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
        
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">Operação realizada com sucesso!</div>
        <?php endif; ?>
        
        <?= $conteudo ?? '' ?>
    </div>
</body>
</html>

