<?php
/**
 * Configuração da Aplicação - PRODUÇÃO
 * 
 * INSTRUÇÕES:
 * 1. Edite este arquivo com as credenciais do seu banco externo
 * 2. Renomeie para config.php
 * 3. Faça upload para o servidor
 */

// ============================================================================
// CONFIGURAÇÕES DO BANCO DE DADOS - PRODUÇÃO
// ============================================================================
// Preencha com as credenciais do seu banco externo
define('DB_HOST', 'localhost');           // Ex: mysql.seuservidor.com.br ou IP
define('DB_PORT', '3306');
define('DB_NAME', 'seu_banco_aqui');      // Nome do banco criado
define('DB_USER', 'seu_usuario_aqui');    // Usuário do banco
define('DB_PASS', 'sua_senha_aqui');      // Senha do banco
define('DB_CHARSET', 'utf8mb4');

// ============================================================================
// CONFIGURAÇÕES DA APLICAÇÃO
// ============================================================================
define('APP_NAME', 'CBF Antidoping');
define('APP_URL', 'https://seu-dominio.com.br');  // URL completa do seu site
define('APP_DEBUG', false);  // ⚠️ IMPORTANTE: false em produção!

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
    ini_set('log_errors', 1);
    ini_set('error_log', BASE_PATH . '/logs/php_errors.log');
}

