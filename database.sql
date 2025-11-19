-- ============================================================================
-- CBF ANTIDOPING - Script SQL para criar banco de dados MySQL
-- ============================================================================
-- Execute este script no seu banco MySQL para criar todas as tabelas
-- ============================================================================

-- Selecionar o banco
USE cbf_antidoping;

-- ============================================================================
-- TABELA: usuarios
-- ============================================================================
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `perfil` enum('admin','operacional') NOT NULL DEFAULT 'operacional',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABELA: sessions
-- ============================================================================
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABELA: atletas
-- ============================================================================
CREATE TABLE IF NOT EXISTS `atletas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `documento` varchar(255) NOT NULL,
  `clube` varchar(255) DEFAULT NULL,
  `federacao` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `atletas_documento_unique` (`documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABELA: testes
-- ============================================================================
CREATE TABLE IF NOT EXISTS `testes` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `atleta_id` bigint(20) UNSIGNED NOT NULL,
  `data_coleta` date NOT NULL,
  `competicao` varchar(255) DEFAULT NULL,
  `laboratorio` varchar(255) NOT NULL,
  `resultado` enum('pendente','negativo','positivo') NOT NULL DEFAULT 'pendente',
  `observacoes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testes_atleta_id_foreign` (`atleta_id`),
  CONSTRAINT `testes_atleta_id_foreign` FOREIGN KEY (`atleta_id`) REFERENCES `atletas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- INSERIR USUÁRIOS PADRÃO (OPCIONAL)
-- ============================================================================
-- Para criar os usuários, execute o arquivo criar_usuarios.sql
-- OU execute o script PHP: php criar_usuarios.php
--
-- Credenciais padrão:
--   Admin: admin@cbf.com.br / admin123
--   Operador: operador@cbf.com.br / operador123

-- ============================================================================
-- FIM DO SCRIPT
-- ============================================================================
-- Após executar, você pode testar o login:
-- Email: admin@cbf.com.br
-- Senha: admin123
-- ============================================================================

