<?php
$titulo = 'Testes Antidoping - CBF Antidoping';
ob_start();
?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Testes Antidoping</h2>
        <a href="testes.php?acao=create" class="btn">Novo Teste</a>
    </div>
    
    <form method="GET" style="margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
        <input type="text" name="filtro" placeholder="Buscar por atleta..." value="<?= htmlspecialchars($_GET['filtro'] ?? '') ?>" style="flex: 1; min-width: 250px; padding: 0.5rem;">
        <select name="resultado_filtro" style="padding: 0.5rem;">
            <option value="">Todos os resultados</option>
            <option value="pendente" <?= ($_GET['resultado_filtro'] ?? '') === 'pendente' ? 'selected' : '' ?>>Pendentes</option>
            <option value="negativo" <?= ($_GET['resultado_filtro'] ?? '') === 'negativo' ? 'selected' : '' ?>>Negativos</option>
            <option value="positivo" <?= ($_GET['resultado_filtro'] ?? '') === 'positivo' ? 'selected' : '' ?>>Positivos</option>
        </select>
        <button type="submit" class="btn">🔍 Buscar</button>
        <?php if (!empty($_GET['filtro']) || !empty($_GET['resultado_filtro'])): ?>
            <a href="testes.php" class="btn" style="background: #666;">Limpar</a>
        <?php endif; ?>
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
                <?php foreach ($testes as $teste): 
                    $corResultado = [
                        'pendente' => '#ff9800',
                        'negativo' => '#4caf50',
                        'positivo' => '#f44336'
                    ];
                    $cor = $corResultado[$teste['resultado']] ?? '#666';
                ?>
                    <tr>
                        <td><?= htmlspecialchars($teste['atleta_nome']) ?></td>
                        <td><?= date('d/m/Y', strtotime($teste['data_coleta'])) ?></td>
                        <td><?= htmlspecialchars($teste['competicao'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($teste['laboratorio']) ?></td>
                        <td>
                            <span style="background: <?= $cor ?>; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.9rem;">
                                <?= ucfirst($teste['resultado']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="testes.php?acao=edit&id=<?= $teste['id'] ?>" class="btn">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/../layout.php';
