<?php
/**
 * Página de Login
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/AuthController.php';

// Se já estiver logado, redireciona
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

$controller = new AuthController();
$controller->login();

