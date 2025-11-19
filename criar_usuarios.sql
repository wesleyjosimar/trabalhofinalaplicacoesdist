-- ============================================================================
-- CRIAR USUÁRIOS PADRÃO NO BANCO DE DADOS
-- ============================================================================
-- Execute este script no phpMyAdmin para criar os usuários
-- ============================================================================

USE amorexpr_teste;

-- Inserir usuário Administrador
-- Email: admin@cbf.com.br
-- Senha: admin123
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `perfil`, `created_at`, `updated_at`) 
VALUES (
    'Administrador', 
    'admin@cbf.com.br', 
    '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 
    'admin', 
    NOW(), 
    NOW()
)
ON DUPLICATE KEY UPDATE 
    `nome` = VALUES(`nome`),
    `perfil` = VALUES(`perfil`);

-- Inserir usuário Operador
-- Email: operador@cbf.com.br
-- Senha: operador123
INSERT INTO `usuarios` (`nome`, `email`, `senha`, `perfil`, `created_at`, `updated_at`) 
VALUES (
    'Operador', 
    'operador@cbf.com.br', 
    '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 
    'operacional', 
    NOW(), 
    NOW()
)
ON DUPLICATE KEY UPDATE 
    `nome` = VALUES(`nome`),
    `perfil` = VALUES(`perfil`);

-- ============================================================================
-- CREDENCIAIS DE LOGIN:
-- ============================================================================
-- Administrador:
--   Email: admin@cbf.com.br
--   Senha: admin123
--
-- Operador:
--   Email: operador@cbf.com.br
--   Senha: operador123
-- ============================================================================

