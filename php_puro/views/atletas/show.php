<?php
$titulo = 'Detalhes do Atleta - CBF Antidoping';
ob_start();
?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2><?= htmlspecialchars($atleta['nome']) ?></h2>
        <div>
            <a href="/atletas.php?acao=edit&id=<?= $atleta['id'] ?>" class="btn">Editar</a>
            <a href="/atletas.php" class="btn">Voltar</a>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
        <div>
            <strong>Documento:</strong> <?= htmlspecialchars($atleta['documento']) ?>
        </div>
        <div>
            <strong>Data de Nascimento:</strong> <?= date('d/m/Y', strtotime($atleta['data_nascimento'])) ?>
        </div>
        <div>
            <strong>Clube:</strong> <?= htmlspecialchars($atleta['clube'] ?? '-') ?>
        </div>
        <div>
            <strong>Federação:</strong> <?= htmlspecialchars($atleta['federacao'] ?? '-') ?>
        </div>
        <div>
            <strong>Status:</strong> <?= ucfirst($atleta['status']) ?>
        </div>
    </div>
    
    <h3>Histórico de Testes</h3>
    <table>
        <thead>
            <tr>
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
                    <td colspan="5" style="text-align: center; padding: 2rem;">Nenhum teste registrado</td>
                </tr>
            <?php else: ?>
                <?php foreach ($testes as $teste): ?>
                    <tr>
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
    <div style="margin-top: 1rem;">
        <a href="/testes.php?acao=create&atleta_id=<?= $atleta['id'] ?>" class="btn btn-success">Novo Teste</a>
    </div>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/layout.php';

