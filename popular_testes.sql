-- ============================================================================
-- POPULAR BANCO COM TESTES ANTIDOPING
-- ============================================================================
-- Execute este script no phpMyAdmin APÓS popular os atletas
-- ============================================================================

USE cbf_antidoping;

-- Primeiro, vamos buscar os IDs dos atletas (ajuste conforme seus atletas)
-- Exemplo: Assumindo que os atletas têm IDs de 1 a 10

-- Testes para diferentes atletas
INSERT INTO testes (atleta_id, data_coleta, competicao, laboratorio, resultado, observacoes, created_at, updated_at) VALUES
-- Atleta 1 (Neymar)
(1, '2023-01-15', 'Copa do Mundo 2022', 'LADETEC - UFRJ', 'negativo', 'Teste de rotina', NOW(), NOW()),
(1, '2023-06-20', 'Copa América 2021', 'WADA Accredited Lab - Montreal', 'negativo', NULL, NOW(), NOW()),
(1, '2023-11-10', 'Eliminatórias Copa do Mundo', 'Laboratório Brasileiro de Controle de Dopagem', 'pendente', NULL, NOW(), NOW()),

-- Atleta 2 (Gabriel Jesus)
(2, '2023-02-20', 'Campeonato Brasileiro 2023', 'LADETEC - USP', 'negativo', 'Teste de rotina', NOW(), NOW()),
(2, '2023-08-15', 'Copa Libertadores 2023', 'Laboratório Antidoping - CBF', 'negativo', NULL, NOW(), NOW()),

-- Atleta 3 (Casemiro)
(3, '2023-03-10', 'Copa do Mundo 2022', 'LADETEC - UFRJ', 'negativo', 'Teste de rotina', NOW(), NOW()),
(3, '2023-09-25', 'Amistoso Internacional', 'WADA Accredited Lab - Montreal', 'negativo', NULL, NOW(), NOW()),
(3, '2023-12-05', 'Eliminatórias Copa do Mundo', 'Laboratório Brasileiro de Controle de Dopagem', 'pendente', NULL, NOW(), NOW()),

-- Atleta 4 (Alisson)
(4, '2023-04-05', 'Campeonato Brasileiro 2023', 'LADETEC - USP', 'negativo', 'Teste de rotina', NOW(), NOW()),
(4, '2023-10-18', 'Copa do Brasil 2023', 'Laboratório Antidoping - CBF', 'negativo', NULL, NOW(), NOW()),

-- Atleta 5 (Marquinhos)
(5, '2023-05-12', 'Copa Libertadores 2023', 'LADETEC - UFRJ', 'negativo', 'Teste de rotina', NOW(), NOW()),
(5, '2023-07-30', 'Campeonato Estadual 2023', 'WADA Accredited Lab - Montreal', 'negativo', NULL, NOW(), NOW()),
(5, '2023-11-22', 'Eliminatórias Copa do Mundo', 'Laboratório Brasileiro de Controle de Dopagem', 'pendente', NULL, NOW(), NOW()),

-- Atleta 6 (Vinicius Junior)
(6, '2023-01-25', 'Copa do Mundo 2022', 'LADETEC - USP', 'negativo', 'Teste de rotina', NOW(), NOW()),
(6, '2023-06-10', 'Copa América 2021', 'Laboratório Antidoping - CBF', 'negativo', NULL, NOW(), NOW()),

-- Atleta 7 (Rodrygo)
(7, '2023-02-15', 'Campeonato Brasileiro 2023', 'LADETEC - UFRJ', 'negativo', 'Teste de rotina', NOW(), NOW()),
(7, '2023-08-20', 'Copa Libertadores 2023', 'WADA Accredited Lab - Montreal', 'negativo', NULL, NOW(), NOW()),
(7, '2023-12-15', 'Eliminatórias Copa do Mundo', 'Laboratório Brasileiro de Controle de Dopagem', 'pendente', NULL, NOW(), NOW()),

-- Atleta 8 (Raphinha)
(8, '2023-03-20', 'Amistoso Internacional', 'LADETEC - USP', 'negativo', 'Teste de rotina', NOW(), NOW()),
(8, '2023-09-10', 'Copa do Brasil 2023', 'Laboratório Antidoping - CBF', 'negativo', NULL, NOW(), NOW()),

-- Atleta 9 (Bruno Guimarães)
(9, '2023-04-18', 'Campeonato Estadual 2023', 'LADETEC - UFRJ', 'negativo', 'Teste de rotina', NOW(), NOW()),
(9, '2023-10-05', 'Eliminatórias Copa do Mundo', 'WADA Accredited Lab - Montreal', 'negativo', NULL, NOW(), NOW()),
(9, '2023-11-30', 'Copa Libertadores 2023', 'Laboratório Brasileiro de Controle de Dopagem', 'pendente', NULL, NOW(), NOW()),

-- Atleta 10 (Richarlison)
(10, '2023-05-25', 'Copa do Mundo 2022', 'LADETEC - USP', 'negativo', 'Teste de rotina', NOW(), NOW()),
(10, '2023-07-15', 'Copa América 2021', 'Laboratório Antidoping - CBF', 'negativo', NULL, NOW(), NOW());

-- ============================================================================
-- FIM
-- ============================================================================
-- NOTA: Ajuste os IDs dos atletas (atleta_id) conforme os IDs reais no seu banco
-- ============================================================================

