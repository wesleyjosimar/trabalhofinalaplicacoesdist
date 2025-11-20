<?php
$titulo = 'Login - CBF Antidoping';
ob_start();
?>
<div class="card" style="max-width: 400px; margin: 5rem auto;">
    <h2>Login</h2>
    <form method="POST">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="admin@cbf.com.br" required>
        </div>
        <div class="form-group">
            <label>Senha:</label>
            <input type="password" name="senha" value="admin123" required>
        </div>
        <button type="submit" class="btn">Entrar</button>
    </form>
    <?php if (isset($erro)): ?>
        <div class="alert alert-error" style="margin-top: 1rem;"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    
    <div style="margin-top: 2rem; padding: 1rem; background: #f0f0f0; border-radius: 5px; font-size: 0.9rem;">
        <strong>Credenciais de Acesso:</strong><br>
        <strong>Admin:</strong> admin@cbf.com.br / admin123<br>
        <strong>Operador:</strong> operador@cbf.com.br / operador123
    </div>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/../layout.php';

