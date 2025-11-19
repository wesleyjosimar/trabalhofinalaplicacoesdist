<?php
/**
 * Página de Atletas
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/AtletaController.php';

$controller = new AtletaController();
$acao = $_GET['acao'] ?? 'index';

switch ($acao) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'show':
        $controller->show();
        break;
    case 'inativar':
        $controller->inativar();
        break;
    default:
        $controller->index();
}

