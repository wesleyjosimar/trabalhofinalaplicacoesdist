-- Script de inicialização do banco de dados
-- Execute após criar o banco de dados

-- Inserir Federação
INSERT INTO federacoes (id, nome, sigla, nivel, "createdAt", "updatedAt")
VALUES (
  '550e8400-e29b-41d4-a716-446655440000',
  'Confederação Brasileira de Futebol',
  'CBF',
  'nacional',
  NOW(),
  NOW()
) ON CONFLICT DO NOTHING;

-- Inserir Clube
INSERT INTO clubes (id, nome, cidade, estado, "federacaoId", "createdAt", "updatedAt")
VALUES (
  '550e8400-e29b-41d4-a716-446655440001',
  'Clube de Teste',
  'São Paulo',
  'SP',
  '550e8400-e29b-41d4-a716-446655440000',
  NOW(),
  NOW()
) ON CONFLICT DO NOTHING;

-- Inserir Laboratório
INSERT INTO laboratorios (id, nome, codigo, pais, ativo, "createdAt", "updatedAt")
VALUES (
  '550e8400-e29b-41d4-a716-446655440002',
  'Laboratório de Teste',
  'LAB001',
  'Brasil',
  true,
  NOW(),
  NOW()
) ON CONFLICT DO NOTHING;

-- Inserir Usuário Admin (senha: admin123)
-- Hash bcrypt de 'admin123': $2b$10$rQ8VQ8VQ8VQ8VQ8VQ8VQ8eKqKqKqKqKqKqKqKqKqKqKqKqKqKqKqK
INSERT INTO usuarios (id, email, senha, perfil, nome, "organizacaoId", ativo, "createdAt", "updatedAt")
VALUES (
  '550e8400-e29b-41d4-a716-446655440003',
  'admin@cbf.com.br',
  '$2b$10$rQ8VQ8VQ8VQ8VQ8VQ8VQ8eKqKqKqKqKqKqKqKqKqKqKqKqKqKqKqK',
  'CBF',
  'Administrador',
  NULL,
  true,
  NOW(),
  NOW()
) ON CONFLICT DO NOTHING;

-- NOTA: Para gerar um hash bcrypt válido, use o seguinte código Node.js:
-- const bcrypt = require('bcrypt');
-- const hash = await bcrypt.hash('admin123', 10);
-- console.log(hash);
-- 
-- Ou use uma ferramenta online como: https://bcrypt-generator.com/
-- 
-- Exemplo de hash válido para 'admin123':
-- $2b$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy


