-- ============================================================================
-- POPULAR BANCO COM ATLETAS DE EXEMPLO
-- ============================================================================
-- Execute este script no phpMyAdmin para inserir 10 atletas de exemplo
-- ============================================================================

USE cbf_antidoping;

-- Inserir 10 atletas de exemplo
INSERT INTO atletas (nome, data_nascimento, documento, clube, federacao, status, created_at, updated_at) VALUES
('Neymar da Silva Santos Júnior', '1992-02-05', '12345678901', 'Al-Hilal', 'CBF', 'ativo', NOW(), NOW()),
('Gabriel Jesus', '1997-04-03', '23456789012', 'Arsenal', 'CBF', 'ativo', NOW(), NOW()),
('Casemiro', '1992-02-23', '34567890123', 'Manchester United', 'CBF', 'ativo', NOW(), NOW()),
('Alisson Becker', '1992-10-02', '45678901234', 'Liverpool', 'CBF', 'ativo', NOW(), NOW()),
('Marquinhos', '1994-05-14', '56789012345', 'Paris Saint-Germain', 'CBF', 'ativo', NOW(), NOW()),
('Vinicius Junior', '2000-07-12', '67890123456', 'Real Madrid', 'CBF', 'ativo', NOW(), NOW()),
('Rodrygo Goes', '2001-01-09', '78901234567', 'Real Madrid', 'CBF', 'ativo', NOW(), NOW()),
('Raphinha', '1996-12-14', '89012345678', 'Barcelona', 'CBF', 'ativo', NOW(), NOW()),
('Bruno Guimarães', '1997-11-16', '90123456789', 'Newcastle United', 'CBF', 'ativo', NOW(), NOW()),
('Richarlison', '1997-05-10', '01234567890', 'Tottenham', 'CBF', 'ativo', NOW(), NOW());

-- ============================================================================
-- FIM
-- ============================================================================

