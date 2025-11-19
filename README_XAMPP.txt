================================================================================
  INSTALAÇÃO NO XAMPP - PASSO A PASSO COMPLETO
================================================================================

1. INSTALAR XAMPP
   - Download: https://www.apachefriends.org/
   - Instale em C:\xampp
   - Abra o XAMPP Control Panel
   - Inicie Apache e MySQL

2. CRIAR BANCO DE DADOS
   - Acesse: http://localhost/phpmyadmin
   - Clique em "Novo" (criar banco)
   - Nome do banco: cbf_antidoping
   - Collation: utf8mb4_unicode_ci
   - Clique em "Criar"

3. CRIAR TABELAS
   - No phpMyAdmin, selecione o banco cbf_antidoping
   - Vá na aba "SQL"
   - Abra o arquivo database.sql
   - Copie TODO o conteúdo
   - Cole no SQL do phpMyAdmin
   - Clique em "Executar"

4. COPIAR ARQUIVOS
   - Copie TODOS os arquivos do projeto para: C:\xampp\htdocs\cbf\
   - OU execute o arquivo INSTALAR.bat (faz tudo automaticamente)

5. CRIAR USUÁRIOS
   
   OPÇÃO A - Via SQL (phpMyAdmin):
   - Abra inserir_usuarios.sql
   - Copie e cole no SQL do phpMyAdmin
   - Execute
   
   OPÇÃO B - Via Script PHP:
   - Abra o Prompt de Comando
   - cd C:\xampp\htdocs\cbf
   - php criar_usuarios.php

6. ACESSAR A APLICAÇÃO
   - Abra o navegador
   - Acesse: http://localhost/cbf/login.php
   
   LOGIN:
   - Email: admin@cbf.com.br
   - Senha: admin123

================================================================================

ESTRUTURA DE PASTAS NO XAMPP:
================================================================================

C:\xampp\htdocs\cbf\
├── config.php
├── Database.php
├── index.php
├── login.php
├── atletas.php
├── testes.php
├── usuarios.php
├── models/
├── controllers/
└── views/

================================================================================

VERIFICAR SE ESTÁ FUNCIONANDO:
================================================================================

1. Apache e MySQL devem estar rodando no XAMPP
2. Acesse: http://localhost/cbf/teste.php
   - Deve mostrar informações do PHP e conexão com banco
3. Acesse: http://localhost/cbf/login.php
   - Deve mostrar a tela de login

================================================================================

