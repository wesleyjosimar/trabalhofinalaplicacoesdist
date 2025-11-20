<?php
$titulo = 'Novo Atleta - CBF Antidoping';
ob_start();
?>
<div class="card">
    <h2>Novo Atleta</h2>
    <form method="POST">
        <div class="form-group">
            <label>Nome *:</label>
            <input type="text" name="nome" required>
        </div>
        <div class="form-group">
            <label>Data de Nascimento *:</label>
            <input type="date" name="data_nascimento" required>
        </div>
        <div class="form-group">
            <label>Documento *:</label>
            <input type="text" name="documento" required>
        </div>
        <div class="form-group">
            <label>Clube:</label>
            <input type="text" name="clube">
        </div>
        <div class="form-group">
            <label>Federação:</label>
            <input type="text" name="federacao">
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status">
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="atletas.php" class="btn">Cancelar</a>
    </form>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/../layout.php';

