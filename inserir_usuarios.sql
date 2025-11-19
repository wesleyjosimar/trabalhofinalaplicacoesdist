-- ============================================================================
-- INSERIR USUÁRIOS - EXECUTE NO phpMyAdmin
-- ============================================================================

USE amorexpr_teste;

-- Administrador
-- Email: admin@cbf.com.br
-- Senha: admin123
INSERT INTO usuarios (nome, email, senha, perfil, created_at, updated_at) 
VALUES ('Administrador', 'admin@cbf.com.br', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'admin', NOW(), NOW());

-- Operador
-- Email: operador@cbf.com.br
-- Senha: operador123
INSERT INTO usuarios (nome, email, senha, perfil, created_at, updated_at) 
VALUES ('Operador', 'operador@cbf.com.br', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'operacional', NOW(), NOW());

-- ============================================================================
-- LOGIN:
-- admin@cbf.com.br / admin123
-- operador@cbf.com.br / operador123
-- ============================================================================

