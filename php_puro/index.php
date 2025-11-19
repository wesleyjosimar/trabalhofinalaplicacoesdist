<?php
/**
 * Index Principal - PHP Puro
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/AuthController.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

header('Location: atletas.php');
exit;

