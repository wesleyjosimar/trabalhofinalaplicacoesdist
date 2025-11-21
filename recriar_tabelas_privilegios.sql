-- Script SQL para recriar as tabelas de privilégios do MySQL
-- Execute este script após iniciar o MySQL em modo de recuperação

-- Recriar tabela db
CREATE TABLE IF NOT EXISTS `db` (
  `Host` char(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `Db` char(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `User` char(80) COLLATE utf8_bin NOT NULL DEFAULT '',
  `Select_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Insert_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Update_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Delete_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Drop_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Grant_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `References_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Index_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Alter_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_tmp_table_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Lock_tables_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_view_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Show_view_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_routine_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Alter_routine_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Execute_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Event_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Trigger_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  PRIMARY KEY (`Host`,`Db`,`User`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database privileges';

-- Recriar tabela user (estrutura básica)
CREATE TABLE IF NOT EXISTS `user` (
  `Host` char(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `User` char(80) COLLATE utf8_bin NOT NULL DEFAULT '',
  `Password` char(41) COLLATE utf8_bin NOT NULL DEFAULT '',
  `Select_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Insert_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Update_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Delete_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Drop_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Reload_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Shutdown_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Process_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `File_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Grant_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `References_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Index_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Alter_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Show_db_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Super_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_tmp_table_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Lock_tables_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Execute_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Repl_slave_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Repl_client_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_view_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Show_view_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_routine_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Alter_routine_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_user_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Event_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Trigger_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_tablespace_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `ssl_type` enum('','ANY','X509','SPECIFIED') COLLATE utf8_bin NOT NULL DEFAULT '',
  `ssl_cipher` blob NOT NULL,
  `x509_issuer` blob NOT NULL,
  `x509_subject` blob NOT NULL,
  `max_questions` int(11) unsigned NOT NULL DEFAULT 0,
  `max_updates` int(11) unsigned NOT NULL DEFAULT 0,
  `max_connections` int(11) unsigned NOT NULL DEFAULT 0,
  `max_user_connections` int(11) unsigned NOT NULL DEFAULT 0,
  `plugin` char(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `authentication_string` text COLLATE utf8_bin NOT NULL,
  `password_expired` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `password_last_changed` timestamp NULL DEFAULT NULL,
  `password_lifetime` smallint(5) unsigned DEFAULT NULL,
  `account_locked` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  PRIMARY KEY (`Host`,`User`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and global privileges';

-- Inserir usuário root padrão (sem senha)
INSERT IGNORE INTO `user` (`Host`, `User`, `Password`, `Select_priv`, `Insert_priv`, `Update_priv`, `Delete_priv`, `Create_priv`, `Drop_priv`, `Reload_priv`, `Shutdown_priv`, `Process_priv`, `File_priv`, `Grant_priv`, `References_priv`, `Index_priv`, `Alter_priv`, `Show_db_priv`, `Super_priv`, `Create_tmp_table_priv`, `Lock_tables_priv`, `Execute_priv`, `Repl_slave_priv`, `Repl_client_priv`, `Create_view_priv`, `Show_view_priv`, `Create_routine_priv`, `Alter_routine_priv`, `Create_user_priv`, `Event_priv`, `Trigger_priv`, `Create_tablespace_priv`) VALUES
('localhost', 'root', '', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
('127.0.0.1', 'root', '', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
('::1', 'root', '', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
('localhost', '', '', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N');

-- Recriar tabela host
CREATE TABLE IF NOT EXISTS `host` (
  `Host` char(60) COLLATE utf8_bin NOT NULL DEFAULT '',
  `Db` char(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `Select_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Insert_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Update_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Delete_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Drop_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Grant_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `References_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Index_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Alter_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_tmp_table_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Lock_tables_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_view_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Show_view_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Create_routine_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Alter_routine_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Execute_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  `Trigger_priv` enum('N','Y') COLLATE utf8_bin NOT NULL DEFAULT 'N',
  PRIMARY KEY (`Host`,`Db`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Host privileges;  Merged with database privileges';

