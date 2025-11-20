# 🏆 CBF - Sistema de Cadastro de Atletas e Testes Antidoping

Sistema web desenvolvido em **PHP puro** (sem frameworks) para gerenciamento de atletas e testes antidoping da Confederação Brasileira de Futebol (CBF).

## 📋 Características

- **Stack Simples**: PHP 7.4+ puro, sem frameworks
- **Banco de Dados**: MySQL
- **Arquitetura**: MVC simples e direta
- **Autenticação**: Sistema de sessão PHP nativo
- **Interface**: Design limpo e responsivo
- **Deploy**: Hospedagem PHP tradicional (CWP, cPanel, Apache/Nginx)

## 🎯 Funcionalidades

### 1. Cadastro de Atletas
- Criar, listar, editar e inativar atletas
- Campos: nome, data de nascimento, documento, clube, federação, status
- Busca por nome ou documento
- Filtro por status (ativo/inativo)

### 2. Testes Antidoping
- Registrar testes antidoping
- Editar resultado dos testes
- Listagem com filtros por atleta e resultado
- Histórico completo por atleta

### 3. Relatórios
- Dashboard com estatísticas gerais
- Filtros por resultado e período
- Exportação para CSV

### 4. Controle de Usuários
- Login com email e senha
- Dois perfis: Admin e Operacional
- Admin pode gerenciar usuários
- Operacional não pode gerenciar usuários

## 🚀 Instalação

### Opção 1: XAMPP (Local)

1. **Instalar XAMPP**
   - Download: https://www.apachefriends.org/
   - Instale e inicie Apache + MySQL

2. **Criar banco de dados**
   - Acesse: `http://localhost/phpmyadmin`
   - Crie o banco: `cbf_antidoping`
   - Execute o arquivo `database.sql`

3. **Copiar arquivos**
   - Copie todos os arquivos para: `C:\xampp\htdocs\cbf\`

4. **Configurar**
   - Edite `config.php` se necessário (padrão: root/sem senha)

5. **Criar usuários**
   - Acesse: `http://localhost/cbf/testar_banco.php`
   - OU execute: `php criar_usuarios.php`

6. **Acessar**
   - URL: `http://localhost/cbf/login.php`
   - Login: `admin@cbf.com.br` / `admin123`

### Opção 2: CWP (Produção)

1. **Copiar arquivos**
   - Copie todos os arquivos para `public_html/teste.amorexpress.com.br/`

2. **Configurar banco**
   - Edite `config.php` com as credenciais do banco
   - Execute `database.sql` no phpMyAdmin

3. **Criar usuários**
   - Execute `inserir_usuarios.sql` no phpMyAdmin
   - OU execute: `php criar_usuarios.php` via SSH

## 📁 Estrutura do Projeto

```
.
├── config.php              # Configurações
├── Database.php            # Conexão com banco
├── index.php               # Página inicial
├── login.php               # Login
├── logout.php             # Logout
├── atletas.php            # CRUD Atletas
├── testes.php             # CRUD Testes
├── relatorios.php         # Relatórios
├── usuarios.php           # CRUD Usuários
├── criar_usuarios.php     # Script para criar usuários
├── teste.php              # Diagnóstico do sistema
├── testar_banco.php       # Teste de conexão e usuários
├── database.sql           # Script SQL para criar tabelas
├── inserir_usuarios.sql   # SQL para inserir usuários padrão
├── models/                # Modelos
├── controllers/           # Controllers
└── views/                 # Views HTML
```

## 🔒 Segurança

- Senhas hasheadas com `password_hash()` (bcrypt)
- Verificação de autenticação em todas as páginas
- Verificação de perfil admin para gestão de usuários
- Proteção contra SQL Injection (PDO prepared statements)
- Escape de HTML (`htmlspecialchars`)

## 📦 Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Extensões PHP: PDO, PDO_MySQL

## 📝 Credenciais Padrão

- **Admin**: `admin@cbf.com.br` / `admin123`
- **Operador**: `operador@cbf.com.br` / `operador123`

## 📄 Documentação Adicional

- `PLANEJAMENTO_IMPLANTACAO.md` - Documento completo de planejamento para aplicação distribuída

## 📝 Licença

Este projeto foi desenvolvido para a Confederação Brasileira de Futebol (CBF).
