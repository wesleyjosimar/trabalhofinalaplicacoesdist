<?php
$titulo = 'Editar Teste - CBF Antidoping';
ob_start();
?>
<div class="card">
    <h2>Editar Teste Antidoping</h2>
    <form method="POST">
        <div class="form-group">
            <label>Atleta *:</label>
            <select name="atleta_id" required>
                <?php foreach ($atletas as $atleta): ?>
                    <option value="<?= $atleta['id'] ?>" <?= $teste['atleta_id'] == $atleta['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($atleta['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Data de Coleta *:</label>
            <input type="date" name="data_coleta" value="<?= $teste['data_coleta'] ?>" required>
        </div>
        <div class="form-group">
            <label>Competição:</label>
            <input type="text" name="competicao" value="<?= htmlspecialchars($teste['competicao'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Laboratório *:</label>
            <input type="text" name="laboratorio" value="<?= htmlspecialchars($teste['laboratorio']) ?>" required>
        </div>
        <div class="form-group">
            <label>Resultado:</label>
            <select name="resultado">
                <option value="pendente" <?= $teste['resultado'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                <option value="negativo" <?= $teste['resultado'] === 'negativo' ? 'selected' : '' ?>>Negativo</option>
                <option value="positivo" <?= $teste['resultado'] === 'positivo' ? 'selected' : '' ?>>Positivo</option>
            </select>
        </div>
        <div class="form-group">
            <label>Observações:</label>
            <textarea name="observacoes" rows="4"><?= htmlspecialchars($teste['observacoes'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="testes.php" class="btn">Cancelar</a>
    </form>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/layout.php';

