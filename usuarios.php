<?php
/**
 * Página de Usuários (apenas admin)
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/UsuarioController.php';

$controller = new UsuarioController();
$acao = $_GET['acao'] ?? 'index';

switch ($acao) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
}

