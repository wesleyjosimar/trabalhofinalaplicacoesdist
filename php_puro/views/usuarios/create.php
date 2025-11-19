<?php
$titulo = 'Novo Usuário - CBF Antidoping';
ob_start();
?>
<div class="card">
    <h2>Novo Usuário</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nome *:</label>
            <input type="text" name="nome" required>
        </div>
        <div class="form-group">
            <label>Email *:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Senha *:</label>
            <input type="password" name="senha" required>
        </div>
        <div class="form-group">
            <label>Perfil:</label>
            <select name="perfil">
                <option value="operacional">Operacional</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="/usuarios.php" class="btn">Cancelar</a>
    </form>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/layout.php';

