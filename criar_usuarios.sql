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
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
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
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
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

