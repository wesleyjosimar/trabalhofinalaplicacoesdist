<?php
/**
 * Página de Testes
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/TesteController.php';

$controller = new TesteController();
$acao = $_GET['acao'] ?? 'index';

switch ($acao) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    default:
        $controller->index();
}

