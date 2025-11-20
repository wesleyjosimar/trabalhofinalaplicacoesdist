<?php
$titulo = 'Novo Teste - CBF Antidoping';
ob_start();
?>
<div class="card">
    <h2>Novo Teste Antidoping</h2>
    <form method="POST">
        <div class="form-group">
            <label>Atleta *:</label>
            <select name="atleta_id" required>
                <option value="">Selecione um atleta</option>
                <?php foreach ($atletas as $atleta): ?>
                    <option value="<?= $atleta['id'] ?>" <?= (isset($_GET['atleta_id']) && $_GET['atleta_id'] == $atleta['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($atleta['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Data de Coleta *:</label>
            <input type="date" name="data_coleta" value="<?= date('Y-m-d') ?>" required>
        </div>
        <div class="form-group">
            <label>Competição:</label>
            <input type="text" name="competicao">
        </div>
        <div class="form-group">
            <label>Laboratório *:</label>
            <input type="text" name="laboratorio" required>
        </div>
        <div class="form-group">
            <label>Resultado:</label>
            <select name="resultado">
                <option value="pendente">Pendente</option>
                <option value="negativo">Negativo</option>
                <option value="positivo">Positivo</option>
            </select>
        </div>
        <div class="form-group">
            <label>Observações:</label>
            <textarea name="observacoes" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="testes.php" class="btn">Cancelar</a>
    </form>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/../layout.php';

