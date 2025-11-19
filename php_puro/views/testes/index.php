<?php
$titulo = 'Testes Antidoping - CBF Antidoping';
ob_start();
?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Testes Antidoping</h2>
        <a href="/testes.php?acao=create" class="btn">Novo Teste</a>
    </div>
    
    <form method="GET" style="margin-bottom: 1rem;">
        <select name="atleta_id" style="width: 300px; display: inline-block;">
            <option value="">Todos os atletas</option>
            <?php foreach ($atletas as $atleta): ?>
                <option value="<?= $atleta['id'] ?>" <?= (isset($_GET['atleta_id']) && $_GET['atleta_id'] == $atleta['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($atleta['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn">Filtrar</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Atleta</th>
                <th>Data Coleta</th>
                <th>Competição</th>
                <th>Laboratório</th>
                <th>Resultado</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($testes)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem;">Nenhum teste encontrado</td>
                </tr>
            <?php else: ?>
                <?php foreach ($testes as $teste): ?>
                    <tr>
                        <td><?= htmlspecialchars($teste['atleta_nome']) ?></td>
                        <td><?= date('d/m/Y', strtotime($teste['data_coleta'])) ?></td>
                        <td><?= htmlspecialchars($teste['competicao'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($teste['laboratorio']) ?></td>
                        <td><?= ucfirst($teste['resultado']) ?></td>
                        <td>
                            <a href="/testes.php?acao=edit&id=<?= $teste['id'] ?>" class="btn">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/layout.php';

