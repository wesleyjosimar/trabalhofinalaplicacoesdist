-- ============================================================================
-- INSERIR USUÁRIOS - EXECUTE NO phpMyAdmin
-- ============================================================================

USE cbf_antidoping;

-- Limpar usuários existentes (opcional - descomente se quiser)
-- DELETE FROM usuarios WHERE email IN ('admin@cbf.com.br', 'operador@cbf.com.br');

-- Administrador
-- Email: admin@cbf.com.br
-- Senha: admin123
INSERT INTO usuarios (nome, email, senha, perfil, created_at, updated_at) 
VALUES (
    'Administrador', 
    'admin@cbf.com.br', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'admin', 
    NOW(), 
    NOW()
);

-- Operador
-- Email: operador@cbf.com.br
-- Senha: operador123
INSERT INTO usuarios (nome, email, senha, perfil, created_at, updated_at) 
VALUES (
    'Operador', 
    'operador@cbf.com.br', 
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'operacional', 
    NOW(), 
    NOW()
);

-- ============================================================================
-- LOGIN:
-- admin@cbf.com.br / admin123
-- operador@cbf.com.br / operador123
-- ============================================================================

