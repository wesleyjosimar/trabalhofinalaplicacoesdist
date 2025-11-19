# 🏆 CBF - Sistema de Cadastro de Atletas e Testes Antidoping

Sistema web simples desenvolvido em **PHP puro** (sem frameworks) para gerenciamento de atletas e testes antidoping da Confederação Brasileira de Futebol (CBF).

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

### 2. Testes Antidoping
- Registrar testes antidoping
- Editar resultado dos testes
- Listagem com filtros por atleta
- Histórico completo por atleta

### 3. Controle de Usuários
- Login com email e senha
- Dois perfis: Admin e Operacional
- Admin pode gerenciar usuários
- Operacional não pode gerenciar usuários

## 🚀 Instalação no CWP (CentOS Web Panel)

### 1. Copiar arquivos
Copie toda a pasta `php_puro/` para `public_html/` no servidor.

### 2. Configurar banco de dados
Edite `php_puro/config.php` e ajuste as credenciais:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'amorexpr_teste');
define('DB_USER', 'amorexpr_admin');
define('DB_PASS', 'Testando@09');
```

### 3. Criar tabelas no banco
Execute o arquivo `database.sql` no phpMyAdmin do CWP.

### 4. Criar usuários padrão
No Terminal SSH do CWP:
```bash
cd /home/usuario/public_html
php criar_usuarios.php
```

### 5. Acessar a aplicação
- URL: `https://teste.amorexpress.com.br/login.php`
- **Login padrão:**
  - Email: `admin@cbf.com.br`
  - Senha: `admin123`

## 📁 Estrutura do Projeto

```
.
├── php_puro/                 # Aplicação PHP pura
│   ├── config.php            # Configurações
│   ├── Database.php          # Conexão com banco
│   ├── index.php             # Página inicial
│   ├── login.php             # Login
│   ├── logout.php            # Logout
│   ├── atletas.php           # CRUD Atletas
│   ├── testes.php            # CRUD Testes
│   ├── usuarios.php          # CRUD Usuários
│   ├── criar_usuarios.php    # Script para criar usuários
│   ├── models/               # Modelos
│   ├── controllers/          # Controllers
│   └── views/               # Views HTML
├── database.sql              # Script SQL para criar tabelas
└── README.md                 # Este arquivo
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

## 📝 Licença

Este projeto foi desenvolvido para a Confederação Brasileira de Futebol (CBF).

