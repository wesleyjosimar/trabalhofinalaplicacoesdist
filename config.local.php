<?php
/**
 * Configuração LOCAL para XAMPP
 * Renomeie este arquivo para config.php quando for testar localmente
 */

// Configurações do banco de dados LOCAL
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'cbf_antidoping');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Configurações da aplicação
define('APP_NAME', 'CBF Antidoping');
define('APP_URL', 'http://localhost');
define('APP_DEBUG', true);

// Caminhos - ajustados para funcionar diretamente no subdomínio
define('BASE_PATH', __DIR__);
define('VIEWS_PATH', BASE_PATH . '/views');
define('MODELS_PATH', BASE_PATH . '/models');
define('CONTROLLERS_PATH', BASE_PATH . '/controllers');

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Exibir erros em modo debug
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

