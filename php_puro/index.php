<?php
/**
 * Index Principal - PHP Puro
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/controllers/AuthController.php';

AuthController::verificarAutenticacao();

header('Location: /atletas.php');
exit;

