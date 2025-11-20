<?php
/**
 * Rotas para Relatórios
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/RelatorioController.php';

$acao = $_GET['acao'] ?? 'index';
$controller = new RelatorioController();

if ($acao === 'exportar') {
    $controller->exportar();
} else {
    $controller->index();
}

