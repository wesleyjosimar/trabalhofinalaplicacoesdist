<?php
$titulo = 'Relatórios - CBF Antidoping';
ob_start();
?>
<div class="card">
    <h2>Relatórios e Estatísticas</h2>
    
    <!-- Dashboard de Estatísticas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: #e3f2fd; padding: 1.5rem; border-radius: 5px; text-align: center;">
            <h3 style="margin: 0; color: #1976d2;"><?= $total_atletas ?></h3>
            <p style="margin: 0.5rem 0 0 0; color: #666;">Total de Atletas</p>
        </div>
        <div style="background: #e8f5e9; padding: 1.5rem; border-radius: 5px; text-align: center;">
            <h3 style="margin: 0; color: #388e3c;"><?= $atletas_ativos ?></h3>
            <p style="margin: 0.5rem 0 0 0; color: #666;">Atletas Ativos</p>
        </div>
        <div style="background: #fff3e0; padding: 1.5rem; border-radius: 5px; text-align: center;">
            <h3 style="margin: 0; color: #f57c00;"><?= $total_testes ?></h3>
            <p style="margin: 0.5rem 0 0 0; color: #666;">Total de Testes</p>
        </div>
        <div style="background: #fce4ec; padding: 1.5rem; border-radius: 5px; text-align: center;">
            <h3 style="margin: 0; color: #c2185b;"><?= $testes_pendentes ?></h3>
            <p style="margin: 0.5rem 0 0 0; color: #666;">Testes Pendentes</p>
        </div>
        <div style="background: #e8f5e9; padding: 1.5rem; border-radius: 5px; text-align: center;">
            <h3 style="margin: 0; color: #388e3c;"><?= $testes_negativos ?></h3>
            <p style="margin: 0.5rem 0 0 0; color: #666;">Testes Negativos</p>
        </div>
        <div style="background: #ffebee; padding: 1.5rem; border-radius: 5px; text-align: center;">
            <h3 style="margin: 0; color: #d32f2f;"><?= $testes_positivos ?></h3>
            <p style="margin: 0.5rem 0 0 0; color: #666;">Testes Positivos</p>
        </div>
    </div>

    <!-- Filtros -->
    <div style="background: #f5f5f5; padding: 1.5rem; border-radius: 5px; margin-bottom: 2rem;">
        <h3 style="margin-top: 0;">Filtros de Relatório</h3>
        <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
            <div>
                <label>Resultado:</label>
                <select name="filtro" style="width: 100%; padding: 0.5rem;">
                    <option value="todos" <?= $filtro === 'todos' ? 'selected' : '' ?>>Todos</option>
                    <option value="pendente" <?= $filtro === 'pendente' ? 'selected' : '' ?>>Pendentes</option>
                    <option value="negativo" <?= $filtro === 'negativo' ? 'selected' : '' ?>>Negativos</option>
                    <option value="positivo" <?= $filtro === 'positivo' ? 'selected' : '' ?>>Positivos</option>
                </select>
            </div>
            <div>
                <label>Data Início:</label>
                <input type="date" name="data_inicio" value="<?= htmlspecialchars($data_inicio) ?>" style="width: 100%; padding: 0.5rem;">
            </div>
            <div>
                <label>Data Fim:</label>
                <input type="date" name="data_fim" value="<?= htmlspecialchars($data_fim) ?>" style="width: 100%; padding: 0.5rem;">
            </div>
            <div>
                <button type="submit" class="btn">Filtrar</button>
                <a href="relatorios.php" class="btn" style="background: #666;">Limpar</a>
            </div>
        </form>
    </div>

    <!-- Botão de Exportação -->
    <div style="margin-bottom: 1rem;">
        <a href="relatorios.php?acao=exportar&filtro=<?= urlencode($filtro) ?>" class="btn" style="background: #4caf50;">
            📥 Exportar para CSV
        </a>
    </div>

    <!-- Tabela de Testes Filtrados -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Atleta</th>
                <th>Data Coleta</th>
                <th>Competição</th>
                <th>Laboratório</th>
                <th>Resultado</th>
                <th>Observações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($testes_filtrados)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">Nenhum teste encontrado com os filtros selecionados</td>
                </tr>
            <?php else: ?>
                <?php 
                $atletaModel = new Atleta();
                foreach ($testes_filtrados as $teste): 
                    $atleta = $atletaModel->buscarPorId($teste['atleta_id']);
                    $corResultado = [
                        'pendente' => '#ff9800',
                        'negativo' => '#4caf50',
                        'positivo' => '#f44336'
                    ];
                ?>
                    <tr>
                        <td><?= $teste['id'] ?></td>
                        <td><?= htmlspecialchars($atleta['nome'] ?? 'N/A') ?></td>
                        <td><?= date('d/m/Y', strtotime($teste['data_coleta'])) ?></td>
                        <td><?= htmlspecialchars($teste['competicao'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($teste['laboratorio']) ?></td>
                        <td>
                            <span style="background: <?= $corResultado[$teste['resultado']] ?? '#666' ?>; color: white; padding: 0.25rem 0.5rem; border-radius: 3px; font-size: 0.9rem;">
                                <?= ucfirst($teste['resultado']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($teste['observacoes'] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
$conteudo = ob_get_clean();
include __DIR__ . '/../layout.php';

