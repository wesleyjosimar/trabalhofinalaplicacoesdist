<?php
$titulo = 'Editar Usuário - CBF Antidoping';
ob_start();
?>
<div class="card">
    <h2>Editar Usuário</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nome *:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        </div>
        <div class="form-group">
            <label>Email *:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
        </div>
        <div class="form-group">
            <label>Nova Senha (deixe em branco para não alterar):</label>
            <input type="password" name="senha">
        </div>
        <div class="form-group">
            <label>Perfil:</label>
            <select name="perfil">
                <option value="operacional" <?= $usuario['perfil'] === 'operacional' ? 'selected' : '' ?>>Operacional</option>
                <option value="admin" <?= $usuario['perfil'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="usuarios.php" class="btn">Cancelar</a>
    </form>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/layout.php';

