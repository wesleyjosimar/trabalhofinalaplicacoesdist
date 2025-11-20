<?php
$titulo = 'Usuários - CBF Antidoping';
ob_start();
?>
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Usuários</h2>
        <a href="usuarios.php?acao=create" class="btn">Novo Usuário</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Data Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($usuarios)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem;">Nenhum usuário encontrado</td>
                </tr>
            <?php else: ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['nome']) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= ucfirst($usuario['perfil']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($usuario['created_at'])) ?></td>
                        <td>
                            <a href="usuarios.php?acao=edit&id=<?= $usuario['id'] ?>" class="btn">Editar</a>
                            <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                                <a href="usuarios.php?acao=delete&id=<?= $usuario['id'] ?>" class="btn btn-danger" onclick="return confirm('Deseja excluir este usuário?')">Excluir</a>
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

