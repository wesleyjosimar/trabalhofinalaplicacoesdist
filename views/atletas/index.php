<?php
$titulo = 'Atletas - CBF Antidoping';
ob_start();
?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Atletas</h2>
        <a href="atletas.php?acao=create" class="btn">Novo Atleta</a>
    </div>
    
    <form method="GET" style="margin-bottom: 1rem; display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
        <input type="text" name="filtro" placeholder="Buscar por nome ou documento..." value="<?= htmlspecialchars($_GET['filtro'] ?? '') ?>" style="flex: 1; min-width: 250px; padding: 0.5rem;">
        <select name="status_filtro" style="padding: 0.5rem;">
            <option value="">Todos os status</option>
            <option value="ativo" <?= ($_GET['status_filtro'] ?? '') === 'ativo' ? 'selected' : '' ?>>Apenas Ativos</option>
            <option value="inativo" <?= ($_GET['status_filtro'] ?? '') === 'inativo' ? 'selected' : '' ?>>Apenas Inativos</option>
        </select>
        <button type="submit" class="btn">🔍 Buscar</button>
        <?php if (!empty($_GET['filtro']) || !empty($_GET['status_filtro'])): ?>
            <a href="atletas.php" class="btn" style="background: #666;">Limpar</a>
        <?php endif; ?>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Documento</th>
                <th>Data Nascimento</th>
                <th>Clube</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($atletas)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem;">Nenhum atleta encontrado</td>
                </tr>
            <?php else: ?>
                <?php foreach ($atletas as $atleta): ?>
                    <tr>
                        <td><?= htmlspecialchars($atleta['nome']) ?></td>
                        <td><?= htmlspecialchars($atleta['documento']) ?></td>
                        <td><?= date('d/m/Y', strtotime($atleta['data_nascimento'])) ?></td>
                        <td><?= htmlspecialchars($atleta['clube'] ?? '-') ?></td>
                        <td><?= ucfirst($atleta['status']) ?></td>
                        <td>
                            <a href="atletas.php?acao=show&id=<?= $atleta['id'] ?>" class="btn">Ver</a>
                            <a href="atletas.php?acao=edit&id=<?= $atleta['id'] ?>" class="btn">Editar</a>
                            <?php if ($atleta['status'] === 'ativo'): ?>
                                <a href="atletas.php?acao=inativar&id=<?= $atleta['id'] ?>" class="btn btn-danger" onclick="return confirm('Deseja inativar este atleta?')">Inativar</a>
                            <?php endif; ?>
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

