<?php
$titulo = 'Login - CBF Antidoping';
ob_start();
?>
<div class="card" style="max-width: 400px; margin: 5rem auto;">
    <h2>Login</h2>
    <form method="POST">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Senha:</label>
            <input type="password" name="senha" required>
        </div>
        <button type="submit" class="btn">Entrar</button>
    </form>
    <?php if (isset($erro)): ?>
        <div class="alert alert-error" style="margin-top: 1rem;"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/layout.php';

